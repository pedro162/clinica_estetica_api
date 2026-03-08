<?php

namespace App\Impressao;

use App\Impressao\Legacy\Common;
use App\Impressao\Legacy\Pdf;

class FichaAnamnese extends Common
{
    public const FPDF_FONTPATH = 'font/';

    /**
     * alinhamento padrão do logo (C-Center)
     *
     * @var string
     */
    public $logoAlign = 'C';
    /**
     * Posição
     * @var float
     */
    public $yDados = 0;
    /**
     * Situação
     * @var integer
     */
    public $situacaoExterna = 0;
    /**
     * Numero DPEC
     *
     * @var string
     */
    public $numero_registro_dpec = '';
    /**
     * quantidade de canhotos a serem montados, geralmente 1 ou 2
     *
     * @var integer
     */
    public $qCanhoto = 1;

    //###########################################################
    // INÍCIO ATRIBUTOS DE PARÂMETROS DE EXIBIÇÃO
    //###########################################################

    /**
     * Parâmetro para exibir ou ocultar os valores do PIS/COFINS.
     * @var boolean
     */
    public $exibirVenda = false;
    /**
     * Parâmetro para exibir ou ocultar os valores do ICMS Interestadual e Valor Total dos Impostos.
     * @var boolean
     */
    public $exibirIcmsInterestadual = true;
    /**
     * Parâmetro para exibir ou ocultar o texto sobre valor aproximado dos tributos.
     * @var boolean
     */
    public $exibirValorTributos = true;
    /**
     * Parâmetro para exibir ou ocultar o texto adicional sobre a forma de pagamento
     * e as informações de fatura/duplicata.
     * @var boolean
     */
    public $exibirTextoFatura = false;
    /**
     * Parâmetro do controle se deve concatenar automaticamente informações complementares
     * na descrição do produto, como por exemplo, informações sobre impostos.
     * @var boolean
     */
    public $descProdInfoComplemento = true;
    /**
     * Parâmetro do controle se deve gerar quebras de linha com "\n" a partir de ";" na descrição do produto.
     * @var boolean
     */
    public $descProdQuebraLinha = true;

    //###########################################################
    //PROPRIEDADES DA CLASSE
    //###########################################################

    /**
     * objeto fpdf()
     * @var object
     */
    protected $pdf;
    /**
     * XML NFe
     * @var string
     */
    protected $xml;
    /**
     * path para logomarca em jpg
     * @var string
     */
    protected $logomarca = '';

    protected $logomarcamarcadagua;
    /**
     * mesagens de erro
     * @var string
     */
    protected $errMsg = '';
    /**
     * status de erro true um erro ocorreu false sem erros
     * @var boolean
     */
    protected $errStatus = false;
    /**
     * orientação da DANFE
     * P-Retrato ou L-Paisagem
     * @var string
     */
    protected $orientacao = 'P';
    /**
     * formato do papel
     * @var string
     */
    protected $papel = 'A4';
    /**
     * destino do arquivo pdf
     * I-borwser, S-retorna o arquivo, D-força download, F-salva em arquivo local
     * @var string
     */
    protected $destino = 'I';
    /**
     * diretorio para salvar o pdf com a opção de destino = F
     * @var string
     */
    protected $pdfDir = '';
    /**
     * Nome da Fonte para gerar o DANFE
     * @var string
     */
    protected $fontePadrao = 'Arial';
    /**
     * versão
     * @var string
     */
    protected $version = '2.2.8';
    /**
     * Texto
     * @var string
     */
    protected $textoAdic = '';
    /**
     * Largura
     * @var float
     */
    protected $wAdic = 0;
    /**
     * largura imprimivel, em milímetros
     * @var float
     */
    protected $wPrint;
    /**
     * Comprimento (altura) imprimivel, em milímetros
     * @var float
     */
    protected $hPrint;
    /**
     * largura do canhoto (25mm) apenas para a formatação paisagem
     * @var float
     */
    protected $wCanhoto = 25;

    /**
     * quantidade de itens já processados na montagem do DANFE
     * @var integer
     */
    protected $qtdeItensProc;


    protected $debugMode = 2;
    /**
     * Creditos para integrador
     * @var string
     */
    protected $creditos = '';

    protected $valorTotalTabela = 0;
    protected $valorTotalDesconto = 0;
    protected $valorTotalLiquido = 0;

    /**
     * __construct
     *
     * @name  __construct
     * @param string  $docXML      Conteúdo XML da NF-e (com ou sem a tag nfeProc)
     * @param string  $sOrientacao (Opcional) Orientação da impressão P-retrato L-Paisagem
     * @param string  $sPapel      Tamanho do papel (Ex. A4)
     * @param string  $sPathLogo   Caminho para o arquivo do logo
     * @param string  $sDestino    Estabelece a direção do envio do documento PDF I-browser D-browser com download S-
     * @param string  $sDirPDF     Caminho para o diretorio de armazenamento dos arquivos PDF
     * @param string  $fonteDANFE  Nome da fonte alternativa do DAnfe
     * @param integer $mododebug   0-Não 1-Sim e 2-nada (2 default)
     */
    public function __construct($dadosArr, $sPathLogo = '')
    {
        $sOrientacao = 'P';
        $sPapel = '';
        $sDestino = 'I';
        $sDirPDF = '';
        $fonteDANFE = '';
        $mododebug = 2;
        $sPathLogoMarcadagua = '';

        //set_time_limit(1800);
        if (is_numeric($mododebug)) {
            $this->debugMode = $mododebug;
        }
        if ($mododebug == 1) {
            //ativar modo debug
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        }
        if ($mododebug == 0) {
            //desativar modo debug
            error_reporting(0);
            ini_set('display_errors', 'Off');
        }
        $this->orientacao   = $sOrientacao;
        $this->papel        = $sPapel;
        $this->pdf          = '';
        $this->logomarca    = $sPathLogo;
        $this->dadosArr     = $dadosArr;
        $this->logomarcamarcadagua    = $sPathLogoMarcadagua;
        $this->destino      = $sDestino;
        $this->pdfDir       = $sDirPDF;
        // verifica se foi passa a fonte a ser usada
        if (empty($fonteDANFE)) {
            $this->fontePadrao = 'Arial';
        } else {
            $this->fontePadrao = $fonteDANFE;
        }
    }


    /**
     * printDocument
     *
     * @param  string $nome
     * @param  string $destino
     * @param  string $printer
     * @return object pdf
     */
    public function printDocument($nome = '', $destino = 'I', $printer = '')
    {
        $arq = $this->pdf->Output($nome, $destino);
        if ($destino == 'S') {
            //aqui pode entrar a rotina de impressão direta
        }
        return $arq;
    }

    /**
     * montaDANFE
     * Monta a DANFE conforme as informações fornecidas para a classe durante sua
     * construção. Constroi DANFEs com até 3 páginas podendo conter até 56 itens.
     * A definição de margens e posições iniciais para a impressão são estabelecidas
     * pelo conteúdo da funçao e podem ser modificados.
     *
     * @param  string $orientacao (Opcional) Estabelece a orientação da impressão
     *  (ex. P-retrato), se nada for fornecido será usado o padrão da NFe
     * @param  string $papel      (Opcional) Estabelece o tamanho do papel (ex. A4)
     * @return string O ID da NFe numero de 44 digitos extraido do arquivo XML
     */
    public function montaMapa($classPdf = false)
    {
        $orientacao = 'P';
        $papel = 'A4';
        $logoAlign = 'C';


        $depecNumReg = '';
        $margSup = 2;
        $margEsq = 2;
        $margInf = 2;
        //se a orientação estiver em branco utilizar o padrão estabelecido na NF

        if ($orientacao == '') {
            if ($this->tpImp == '1') {
                $orientacao = 'P';
            } else {
                $orientacao = 'L';
            }
        }
        $this->orientacao = $orientacao;
        $this->papel = $papel;
        $this->logoAlign = $logoAlign;

        $this->numero_registro_dpec = $depecNumReg;
        //instancia a classe pdf
        if ($classPdf) {
            $this->pdf = $classPdf;
        } else {
            $this->pdf = new Pdf($this->orientacao, 'mm', $this->papel);
        }
        //margens do PDF, em milímetros. Obs.: a margem direita é sempre igual à
        //margem esquerda. A margem inferior *não* existe na FPDF, é definida aqui
        //apenas para controle se necessário ser maior do que a margem superior
        // posição inicial do conteúdo, a partir do canto superior esquerdo da página
        $xInic = $margEsq;
        $yInic = $margSup;
        if ($this->orientacao == 'P') {
            if ($papel == 'A4') {
                $maxW = 210;
                $maxH = 297;
            }
        } else {
            if ($papel == 'A4') {
                $maxH = 210;
                $maxW = 297;
                //se paisagem multiplica a largura do canhoto pela quantidade de canhotos
                $this->wCanhoto *= $this->qCanhoto;
            }
        }
        //total inicial de paginas
        $totPag = 1;
        //largura imprimivel em mm: largura da folha menos as margens esq/direita
        $this->wPrint = $maxW - ($margEsq * 2);
        //comprimento (altura) imprimivel em mm: altura da folha menos as margens
        //superior e inferior
        $this->hPrint = $maxH - $margSup - $margInf;
        // estabelece contagem de paginas
        $this->pdf->aliasNbPages();
        // fixa as margens
        $this->pdf->setMargins($margEsq, $margSup);
        $this->pdf->setDrawColor(0, 0, 0);
        $this->pdf->setFillColor(255, 255, 255);
        // inicia o documento
        $this->pdf->open();
        // adiciona a primeira página
        $this->pdf->addPage($this->orientacao, $this->papel);
        $this->pdf->setLineWidth(0.1);
        $this->pdf->setTextColor(0, 0, 0);

        $fontProduto = ['font' => $this->fontePadrao, 'size' => 7, 'style' => ''];

        $this->textoAdic = '';
        //altura disponivel para os campos da DANFE
        $hcabecalho = 60; //para cabeçalho
        $hCabecItens = 4; //cabeçalho dos itens
        //alturas disponiveis para os dados
        $hDispo1 = 240; //dados produtos pag 1

        $hDispo2 = 239; //dados produtos pag  . 2
        //Contagem da altura ocupada para impressão dos itens
        $fontProduto = ['font' => $this->fontePadrao, 'size' => 7, 'style' => ''];
        $i = 0;
        $numlinhas = 0;
        $hUsado = $hCabecItens;
        $w2 = round($this->wPrint * 0.47, 0);
        $hDispo = $hDispo1;
        $totPag = 1;
        $diferenca = 0;

        $this->espacoDados = $hDispo1;

        $produtosArmazem = $this->dadosArr['itens'];


        //-------------------------------------------------------------------------------------------------------------
        if (is_array($produtosArmazem)) {
            $hUsado += 4;
            foreach ($produtosArmazem as $idArmazem => $produtosAgrupados) {
                $texto = $produtosAgrupados['registro'];




                $numlinhas = $this->pdf->getNumLines($texto, $w2, $fontProduto);
                $hUsado += round(($numlinhas * $this->pdf->fontSize) + ($numlinhas * 0.35), 2);
                //$hUsado += round(($numlinhas * $this->pdf->fontSize) + ($numlinhas * 0.35), 2);

                if ($hUsado > $hDispo) {
                    $totPag++;
                    $hDispo = $hDispo2;
                    $hUsado = $hCabecItens;
                    // Remove canhoto para páginas secundárias em modo paisagem ('L')
                    $w2 = round($this->wPrint * 0.28, 0);
                    $i--; // decrementa para readicionar o item que não coube nessa pagina na outra.
                }
                $i++;
            }
        }

        //$totPag = 4;



        //fim da soma das areas de itens usadas
        $qtdeItens = $i; //controle da quantidade de itens no DANFE
        $this->espacoDados = $hDispo;
        $this->totpag = $totPag;



        //montagem da primeira página
        $this->currentpag = $pag = 1;
        $x = $xInic;
        $y = $yInic;

        //coloca o cabeçalho



        $y = $this->pCabecalhoMapa($x, $y, $pag, $totPag);

        //$y = $this->pItens($x, $y, $nInicial, $hDispo1, $pag, $totPag, $hCabecItens);
        //$y = $this->pAgrupadosPedidos($x, $y, $nInicial, $hDispo1, $pag, $totPag, $hCabecItens);
        //******************************************************************************************
        //die();
        //$y = $this->pRodape($x, $y+2);
        //$y = $this->pAssinaturas($xInic,$y);

        $agendamentosArr = $this->dadosArr['itens'];
        $n = null;

        if (is_array($agendamentosArr)) {
            $y += 5;
            $y = $this->pItensDANFE($x, $y, $nInicial, $hDispo1, $pag, $totPag, $hCabecItens);
            $y += 5;

            if (count($agendamentosArr) > $nInicial) {
                //loop para páginas seguintes
                //for ($n = 2; $n <= $totPag; $n++) {
                while (count($agendamentosArr) > $nInicial) {
                    // fixa as margens
                    $this->pdf->setMargins($margEsq, $margSup);
                    //adiciona nova página
                    $this->pdf->addPage($this->orientacao, $this->papel);
                    //ajusta espessura das linhas
                    $this->pdf->setLineWidth(0.1);
                    //seta a cor do texto para petro
                    $this->pdf->setTextColor(0, 0, 0);
                    // posição inicial do relatorio
                    $x = $xInic;
                    $y = $yInic;
                    //coloca o cabeçalho na página adicional
                    $y = $this->pCabecalhoMapa($x, $y, $n, $totPag);
                    $y += 5;
                    //coloca os itens na página adicional
                    $y = $this->pItensDANFE($x, $y + 1, $nInicial, $hDispo2, $n, $totPag, $hCabecItens);
                    //coloca o rodapé da página

                    //$this->pRodape($xInic, $y + 5);


                    //se estiver na última página e ainda restar itens para inserir, adiciona mais uma página
                    if ($n == $totPag && $this->qtdeItensProc < $qtdeItens) {
                        $totPag++;
                    }
                }
            }
        }

        $this->pRodape($x, $y + 2);



        /**/
    } //fim da função montaDANFE


    /**
     * Dados brutos do PDF
     * @return string
     */
    public function render()
    {
        return $this->pdf->getPdf();
    }



    /**
     *cabecalhoDANFE
     * Monta o cabelhalho da DANFE (retrato e paisagem)
     *
     * @param  number $x      Posição horizontal inicial, canto esquerdo
     * @param  number $y      Posição vertical inicial, canto superior
     * @param  number $pag    Número da Página
     * @param  number $totPag Total de páginas
     * @return number Posição vertical final
     */

    protected function pCabecalhoMapa($x = 0, $y = 0, $pag = '1', $totPag = '1')
    {
        //https://produto.mercadolivre.com.br/MLB-1033967825-ficha-de-anamnese-estetica-bloco-com-100-folhas-_JM?matt_tool=58942467&matt_word=&matt_source=google&matt_campaign_id=14303385293&matt_ad_group_id=123813170097&matt_match_type=&matt_network=g&matt_device=c&matt_creative=539491049432&matt_keyword=&matt_ad_position=&matt_ad_type=pla&matt_merchant_id=5068529360&matt_product_id=MLB1033967825&matt_product_partition_id=1805008106812&matt_target_id=aud-1966857867496:pla-1805008106812&gclid=CjwKCAjw6p-oBhAYEiwAgg2PghBg7gXB5f1PXmSxZQx3dxbPk6zPW3j1_ep6VA_trBbSWKKSoJQRSRoCNAkQAvD_BwE#&gid=1&pid=1
        //https://github.com/nfephp-org/sped-da/blob/master/src/Legacy/Pdf.php
        $dtInicial = $this->dadosArr['dtInicial'];
        $dtFinal = $this->dadosArr['dtFinal'];

        $oldX = $x;
        $oldY = $y;
        if ($this->orientacao == 'P') {
            $maxW = $this->wPrint;
        } else {
            if ($pag == 1) { // primeira página
                $maxW = $this->wPrint - $this->wCanhoto;
            } else { // páginas seguintes
                $maxW = $this->wPrint;
            }
        }
        //####################################################################################
        //coluna esquerda identificação do emitente
        $w = round($maxW * 1, 0); //35;0.81
        if (is_file($this->logomarca)) {
            $w = round($maxW * 0.81, 0);
        }
        if ($this->orientacao == 'P') {
            $aFont = ['font' => $this->fontePadrao, 'size' => 7, 'style' => 'I'];
        } else {
            $aFont = ['font' => $this->fontePadrao, 'size' => 8, 'style' => 'B'];
        }
        $w1 = $w;
        $h = 60; //30;
        $oldY += $h;
        //$this->pdf->textBox($x, $y, $w, $h);
        // $texto = 'IDENTIFICAÇÃO DO EMITENTE';
        //$this->pdf->textBox($x, $y, $w, 5, $texto, $aFont, 'T', 'C', 0, '');
        //estabelecer o alinhamento
        //pode ser left L, center C, right R, full logo L
        //se for left separar 1/3 da largura para o tamanho da imagem
        //os outros 2/3 serão usados para os dados do emitente
        //se for center separar 1/2 da altura para o logo e 1/2 para os dados
        //se for right separa 2/3 para os dados e o terço seguinte para o logo
        //se não houver logo centraliza dos dados do emitente
        // coloca o logo
        if (is_file($this->logomarca)) {
            $logoInfo = getimagesize($this->logomarca);
            //largura da imagem em mm
            $logoWmm = ($logoInfo[0] / 72) * 25.4;
            //altura da imagem em mm
            $logoHmm = ($logoInfo[1] / 72) * 25.4;
            $nImgW = 12;
            $nImgH = 12;
            $xImg = $x + 1;
            $yImg = $y - 15;


            //estabelecer posições do texto
            $x1 = round($xImg + $nImgW + 1, 0) + 3;
            $y1 = round($h / 3 + $y, 0) - 6;
            $tw = round(2 * $w / 3, 0);

            $yImg = $yImg + 15;
            $this->pdf->Image($this->logomarca, $xImg, $yImg, $nImgW, $nImgH);


            $aFont = ['font' => $this->fontePadrao, 'size' => 15, 'style' => ''];
            $texto = 'Espaço beleza';
            //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
            $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'L', 1, '');
            //echo ($tw) . '<br/>';
            //echo ($x1) . '<br/>';

            $nextX = $x1 + $tw;
            $x1 = $nextX;
            //echo ($x1) . '<br/>';
            //die();


            //$y1 +=10;
            $aFont = ['font' => $this->fontePadrao, 'size' => 15, 'style' => 'B'];
            $texto = 'Registros de Atendimentos';
            //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
            $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'L', 1, '');

            /* echo ($tw) . '<br/>';
            echo ($x1) . '<br/>'; */

            $nextX = $x1 + $tw;
            $x1 = $nextX;
            /* echo ($x1) . '<br/>';
            die(); */
            //$y1 +=10;
            $aFont = ['font' => $this->fontePadrao, 'size' => 15, 'style' => ''];
            $texto = 'Data ' . $dtInicial . ' até ' . $dtFinal;
            //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
            $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'L', 1, '');
        } else {
            $x1 = $x;
            $y1 = round($h / 3 + $y, 0) - 20;
            $tw = round($w * 0.40);

            $aFont = ['font' => $this->fontePadrao, 'size' => 15, 'style' => ''];
            $texto = 'Espaço beleza';
            //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
            $this->pdf->textBox($x1, $y1, $tw, 20, $texto, $aFont, 'C', 'L', 1, '');
            //echo ($tw) . '<br/>';
            //echo ($x1) . '<br/>';

            $nextX = $x1 + $tw;
            $x1 = $nextX;
            $tw = round($w * 0.40);

            //$y1 +=10;
            $aFont = ['font' => $this->fontePadrao, 'size' => 14, 'style' => 'B'];
            $texto = "Estética Facial\n\rFicha de anamnese";
            //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
            $this->pdf->textBox($x1, $y1, $tw, 20, $texto, $aFont, 'C', 'C', 1, '');


            /* echo ($tw) . '<br/>';
            echo ($x1) . '<br/>'; */

            $nextX = $x1 + $tw;
            $x1 = $nextX;
            $tw = round($w * 0.205);

            /* echo ($x1) . '<br/>';
            die(); */
            //$y1 +=10;
            $aFont = ['font' => $this->fontePadrao, 'size' => 10, 'style' => ''];
            $texto = 'Data ' . $dtInicial;
            //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
            $this->pdf->textBox($x1, $y1, $tw, 20, $texto, $aFont, 'C', 'L', 1, '');
        }
        // monta as informações apenas se diferente de full logo
        /*
        *   $texto = "Código";
            $w1 = round($w * 0.10, 0);
            $h = 6;
            $aFont = array('font' => $this->fontePadrao, 'size' => 9, 'style' => 'B');
            $this->pdf->textBox($x, $y, $w1, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

            //DESCRIÇÃO DO PRODUTO / SERVIÇO
            $x += $w1;
            $w2 = round($w * 0.54, 0);
            $texto = 'Registro de atendimento ';

            $this->pdf->textBox($x, $y, $w2, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);
            //QUANT
            $x += $w2;
            $w3 = round($w * 0.12, 0);
            $texto = 'Data';

            $this->pdf->textBox($x, $y, $w3, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

            //UN
            $x += $w3;
            $w4 = round($w * 0.12, 0);
            $texto = 'Horário';

            $this->pdf->textBox($x, $y, $w4, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

            //VALOR TABELA
            $x += $w4;
            $w5 = round($w * 0.12, 0);
            $texto = 'Pago';
        */
        //Nome emitente








        //$y1 = $y1+12;
        $x1 = $x;
        $y1 += 20;
        $this->pdf->Line($x, $y1, $x + $maxW, $y1);
        $y1 += 2;

        //----------Nome completo e nascimento -----------------
        $nextX = $x1;
        $x1 = $nextX;
        $tw = round($w * 0.40);

        //Nome emitente
        $aFont = ['font' => $this->fontePadrao, 'size' => 10, 'style' => 'B'];
        $texto = 'Nome completo: ';
        $texto .= $this->dadosArr['emitente']['nome'];
        //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
        $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'L', 0, '');

        $nextX = $x1 + $tw + 80;
        $x1 = $nextX;
        $tw = round($w * 0.20);

        //Nome emitente
        $aFont = ['font' => $this->fontePadrao, 'size' => 10, 'style' => 'B'];
        $texto = 'Data de nasc: ';
        $texto .= '20-09-1996';
        //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
        $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'R', 0, '');

        $x1 = $x;
        $y1 += 4;
        $this->pdf->Line($x + 29, $y1, $x + $nextX, $y1);

        $x1 = $x;
        //$y1 += 4;
        $this->pdf->Line($x + $nextX + 42, $y1, $nextX + 24, $y1);

        //--------------------- RG CPF e Whatsapp ----------------------
        //----------Nome completo e nascimento -----------------
        $y1 += 1;

        $nextX = $x1;
        $x1 = $nextX;
        $tw = round($w * 0.20);
        $nextRg = $nextX;
        $twRg = $tw;

        //Nome emitente
        $aFont = ['font' => $this->fontePadrao, 'size' => 10, 'style' => 'B'];
        $texto = 'RG: ';
        $texto .= $this->dadosArr['emitente']['cpf'] ?? '0000000000-0';
        //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
        $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'L', 0, '');

        $nextX = $x1 + $tw;
        $x1 = $nextX;
        $tw = round($w * 0.40);
        $nextCpf = $nextX;
        $twCpf = $tw;

        //Nome emitente
        $aFont = ['font' => $this->fontePadrao, 'size' => 10, 'style' => 'B'];
        $texto = 'CPF: ';
        $texto .= $this->dadosArr['emitente']['cpf'] ?? '000000000-00';
        //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
        $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'R', 0, '');

        $nextX = $x1 + $tw;
        $x1 = $nextX;
        $tw = round($w * 0.40);
        $nextWhats = $nextX;
        $twWhats = $tw;

        //Nome emitente
        $aFont = ['font' => $this->fontePadrao, 'size' => 10, 'style' => 'B'];
        $texto = 'Whatsapp: ';
        $texto .= $this->dadosArr['emitente']['nrWhatsapp'] ?? '(98)99999-9999';
        //$this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'C', 0, '');
        $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'R', 0, '');

        $x1 = $x;
        $y1 += 4;

        $this->pdf->Line($x1 + 8, $y1, 92, $y1);

        $x1 = $x;
        //$y1 += 4;
        $this->pdf->Line($x1 + 100 /* + $nextX - 30 */, $y1, 162, $y1);

        $x1 = $x;
        //$y1 += 4;
        $this->pdf->Line($x1 + 180 /* + $nextX - 30 */, $y1, 208, $y1);

        /*
            $nextWhats
            $twWhats

         */

        //endereço
        $y1 = $y1 + 5;
        $aFont = ['font' => $this->fontePadrao, 'size' => 8, 'style' => ''];
        $fone = !empty($this->dadosArr['emitente']['fone'])
            ? $this->dadosArr['emitente']['fone']
            : '';
        $lgr        = $this->dadosArr['emitente']['logradouro'];
        $nro        = $this->dadosArr['emitente']['numero'];
        $cpl        = $this->dadosArr['emitente']['complemento'];
        $bairro     = $this->dadosArr['emitente']['bairro'];
        $CEP        = $this->dadosArr['emitente']['cep'];
        $CEP        = $this->formatField($CEP, '#####-###');
        $mun        = $this->dadosArr['emitente']['cidade'];
        $UF         = $this->dadosArr['emitente']['uf'];
        $IE         = $this->dadosArr['emitente']['inscricao'];

        if (!empty($this->dadosArr['emitente']['CNPJ'])) {
            $cnpjcpf = $this->formatField(
                $this->dadosArr['emitente']['CNPJ'],
                '###.###.###/####-##'
            );
        } else {
            $cnpjcpf = !empty($this->dadosArr['emitente']['CPF']) ?
                $this->formatField(
                    $this->dadosArr['emitente']['CPF'],
                    '###.###.###-##'
                ) : '';
        }


        /*
        $texto =  "CNPJ: " . $cnpjcpf."\n"
                . "Inscrição Estadual: " . $IE."\n"
                .$lgr . ", " . $nro . $cpl . "\n" . $bairro . " - "
                . $CEP . "\n" . $mun . " - " . $UF . " "
                . "Fone/Fax: " . $fone."\n";


        */
        $texto =  'CNPJ: ' . $cnpjcpf . "\n"
            . 'Inscrição Estadual: ' . $IE . "\n";

        $this->pdf->textBox($x1, $y1, $tw, 8, $texto, $aFont, 'T', 'L', 0, '');

        $y1 += 5;

        $x += $w;
        $w = round($maxW * 0.19, 0); //35;
        $w2 = $w;
        //tipo de entrega
        $aFont = ['font' => $this->fontePadrao, 'size' => 8, 'style' => ''];



        return $y1;
    } //fim cabecalhoDANFE


    protected function pItensDANFE($x, $y, &$nInicio, $hmax, $pag = 0, $totpag = 0, $hCabecItens = 7)
    {

        $produtosEnderecos = $this->dadosArr['produtosEnderecos'] ?? [];

        $oldX = $x;
        $oldY = $y;
        $totItens = count($this->dadosArr['itens']);

        //#####################################################################
        //DADOS DOS PRODUTOS / SERVIÇOS
        $texto = 'DADOS DOS AGENDAMENTOS';

        $w = $this->wPrint;

        $h = 4;
        /* $aFont = array('font'=>$this->fontePadrao, 'size'=>7, 'style'=>'B');
        $this->pdf->textBox($x, $y, $w, $h, $texto, $aFont, 'T', 'L', 0, '');
        */
        $y += 4;
        //desenha a caixa dos dados dos itens da NF
        $hmax += 3;
        $texto = '';

        //##################################################################################
        // cabecalho LOOP COM OS DADOS DOS PRODUTOS
        //CÓDIGO PRODUTO

        $this->pdf->setFillColor(46, 64, 84);
        $this->pdf->setTextColor(255, 255, 255);

        $texto = 'Código';
        $w1 = round($w * 0.10, 0);
        $h = 6;
        $aFont = ['font' => $this->fontePadrao, 'size' => 9, 'style' => 'B'];
        $this->pdf->textBox($x, $y, $w1, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

        //DESCRIÇÃO DO PRODUTO / SERVIÇO
        $x += $w1;
        $w2 = round($w * 0.54, 0);
        $texto = 'Registro de atendimento ';

        $this->pdf->textBox($x, $y, $w2, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);
        //QUANT
        $x += $w2;
        $w3 = round($w * 0.12, 0);
        $texto = 'Data';

        $this->pdf->textBox($x, $y, $w3, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

        //UN
        $x += $w3;
        $w4 = round($w * 0.12, 0);
        $texto = 'Horário';

        $this->pdf->textBox($x, $y, $w4, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

        //VALOR TABELA
        $x += $w4;
        $w5 = round($w * 0.12, 0);
        $texto = 'Pago';

        $this->pdf->textBox($x, $y, $w5 - 1, $h, $texto, $aFont, 'C', 'C', 0, '', 0, 0, 0, 1);

        $this->pdf->setFillColor(255, 255, 255);
        $this->pdf->setTextColor(0, 0, 0);

        //##################################################################################
        // LOOP COM OS DADOS DOS PRODUTOS
        $i = 0;
        $hUsado = $h;
        $aFont = ['font' => $this->fontePadrao, 'size' => 7, 'style' => ''];

        $y += $hUsado;
        $this->valorTotalTabela = 0;
        $produtosArr = $this->dadosArr['itens'];
        $hUsadoItens = $y;

        if (is_array($produtosArr)) {
            foreach ($produtosArr as $d) {
                if ($i >= $nInicio) {
                    $produtosFields = $d;
                    $textoProduto = $d['registro'];
                    $linhaDescr = $this->pdf->getNumLines($textoProduto, $w2, $aFont);
                    $h = round(($linhaDescr * $this->pdf->fontSize) + ($linhaDescr * 0.5), 2) + 2;



                    $hUsado += $h;
                    if ($pag != $totpag) {

                        if ($hUsado >= $hmax && $i < $totItens) {
                            //ultrapassa a capacidade para uma única página
                            //o restante dos dados serão usados nas proximas paginas
                            $nInicio = $i;
                            break;
                        }
                    }
                    if ($y >= 290) {
                        $nInicio = $i;
                        break;
                    }

                    $y_linha = $y + $h;
                    // linha entre itens
                    $this->pdf->line($oldX, $y, $w + 2, $y);
                    //corrige o x
                    $x = $oldX;
                    //codigo do produto
                    $texto =  $d['cod'];
                    $this->pdf->textBox($x, $y, $w1, $h, $texto, $aFont, 'T', 'C', 0, '');
                    //DESCRIÇÃO

                    $x += $w1;
                    $w2 = round($w * 0.54, 0);
                    $this->pdf->textBox($x, $y, $w2, $h, $textoProduto, $aFont, 'T', 'L', 0, '', false);

                    // DATA
                    $x += $w2;
                    $w3 = round($w * 0.12, 0);
                    $texto =  $d['data'];
                    $this->pdf->textBox($x, $y, $w3, $h, $texto, $aFont, 'T', 'C', 0, '');

                    //HORARIO
                    $x += $w3;
                    $w4 = round($w * 0.12, 0);
                    $texto =  $d['horario'];
                    $this->pdf->textBox($x, $y, $w4, $h, $texto, $aFont, 'T', 'C', 0, '');
                    $alinhamento = 'R';

                    // PAGO
                    $x += $w4;
                    $w5 = round($w * 0.12, 0);
                    $texto =  $d['pago'];
                    $this->pdf->textBox($x, $y, $w5, $h, $texto, $aFont, 'T', 'C', 0, '');



                    $y += $h;
                    $i++;
                    //incrementa o controle dos itens processados.
                    $this->qtdeItensProc++;
                } else {
                    $i++;
                }
            }
        }

        $nInicio = $i;
        //die();
        $w = $this->wPrint;

        $yInicial = $oldY + 4;

        $x = $oldX;
        $w1 = round($w * 0.10, 0);
        $this->pdf->Line($x + $w1, $yInicial, $x + $w1, $y_linha);

        $x += $w1;
        $w2 = round($w * 0.54, 0);
        $this->pdf->Line($x + $w2, $yInicial, $x + $w2, $y_linha);

        $x += $w2;
        $w3 = round($w * 0.12, 0);
        $this->pdf->Line($x + $w3, $yInicial, $x + $w3, $y_linha);

        $x += $w3;
        $w4 = round($w * 0.12, 0);
        $this->pdf->Line($x + $w4, $yInicial, $x + $w4, $y_linha);

        $x += $w4;
        $w5 = round($w * 0.12, 0);
        //$this->pdf->Line($x+$w5, $yInicial, $x+$w5, $y_linha);


        $this->pdf->textBox($oldX, $yInicial, $w, ($y_linha - $yInicial));

        return $y;

        ///return $oldY+$hmax;
    }



    protected function pItens($x, $y, $nInicio, $hmax, $pag = 0, $totpag = 0, $hCabecItens = 7)
    {
        $oldX = $x;
        $oldY = $y;
        $w = $this->wPrint;
        $totItens = count($this->dadosArr['itens']);
        $aFont = ['font' => $this->fontePadrao, 'size' => 7, 'style' => 'B'];
        $i = 0;
        $this->currentpag = $pag;
        //$y+=2;
        $agrupadosPedidos = $this->dadosArr['itens'];

        $nInicio = 0;
        if (is_array($agrupadosPedidos)) {

            $nInicio = 0;

            $dadosLayout = $this->pItensProdutos($x, $y + 15, $nInicio, $hmax, $pag, $totpag, $hCabecItens, $agrupadosPedidos);


            if ($dadosLayout['incompleto']) {
                while ($dadosLayout['incompleto']) {

                    $this->currentpag++;

                    $this->hUsado = 0;

                    // fixa as margens
                    $margEsq = 2;
                    $margSup = 2;
                    $xInic = $margEsq;
                    $yInic = $margSup;

                    $this->pdf->setMargins($margEsq, $margSup);
                    //adiciona nova página
                    $this->pdf->addPage($this->orientacao, $this->papel);
                    //ajusta espessura das linhas
                    $this->pdf->setLineWidth(0.1);
                    //seta a cor do texto para petro
                    $this->pdf->setTextColor(0, 0, 0);
                    // posição inicial do relatorio
                    $x = $xInic;
                    $y = $yInic;
                    //coloca o cabeçalho na página adicional

                    $n++;

                    $yCabecalho = $this->pCabecalhoMapa($x, $y, $n, $totPag);
                    $this->hUsado += ($yCabecalho - $y);
                    $y = $yCabecalho;

                    /*echo "this->currentpag:";
                        echo $this->currentpag;
                        echo "<br>";

                        echo "this->totpag:";
                        echo $this->totpag;
                        echo "<br>";



                        echo "hmax:";
                        echo $hmax;
                        echo "<br>";
                        print_r($dadosLayout);

                        */

                    $dadosLayout = $this->pItensProdutos($x, $y + 15, $nInicio, $hmax, $pag, $totpag, $hCabecItens, $agrupadosPedidos);
                }
            }

            //-------------Totalizador--------------
            $this->pdf->DashedHLine($x, $dadosLayout['y'], $w, 0.1, 120);

            $this->totalizador_tabela($x, $dadosLayout['y'] + 2);



            $hmaxTotal += $hGrupo;
        }
        //die();

        return $y; //+$hmaxTotal;
    }




    /**
     * pRodape
     * Monta o rodapé no final da DANFE com a data/hora de impressão e informações
     * sobre a API NfePHP
     *
     * @name   pRodape
     * @param  float $xInic  Posição horizontal canto esquerdo
     * @param  float $yFinal Posição vertical final para impressão
     * @return void
     */
    protected function pRodape($x, $y)
    {
        $w = $this->wPrint;

        $aFont = ['font' => $this->fontePadrao, 'size' => 7, 'style' => 'I'];
        $texto = 'Impresso em ' . date('d/m/Y') . ' as ' . date('H:i:s');
        $this->pdf->textBox($x, $y, $w, 0, $texto, $aFont, 'T', 'L', false);
        $texto = $this->creditos .  '  Desenvolvido por Reservai - www.reservai.com.br';
        $this->pdf->textBox($x, $y, $w, 0, $texto, $aFont, 'T', 'R', false, '');

        return $y;
    }



    /**
     * pGeraInformacoesDaTagCompra
     * Devolve uma string contendo informação sobre as tag <compra><xNEmp>, <xPed> e <xCont> ou string vazia.
     * Aviso: Esta função não leva em consideração dados na tag xPed do item.
     *
     * @name   pGeraInformacoesDaTagCompra
     * @return string com as informacoes dos pedidos.
     */

    private function imagePNGtoJPG($original)
    {
        $image = imagecreatefrompng($original);
        ob_start();
        imagejpeg($image, null, 100);
        imagedestroy($image);
        $stringdata = ob_get_contents(); // read from buffer
        ob_end_clean();
        return 'data://text/plain;base64,' . base64_encode($stringdata);
    }
}
