<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Fiscal\Nfe;
use \App\Fiscal\VaidateNfe;
use NFePHP\NFe\Tools;
use NFePHP\NFe\Make;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use \Mpdf\Mpdf;
use \App\Fiscal\FacadeNfe;
use \App\Exceptions\FiscalException;
use stdClass;

class NfeController extends Controller
{

    /*
        Aual de modelagem 03 ok
        
        Modelo conceitual controle fiscal

        Emitir nota fisca NFe e NFCe
        Controlar as notas fiscais emitidas contra mim
        Controlar as notas ficasi que eu emitir
        Escriturar minhas notas
        Auditar minhas notas, principalmente quando a contabilidade precisar
        Cadastras meu produtos pela nota
        Emitir nota de devolução tanto de cliente quanto de fornecedor

        Modelo lógico

        Modelo físico


    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        try {


            $objFacade = new FacadeNfe();
            $validadorXml = new VaidateNfe();
            $nfe = new Nfe($objFacade);

            $autorizarAcessoPessoaXml = true;

            //  $configJson = $nfe->config('Pedro','MA', '03810070000101','AAAAAAA', 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G', '000001', 'PL_009_V4', '4.00', date('Y-m-d H:i:s'), 2);
            //$pfxcontent = $nfe->getCertificade(public_path('config/certificado.pfx'));
            // $tools = new Tools($configJson, Certificate::readPfx($pfxcontent, 'associacao'));
            // $tools->disableCertValidation(true); //tem que desabilitar
            //$tools->model('55');



            //--------------------------------------------------------------------

            $dados              = [];
            $dados['versao']    = '4.00';
            $dados['Id']        = 'NFe52211003810070000101550010000000101000000011';
            $dados['pk_nItem']  = null;

            $apenas = ['versao', 'Id', 'pk_nItem'];
            $errors = $validadorXml->Emitente($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }
            $nfe->infNfe($dados);

            //---------------------------------------------------------------------------
            $dados              = [];
            $dados['cUF']       = '52'; //codigo numerico do estado
            $dados['cNF']       = '1'; //numero aleatório da NF
            $dados['natOp']     = 'Venda de Produto'; //natureza da operação
            $dados['indPag']    = '1'; //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
            $dados['mod']       = '55'; //modelo da NFe 55 ou 65 essa última NFCe
            $dados['serie']     = '1'; //serie da NFe
            $dados['nNF']       = '10'; // numero da NFe 
            $dados['dhEmi']     = date("Y-m-d\TH:i:sP");;
            $dados['dhSaiEnt']  = date("Y-m-d\TH:i:sP"); // Nâo informar para nfce
            $dados['tpNF']      = '1';
            $dados['idDest']    = '1'; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
            $dados['cMunFG']    = '5200258';
            $dados['tpImp']     = '1';
            $dados['tpEmis']    = '1';
            $dados['cDV']       = '';
            $dados['tpAmb']     = '2';  //1=Produção; 2=Homologação
            $dados['finNFe']    = '1';  //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
            $dados['indFinal']  = '0';  //0=Normal; 1=Consumidor final;       
            $dados['indPres']   = '9';  //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
            //1=Operação presencial;
            //2=Operação não presencial, pela Internet;
            //3=Operação não presencial, Teleatendimento;
            //4=NFC-e em operação com entrega a domicílio;
            //9=Operação não presencial, outros.

            $dados['procEmi']   = '0';  //0=Emissão de NF-e com aplicativo do contribuinte;
            //1=Emissão de NF-e avulsa pelo Fisco;
            //2=Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
            //3=Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
            $dados['dhCont']    = '';   //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
            $dados['xJust']     = '';   //Justificativa da entrada em contingência
            $dados['verProc']   = '1,0'; //versão do aplicativo emissor

            $apenas = [
                'cUF', 'cNF', 'natOp', 'mod', 'serie', 'nNF', 'dhEmi', 'dhSaiEnt', 'tpNF', 'cMunFG', 'tpImp', 'tpEmis', 'cDV', 'tpAmb', 'finNFe', 'procEmi', 'verProc'
            ];
            $errors = $validadorXml->IdentificacaoDaNota($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }

            $nfe->IdentificacaoDaNota($dados);



            //---------------------------------------
            //Node referente a NFe referenciada
            $dados              = [];
            $dados['refNFe']       = '35150271780456000160550010000253101000253101'; //codigo numerico do estado
            $apenas = [
                'refNFe'
            ];
            $errors = $validadorXml->nfReferenciada($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }

            $nfe->nfReferenciada($dados);

            //--------------------------------------------------------------------
            $dados              = [];
            $dados['xNome']     = 'Pedro';
            $dados['xFant']     = 'Pedro Produções';
            $dados['IE']        = '128456701';
            $dados['IEST']      = null;
            $dados['IM']        = null;
            $dados['CNAE']      = null;
            $dados['CRT']       = '1';
            $dados['CNPJ']      = '03810070000101'; //indicar apenas um CNPJ ou CPF
            $dados['CPF']       = null;

            $apenas = [
                'xNome', 'CNPJ', 'CRT',
            ];

            $errors = $validadorXml->Emitente($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }
            $nfe->Emitente($dados);



            //----------------------------------------
            $dados              = [];
            $dados['xLgr']      = 'Rua nova';
            $dados['nro']       = '23';
            $dados['xCpl']      = '';
            $dados['xBairro']   = 'Ipase de Baixo';
            $dados['cMun']      = '11300';
            $dados['xMun']      = 'Sao Luiz';
            $dados['UF']        = 'MA';
            $dados['CEP']       = '65061220';
            $dados['cPais']     = '1058';
            $dados['xPais']     = 'BRAZIL';
            $dados['fone']      = '98984257623';
            $apenas = [
                'xLgr', 'nro', 'xBairro', 'cMun', 'xMun', 'UF', 'CEP', 'cPais', 'xPais',
            ];
            $errors = $validadorXml->enderecoEmitente($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }

            $nfe->enderecoEmitente($dados);

            //------------------------------------------------------------------------------

            $dados                      = [];
            $dados['xNome']             = 'Luciana';
            $dados['indIEDest']         = 1;
            $dados['IE']                = '129065820';
            $dados['ISUF']              = null;
            $dados['IM']                = null;
            $dados['email']             = 'lucy@gmail.com';
            $dados['CNPJ']              = '59635091000184';
            $dados['CPF']               = null;
            $dados['CEP']               = null;
            $dados['idEstrangeiro']     = null;
            $apenas = [
                'xNome', 'IE', 'email', 'CNPJ'
            ];
            $errors = $validadorXml->Destinatario($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }
            $nfe->Destinatario($dados);

            //---------------------------------------------------------------------------------

            $dados              = [];
            $dados['xLgr']      = 'Rua nova';
            $dados['nro']       = '23';
            $dados['xCpl']      = '';
            $dados['xBairro']   = 'Ipase de Baixo';
            $dados['cMun']      = '11300';
            $dados['xMun']      = 'Sao Luiz';
            $dados['UF']        = 'MA';
            $dados['CEP']       = '65061220';
            $dados['cPais']     = '1058';
            $dados['xPais']     = 'BRAZIL';
            $dados['fone']      = '98984257623';
            $apenas = [
                'xLgr', 'nro', 'xBairro', 'cMun', 'xMun', 'UF', 'CEP', 'cPais', 'xPais',
            ];
            $errors = $validadorXml->enderecoDestinatario($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }

            $nfe->enderecoDestinatario($dados);

            //-----------------------------------------------------------------------------------------------

            $aP[] = array(
                //'nItem' => 1,
                'item' => 1,
                'cProd' => '15',
                'cEAN' => '97899072659522',
                'xProd' => 'Chopp Pilsen - Barril 30 Lts',
                'NCM' => '22030000',
                'cBenef' => '',
                'EXTIPI' => '',
                'CFOP' => '5101',
                'uCom' => 'Un',
                'qCom' => '4',
                'vUnCom' => '210.00',
                'vProd' => '840.00',
                'cEANTrib' => 'SEM GTIN',
                'uTrib' => 'Lt',
                'qTrib' => '120',
                'vUnTrib' => '7.00',
                'vFrete' => '',
                'vSeg' => '',
                'vDesc' => '',
                'vOutro' => '',
                'indTot' => '1',
                'xPed' => '16',
                'nItemPed' => '1',
                'nFCI' => '',
            );
            $apenas = [
                'item',
                'cProd',
                'xProd',
                'cEAN',
                'CFOP',
                'NCM',
                'cBenef',
                'uCom',
                'qCom',
                'vUnCom',
                'vProd',
                'uTrib',
                'qTrib',
                'vUnTrib',
                'indTot',
            ];

            foreach ($aP as $prod) {
                $prod               = (object) $prod;
                $dados              = [];
                $dados['item']      = $prod->item; //item da NFe
                $dados['cProd']     = $prod->cProd;
                $dados['cEAN']      = $prod->cEAN;
                $dados['xProd']     = $prod->xProd;
                $dados['NCM']       = $prod->NCM;
                $dados['cBenef']    = $prod->cBenef; //incluido no layout 4.00

                $dados['EXTIPI']    = $prod->EXTIPI;
                $dados['CFOP']      = $prod->CFOP;
                $dados['uCom']      = $prod->uCom;
                $dados['qCom']      = $prod->qCom;
                $dados['vUnCom']    = $prod->vUnCom;
                $dados['vProd']     = $prod->vProd;
                $dados['cEANTrib']  = $prod->cEANTrib;
                $dados['uTrib']     = $prod->uTrib;
                $dados['qTrib']     = $prod->qTrib;
                $dados['vUnTrib']   = $prod->vUnTrib;
                $dados['vFrete']    = $prod->vFrete;
                $dados['vSeg']      = $prod->vSeg;
                $dados['vDesc']     = $prod->vDesc;
                $dados['vOutro']    = $prod->vOutro;
                $dados['indTot']    = $prod->indTot;
                $dados['xPed']      = $prod->xPed;
                $dados['nItemPed']  = $prod->nItemPed;
                $dados['nFCI']      = $prod->nFCI;

                $errors = $validadorXml->Produto($dados, $apenas);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }

                $nfe->Produto($dados);

                //--- informações adicionais para o produto
                $dadosInfoAdd = [];
                $dadosInfoAdd['item'] = $prod->item;
                $dadosInfoAdd['infAdProd'] = 'Informações adicionais ';

                $apenasInfoAdd = [];
                $apenasInfoAdd[] = 'item';
                $apenasInfoAdd[] = 'infAdProd';

                $errors = $validadorXml->infoAdocionaisProduto($dadosInfoAdd, $apenasInfoAdd);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }


                $nfe->infoAdocionaisProduto($dadosInfoAdd);

                //--- Nomeclatura adicional aduaneiro
                $dadosAdicionaAduaneiro = [];
                $dadosAdicionaAduaneiro['item']          = $prod->item;
                $dadosAdicionaAduaneiro['NVE']           = 'AA0001';

                $apenasAdicionaAduaneiro = [];
                $apenasAdicionaAduaneiro[] = 'item';
                $apenasAdicionaAduaneiro[] = 'infAdProd';

                $errors = $validadorXml->nomeclaturaAdicAtuaneiro($dadosAdicionaAduaneiro, $apenasAdicionaAduaneiro);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }
                $nfe->nomeclaturaAdicAtuaneiro($dadosAdicionaAduaneiro);

                //--- Node de detalhamento do Especificador da Substituição Tributária do item da NFe
                $dadosCest = [];
                $dadosCest['item']          = $prod->item;
                $dadosCest['CEST']          = '0200100';
                $dadosCest['indEscala']     = 'N';
                $dadosCest['CNPJFab']       = '12345678901234';

                $apenasCest = [];
                $apenasCest[] = 'item';
                $apenasCest[] = 'CEST';
                $apenasCest[] = 'indEscala';
                $apenasCest[] = 'CNPJFab';

                $errors = $validadorXml->cest($dadosCest, $apenasCest);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }
                $nfe->cest($dadosCest);

                //----  Node com o número do RECOPI-------------------------------------
                $dadosRecopi = [];
                $dadosRecopi['item']          = $prod->item;
                $dadosRecopi['nRECOPI']          = '0200100';

                $apenasRecopi = [];
                $apenasRecopi[] = 'item';
                $apenasRecopi[] = 'nRECOPI';

                $errors = $validadorXml->recopi($dadosRecopi, $apenasRecopi);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }
                $nfe->recopi($dadosRecopi);
                //------------------------------------

                //----  Node com dados de para importação-------------------------------------
                $dadosDi = [];
                $dadosDi['item']             = $prod->item;
                $dadosDi['nDI']               = '001';
                $dadosDi['dDI']               = date('y-m-d');
                $dadosDi['xLocDesemb']        = 'Curitiba';
                $dadosDi['UFDesemb']          = 'SC';
                $dadosDi['dDesemb']           = date('Y-m-d');
                $dadosDi['tpViaTransp']       = '7';
                $dadosDi['vAFRMM']            = 0;
                $dadosDi['tpIntermedio']      = 1;
                $dadosDi['CNPJ']              = '03810070000101';
                $dadosDi['UFTerceiro']        = 'MA';
                $dadosDi['cExportador']       = '022020';

                $apenasDi = [];
                $apenasDi[] = 'item';
                $apenasDi[] = 'nDI';
                $apenasDi[] = 'dDI';
                $apenasDi[] = 'xLocDesemb';
                $apenasDi[] = 'UFDesemb';
                $apenasDi[] = 'dDesemb';
                $apenasDi[] = 'tpViaTransp';
                $apenasDi[] = 'vAFRMM';
                $apenasDi[] = 'vAFRMM';
                $apenasDi[] = 'CNPJ';
                $apenasDi[] = 'UFTerceiro';
                $apenasDi[] = 'cExportador';

                $errors = $validadorXml->declaracaoImportacao($dadosDi, $apenasDi);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }
                $nfe->declaracaoImportacao($dadosDi);
                //------------------------------------

                $dadosImposto = [];
                $dadosImposto['item']     = $prod->item;
                $dadosImposto['vTotTrib'] = $prod->qCom * $prod->vProd;

                $apenasImposto = [];
                $apenasImposto[] = 'item';
                $apenasImposto[] = 'vTotTrib';

                $errors = $validadorXml->imposto($dadosImposto, $apenasImposto);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }

                $nfe->imposto($dadosImposto);

                $dadosIcms = [];
                $dadosIcms['item']          = $prod->item;
                $dadosIcms['orig']          = '';
                $dadosIcms['CST']           = '';
                $dadosIcms['modBC']         = '';
                $dadosIcms['vBC']           = '';
                $dadosIcms['pICMS']         = '';
                $dadosIcms['vICMS']         = '';
                $dadosIcms['pFCP']          = '';
                $dadosIcms['vFCP']          = '';
                $dadosIcms['vBCFCP']        = '';
                $dadosIcms['modBCST']       = '';
                $dadosIcms['pMVAST']        = '';
                $dadosIcms['pRedBCST']      = '';
                $dadosIcms['vBCST']         = '';
                $dadosIcms['pICMSST']       = '';
                $dadosIcms['vICMSST']       = '';
                $dadosIcms['vBCFCPST']      = '';
                $dadosIcms['pFCPST']        = '';
                $dadosIcms['vFCPST']        = '';
                $dadosIcms['vICMSDeson']    = '';
                $dadosIcms['motDesICMS']    = '';
                $dadosIcms['pRedBC']        = '';
                $dadosIcms['vICMSOp']       = '';
                $dadosIcms['pDif']          = '';
                $dadosIcms['vICMSDif']      = '';
                $dadosIcms['vBCSTRet']      = '';
                $dadosIcms['pST']           = '';
                $dadosIcms['vICMSSTRet']    = '';
                $dadosIcms['vBCFCPSTRet']   = '';
                $dadosIcms['pFCPSTRet']     = '';
                $dadosIcms['vFCPSTRet']     = '';
                $dadosIcms['pRedBCEfet']    = '';
                $dadosIcms['vBCEfet']       = '';
                $dadosIcms['pICMSEfet']     = '';
                $dadosIcms['vICMSEfet']     = '';
                $dadosIcms['vICMSSubstituto'] = '';

                $apenasIcms = [];
                $apenasIcms[] = 'item';


                $errors = $validadorXml->icms($dadosIcms, $apenasIcms);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }
                $nfe->icms($dadosIcms);

                $dadosPartilha = [];
                $dadosPartilha['item']      = $prod->item;
                $dadosPartilha['orig']      = '0';
                $dadosPartilha['CST']       = '90';
                $dadosPartilha['modBC']     = 0;
                $dadosPartilha['vBC']       = 1000.00;
                $dadosPartilha['pRedBC']    = null;
                $dadosPartilha['pICMS']     = 18.00;
                $dadosPartilha['vICMS']     = 180.00;
                $dadosPartilha['modBCST']   = 1000.00;
                $dadosPartilha['pMVAST']    = 40.00;
                $dadosPartilha['pRedBCST']  = null;
                $dadosPartilha['vBCST']     = 1400.00;
                $dadosPartilha['pICMSST']   = 10.00;
                $dadosPartilha['vICMSST']   = 140.00;
                $dadosPartilha['pBCOp']     = 10.00;
                $dadosPartilha['UFST']      = 'MA';

                $apenasPartilha = [];
                $apenasPartilha[] = 'item';

                $errors = $validadorXml->imcsPartilha($dadosPartilha, $apenasPartilha);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }
                $nfe->imcsPartilha($dadosPartilha);
                //dd($dados);

            }

            //---------------------NOTA: Ajustado para NT 2018.005 Node indicativo de local de retirada diferente do endereço do emitente 
            $dados = [];
            $dados['CPF']       = null; // OU cpf ou cnpj
            $dados['CNPJ']      = '03810070000101'; // OU cpf ou cnpj
            $dados['IE']        = '03810070000101';
            $dados['xNome']     = 'Pedro';
            $dados['xLgr']      = 'Logradouro de teste';
            $dados['nro']       = '12B';
            $dados['xCpl']      = '000';
            $dados['xBairro']   = 'Bairro de teste';
            $dados['cMun']      = '11300';
            $dados['xMun']      = 'Munípio de teste';
            $dados['UF']        = 'MA';
            $dados['CEP']       = '65061220';
            $dados['cPais']     = '1058';
            $dados['xPais']     = 'BRAZIL';
            $dados['fone']      = '98984256645';
            $dados['email']     = 'teste@gmail.com';

            $apenas = [];
            $apenas[] = 'CPF';
            $apenas[] = 'CNPJ';
            $apenas[] = 'IE';
            $apenas[] = 'xNome';
            $apenas[] = 'xLgr';
            $apenas[] = 'nro';
            $apenas[] = 'xCpl';
            $apenas[] = 'xBairro';
            $apenas[] = 'cMun';
            $apenas[] = 'xMun';
            $apenas[] = 'UF';
            $apenas[] = 'CEP';
            $apenas[] = 'cPais';
            $apenas[] = 'xPais';
            $apenas[] = 'fone';
            $apenas[] = 'email';

            $errors = $validadorXml->localEntregaRetirada($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }
            $nfe->localRetirada($dados);

            //---------------------NOTA: NOTA: Ajustado para NT 2018.005 Node indicativo de local de entrega diferente do endereço do destinatário 
            $dados = [];
            $dados['CPF']       = null; // OU cpf ou cnpj
            $dados['CNPJ']      = '03810070000101'; // OU cpf ou cnpj
            $dados['IE']        = '03810070000101';
            $dados['xNome']     = 'Pedro';
            $dados['xLgr']      = 'Logradouro de teste';
            $dados['nro']       = '12B';
            $dados['xCpl']      = '000';
            $dados['xBairro']   = 'Bairro de teste';
            $dados['cMun']      = '11300';
            $dados['xMun']      = 'Munípio de teste';
            $dados['UF']        = 'MA';
            $dados['CEP']       = '65061220';
            $dados['cPais']     = '1058';
            $dados['xPais']     = 'BRAZIL';
            $dados['fone']      = '98984256645';
            $dados['email']     = 'teste@gmail.com';

            $apenas = [];
            $apenas[] = 'CPF';
            $apenas[] = 'CNPJ';
            $apenas[] = 'IE';
            $apenas[] = 'xNome';
            $apenas[] = 'xLgr';
            $apenas[] = 'nro';
            $apenas[] = 'xCpl';
            $apenas[] = 'xBairro';
            $apenas[] = 'cMun';
            $apenas[] = 'xMun';
            $apenas[] = 'UF';
            $apenas[] = 'CEP';
            $apenas[] = 'cPais';
            $apenas[] = 'xPais';
            $apenas[] = 'fone';
            $apenas[] = 'email';

            $errors = $validadorXml->localEntregaRetirada($dados, $apenas);
            if (is_array($errors) && (count($errors) > 0)) {
                //
            }
            $nfe->localEntrega($dados);


            //------------------------------------------------------------------------------------------------
            if ($autorizarAcessoPessoaXml) {
                $dados = [];
                $dados['CPF']       = null; // OU cpf ou cnpj
                $dados['CNPJ']      = '03810070000101'; // OU cpf ou cnpj

                $apenas = [];
                $apenas[] = 'CPF';
                $apenas[] = 'CNPJ';

                $errors = $validadorXml->autorizaPessoaAcessXml($dados, $apenas);
                if (is_array($errors) && (count($errors) > 0)) {
                    //
                }

                $nfe->autorizaPessoaAcessXml($dados);
            }
            //Este método retorna o XML em uma string, mesmo que existam erros.
            $xml = $objFacade->getXML();
            //$xml = $nfe->getXML();

            echo $xml;
            //$this->getPdfXml($xml);
            //dd($objFacade->getErrors());
        } catch (\Exception $ex) {
            //dd($ex);
            //dd($ex->getMessage());
            dd($objFacade->getErrors()); // Erros no xml
        }
    }
    public function montagemXml()
    {
        //Método construtor. Instancia a classe
        $nfe = new Make();


        //contêm os dados dos campos, nomeados conforme manual
        $std = new \stdClass();
        $std->versao = '4.00'; //versão do layout (string)
        $std->Id = 'NFe35150271780456000160550010000000021800700082'; //se o Id de 44 digitos não for passado será gerado automaticamente
        $std->pk_nItem = null; //deixe essa variavel sempre como NULL

        $nfe->taginfNFe($std);

        //Node de identificação da NFe


        $std = new \stdClass();
        $std->cUF = 35;
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';

        $std->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00

        $std->mod = 55;
        $std->serie = 1;
        $std->nNF = 2;
        $std->dhEmi = '2015-02-19T13:48:00-02:00';
        $std->dhSaiEnt = null;
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = 3518800;
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 2;
        $std->tpAmb = 2;
        $std->finNFe = 1;
        $std->indFinal = 0;
        $std->indPres = 0;
        $std->procEmi = 0;
        $std->verProc = '3.10.31';
        $std->dhCont = null;
        $std->xJust = null;

        $nfe->tagide($std);


        //Node referente a NFe referenciada
        $std = new \stdClass();
        $std->refNFe = '35150271780456000160550010000253101000253101';

        $nfe->tagrefNFe($std);

        //Node referente a Nota Fiscal referenciada modelo 1 ou 2
        $std = new \stdClass();
        $std->cUF = 35;
        $std->AAMM = 1412;
        $std->CNPJ = '52297850000105';
        $std->mod = '01';
        $std->serie = 3;
        $std->nNF = 587878;

        $nfe->tagrefNF($std);

        //Node referente a Nota Fiscal referenciada de produtor rural
        $std = new \stdClass();
        $std->cUF = 35;
        $std->AAMM = 1502;
        $std->CNPJ;
        $std->CPF;
        $std->IE = 'ISENTO';
        $std->mod = '04';
        $std->serie = 0;
        $std->nNF = 5578;

        $nfe->tagrefNFP($std);

        //Node referente aos CTe referenciados

        $std = new \stdClass();
        $std->refCTe = '35150268252816000146570010000016161002008472';

        $nfe->tagrefCTe($std);

        //Node referente aos ECF referenciados
        $std = new \stdClass();
        $std->mod = '2C';
        $std->nECF = 788;
        $std->nCOO = 114;

        $nfe->tagrefECF($std);

        //Node com os dados do emitente
        $std = new \stdClass();
        $std->xNome;
        $std->xFant;
        $std->IE;
        $std->IEST;
        $std->IM;
        $std->CNAE;
        $std->CRT;
        $std->CNPJ; //indicar apenas um CNPJ ou CPF
        $std->CPF;

        $nfe->tagemit($std);

        //Node com o endereço do emitente
        $std = new \stdClass();
        $std->xLgr;
        $std->nro;
        $std->xCpl;
        $std->xBairro;
        $std->cMun;
        $std->xMun;
        $std->UF;
        $std->CEP;
        $std->cPais;
        $std->xPais;
        $std->fone;

        $nfe->tagenderEmit($std);

        //Node com os dados do destinatário
        $std = new \stdClass();
        $std->xNome;
        $std->indIEDest;
        $std->IE;
        $std->ISUF;
        $std->IM;
        $std->email;
        $std->CNPJ; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
        $std->CPF;
        $std->idEstrangeiro;

        $nfe->tagdest($std);

        //Node de endereço do destinatário
        $std = new \stdClass();
        $std->xLgr;
        $std->nro;
        $std->xCpl;
        $std->xBairro;
        $std->cMun;
        $std->xMun;
        $std->UF;
        $std->CEP;
        $std->cPais;
        $std->xPais;
        $std->fone;

        $nfe->tagenderDest($std);

        //NOTA: Ajustado para NT 2018.005 Node indicativo de local de retirada diferente do endereço do emitente
        $std = new \stdClass();
        $std->CNPJ = '12345678901234'; //indicar apenas um CNPJ ou CPF
        $std->CPF = null;
        $std->IE = '12345678901';
        $std->xNome = 'Beltrano e Cia Ltda';
        $std->xLgr = 'Rua Um';
        $std->nro = '123';
        $std->xCpl = 'sobreloja';
        $std->xBairro = 'centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01023000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '1122225544';
        $std->email = 'contato@beltrano.com.br';

        $nfe->tagretirada($std);

        //NOTA: Ajustado para NT 2018.005 Node indicativo de local de entrega diferente do endereço do destinatário

        $std = new \stdClass();
        $std->CNPJ; //indicar um CNPJ ou CPF
        $std->CPF = null;
        $std->IE = '12345678901';
        $std->xNome = 'Beltrano e Cia Ltda';
        $std->xLgr = 'Rua Um';
        $std->nro = '123';
        $std->xCpl = 'sobreloja';
        $std->xBairro = 'centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01023000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '1122225544';
        $std->email = 'contato@beltrano.com.br';

        $nfe->tagentrega($std);

        //Node de registro de pessoas autorizadas a acessar a NFe
        $std = new \stdClass();
        $std->CNPJ = '12345678901234'; //indicar um CNPJ ou CPF
        $std->CPF = null;
        $nfe->tagautXML($std);

        //Node de dados do produto/serviço

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->cProd;
        $std->cEAN;
        $std->xProd;
        $std->NCM;

        $std->cBenef; //incluido no layout 4.00

        $std->EXTIPI;
        $std->CFOP;
        $std->uCom;
        $std->qCom;
        $std->vUnCom;
        $std->vProd;
        $std->cEANTrib;
        $std->uTrib;
        $std->qTrib;
        $std->vUnTrib;
        $std->vFrete;
        $std->vSeg;
        $std->vDesc;
        $std->vOutro;
        $std->indTot;
        $std->xPed;
        $std->nItemPed;
        $std->nFCI;

        //Node de informações adicionais do produto
        $std = new \stdClass();
        $std->item = 1; //item da NFe

        $std->infAdProd = 'informacao adicional do item';

        $nfe->taginfAdProd($std);

        //Node com a Nomenclatura de Valor Aduaneiro e Estatística do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->NVE = 'AA0001';

        $nfe->tagNVE($std);

        //Node de detalhamento do Especificador da Substituição Tributária do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->CEST = '0200100';
        $std->indEscala = 'N'; //incluido no layout 4.00
        $std->CNPJFab = '12345678901234'; //incluido no layout 4.00

        $nfe->tagCEST($std);

        //Node com o número do RECOPI
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nRECOPI = '12345678901234567890';

        $nfe->tagRECOPI($std);

        //Node com informações da Declaração de Importação do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nDI;
        $std->dDI;
        $std->xLocDesemb;
        $std->UFDesemb;
        $std->dDesemb;
        $std->tpViaTransp;
        $std->vAFRMM;
        $std->tpIntermedio;
        $std->CNPJ;
        $std->UFTerceiro;
        $std->cExportador;

        $nfe->tagDI($std);

        //Node de Adições relativas as DI do item
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nDI; //número da DI
        $std->nAdicao;
        $std->nSeqAdic;
        $std->cFabricante;
        $std->vDescDI;
        $std->nDraw;

        $nfe->tagadi($std);

        //Node com informações de exportação para o item

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nDraw = '82828';

        $nfe->tagdetExport($std);


        //Node com Grupo sobre exportação indireta, deve ser indicado logo após $nfe->tagdetExport($std) pois pertence a essa tag
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nRE = '123456789012';
        $std->chNFe = '53170924915365000295550550000001951000001952';
        $std->qExport = 1234.123;

        $nfe->tagdetExportInd($std);
        //Node com os dados de rastreabilidade do item da NFe
        //Método Incluso para atender layout 4.00

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nLote = '11111';
        $std->qLote = 200;
        $std->dFab = '2018-01-01';
        $std->dVal = '2020-01-01';
        $std->cAgreg = '1234';

        $nfe->tagRastro($std);

        //Node com o detalhamento de Veículos novos do item da NFe

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->tpOp;
        $std->chassi;
        $std->cCor;
        $std->xCor;
        $std->pot;
        $std->cilin;
        $std->pesoL;
        $std->pesoB;
        $std->nSerie;
        $std->tpComb;
        $std->nMotor;
        $std->CMT;
        $std->dist;
        $std->anoMod;
        $std->anoFab;
        $std->tpPint;
        $std->tpVeic;
        $std->espVeic;
        $std->VIN;
        $std->condVeic;
        $std->cMod;
        $std->cCorDENATRAN;
        $std->lota;
        $std->tpRest;

        $nfe->tagveicProd($std);

        //NOTA: Ajustado conforme NT 2018.005 Node com o detalhamento de Medicamentos e de matérias-primas farmacêuticas
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->cProdANVISA = '1234567890123'; //incluido no layout 4.00
        $std->xMotivoIsencao = 'RDC 238';
        $std->vPMC = 102.22;

        $nfe->tagmed($std);


        //Node com informações e detalhamento de Armamento do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nAR; //Indicativo de número da arma
        $std->tpArma;
        $std->nSerie;
        $std->nCano;
        $std->descr;

        $nfe->tagarma($std);


        //Node das informações específicas para combustíveis líquidos e lubrificantes do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->cProdANP;

        $std->pMixGN; //removido no layout 4.00

        $std->descANP; //incluido no layout 4.00
        $std->pGLP; //incluido no layout 4.00
        $std->pGNn; //incluido no layout 4.00
        $std->pGNi; //incluido no layout 4.00
        $std->vPart; //incluido no layout 4.00

        $std->CODIF;
        $std->qTemp;
        $std->UFCons;
        $std->qBCProd;
        $std->vAliqProd;
        $std->vCIDE;

        $nfe->tagcomb($std);

        //Node das informações do grupo de “encerrante” disponibilizado por hardware específico acoplado à bomba de Combustível, definido no controle da venda do Posto Revendedor de Combustível. Referente ao item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->nBico;
        $std->nBomba;
        $std->nTanque;
        $std->vEncIni;
        $std->vEncFin;

        $nfe->tagencerrante($std);

        //Node inicial dos Tributos incidentes no Produto ou Serviço do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->vTotTrib = 1000.00;

        $nfe->tagimposto($std);

        //NOTA: Ajustado conforme NT 2018.005_1.10 Node com informações do ICMS do item da NFe

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->orig;
        $std->CST;
        $std->modBC;
        $std->vBC;
        $std->pICMS;
        $std->vICMS;
        $std->pFCP;
        $std->vFCP;
        $std->vBCFCP;
        $std->modBCST;
        $std->pMVAST;
        $std->pRedBCST;
        $std->vBCST;
        $std->pICMSST;
        $std->vICMSST;
        $std->vBCFCPST;
        $std->pFCPST;
        $std->vFCPST;
        $std->vICMSDeson;
        $std->motDesICMS;
        $std->pRedBC;
        $std->vICMSOp;
        $std->pDif;
        $std->vICMSDif;
        $std->vBCSTRet;
        $std->pST;
        $std->vICMSSTRet;
        $std->vBCFCPSTRet;
        $std->pFCPSTRet;
        $std->vFCPSTRet;
        $std->pRedBCEfet;
        $std->vBCEfet;
        $std->pICMSEfet;
        $std->vICMSEfet;
        $std->vICMSSubstituto; //NT2018.005_1.10_Fevereiro de 2019

        $nfe->tagICMS($std);

        //Node com informações da partilha do ICMS entre a UF de origem e UF de destino ou a UF definida na legislação.
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->orig = 0;
        $std->CST = '90';
        $std->modBC = 0;
        $std->vBC = 1000.00;
        $std->pRedBC = null;
        $std->pICMS = 18.00;
        $std->vICMS = 180.00;
        $std->modBCST = 1000.00;
        $std->pMVAST = 40.00;
        $std->pRedBCST = null;
        $std->vBCST = 1400.00;
        $std->pICMSST = 10.00;
        $std->vICMSST = 140.00;
        $std->pBCOp = 10.00;
        $std->UFST = 'RJ';

        $nfe->tagICMSPart($std);

        //NOTA: Ajustado conforme NT 2018.005 e NT 2018.005_1.10 Node Repasse de ICMS ST retido anteriormente em operações interestaduais com repasses através do Substituto Tributário
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->orig = 0;
        $std->CST = '60';
        $std->vBCSTRet = 1000.00;
        $std->vICMSSTRet = 190.00;
        $std->vBCSTDest = 1000.00;
        $std->vICMSSTDest = 1.00;
        $std->vBCFCPSTRet = 1000.00;
        $std->pFCPSTRet = 1.00;
        $std->vFCPSTRet = 10.00;
        $std->pST = null;
        $std->vICMSSubstituto = null;
        $std->pRedBCEfet = null;
        $std->vBCEfet = null;
        $std->pICMSEfet = null;
        $std->vICMSEfet = null;

        $nfe->tagICMSST($std);


        //Node referente Tributação ICMS pelo Simples Nacional do item da NFe

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->orig = 0;
        $std->CSOSN = '101';
        $std->pCredSN = 2.00;
        $std->vCredICMSSN = 20.00;
        $std->modBCST = null;
        $std->pMVAST = null;
        $std->pRedBCST = null;
        $std->vBCST = null;
        $std->pICMSST = null;
        $std->vICMSST = null;
        $std->vBCFCPST = null; //incluso no layout 4.00
        $std->pFCPST = null; //incluso no layout 4.00
        $std->vFCPST = null; //incluso no layout 4.00
        $std->vBCSTRet = null;
        $std->pST = null;
        $std->vICMSSTRet = null;
        $std->vBCFCPSTRet = null; //incluso no layout 4.00
        $std->pFCPSTRet = null; //incluso no layout 4.00
        $std->vFCPSTRet = null; //incluso no layout 4.00
        $std->modBC = null;
        $std->vBC = null;
        $std->pRedBC = null;
        $std->pICMS = null;
        $std->vICMS = null;
        $std->pRedBCEfet = null;
        $std->vBCEfet = null;
        $std->pICMSEfet = null;
        $std->vICMSEfet = null;
        $std->vICMSSubstituto = null;

        $nfe->tagICMSSN($std);

        //Node de informação do ICMS Interestadual do item na NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->vBCUFDest = 100.00;
        $std->vBCFCPUFDest = 100.00;
        $std->pFCPUFDest = 1.00;
        $std->pICMSUFDest = 18.00;
        $std->pICMSInter = 12.00;
        $std->pICMSInterPart = 80.00;
        $std->vFCPUFDest = 1.00;
        $std->vICMSUFDest = 14.44;
        $std->vICMSUFRemet = 3.56;

        $nfe->tagICMSUFDest($std);


        //Node referente ao IPI do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->clEnq = null;
        $std->CNPJProd = null;
        $std->cSelo = null;
        $std->qSelo = null;
        $std->cEnq = '999';
        $std->CST = '50';
        $std->vIPI = 150.00;
        $std->vBC = 1000.00;
        $std->pIPI = 15.00;
        $std->qUnid = null;
        $std->vUnid = null;

        $nfe->tagIPI($std);

        //Node Imposto de Importação do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->vBC = 1000.00;
        $std->vDespAdu = 100.00;
        $std->vII = 220.00;
        $std->vIOF = null;

        $nfe->tagII($std);

        //Node PIS Substituição Tributária do item da NFe

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->vPIS =  16.00;
        $std->vBC = 1000.00;
        $std->pPIS = 1.60;
        $std->qBCProd = null;
        $std->vAliqProd = null;

        $nfe->tagPISST($std);

        //Node COFINS do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->CST = '07';
        $std->vBC = null;
        $std->pCOFINS = null;
        $std->vCOFINS = null;
        $std->qBCProd = null;
        $std->vAliqProd = null;

        $nfe->tagCOFINS($std);

        //Node COFINS Substituição Tributária do item da NFe

        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->vCOFINS = 289.30;
        $std->vBC = 2893.00;
        $std->pCOFINS = 10.00;
        $std->qBCProd = null;
        $std->vAliqProd = null;

        $nfe->tagCOFINSST($std);


        //Node ISSQN do item da NFe
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->vBC = 1000.00;
        $std->vAliq = 5.00;
        $std->vISSQN = 50.00;
        $std->cMunFG = '3518800';
        $std->cListServ = '12.23';
        $std->vDeducao = null;
        $std->vOutro = null;
        $std->vDescIncond = null;
        $std->vDescCond = null;
        $std->vISSRet = null;
        $std->indISS = 2;
        $std->cServico = '123';
        $std->cMun = '3518800';
        $std->cPais = '1058';
        $std->nProcesso = null;
        $std->indIncentivo = 2;

        $nfe->tagISSQN($std);

        //Node referente a informação do Imposto devolvido
        $std = new \stdClass();
        $std->item = 1; //item da NFe
        $std->pDevol = 2.00;
        $std->vIPIDevol = 123.36;

        $nfe->tagimpostoDevol($std);

        //Node dos totais referentes ao ICMS
        //NOTA: Esta tag não necessita que sejam passados valores, pois a classe irá calcular esses totais e irá usar essa totalização para complementar e gerar esse node, caso nenhum valor seja passado como parâmetro.
        $std = new \stdClass();
        $std->vBC = 1000.00;
        $std->vICMS = 1000.00;
        $std->vICMSDeson = 1000.00;
        $std->vFCP = 1000.00; //incluso no layout 4.00
        $std->vBCST = 1000.00;
        $std->vST = 1000.00;
        $std->vFCPST = 1000.00; //incluso no layout 4.00
        $std->vFCPSTRet = 1000.00; //incluso no layout 4.00
        $std->vProd = 1000.00;
        $std->vFrete = 1000.00;
        $std->vSeg = 1000.00;
        $std->vDesc = 1000.00;
        $std->vII = 1000.00;
        $std->vIPI = 1000.00;
        $std->vIPIDevol = 1000.00; //incluso no layout 4.00
        $std->vPIS = 1000.00;
        $std->vCOFINS = 1000.00;
        $std->vOutro = 1000.00;
        $std->vNF = 1000.00;
        $std->vTotTrib = 1000.00;

        $nfe->tagICMSTot($std);


        //Node de Totais referentes ao ISSQN
        //NOTA: caso os valores não existam indique "null". Se for indicado 0.00 esse número será incluso no XML o que poderá causar sua rejeição.
        $std = new \stdClass();
        $std->vServ = 1000.00;
        $std->vBC = 1000.00;
        $std->vISS = 10.00;
        $std->vPIS = 2.00;
        $std->vCOFINS = 6.00;
        $std->dCompet = '2017-09-12';
        $std->vDeducao = 10.00;
        $std->vOutro = 10.00;
        $std->vDescIncond = null;
        $std->vDescCond = null;
        $std->vISSRet = null;
        $std->cRegTrib = 5;

        $nfe->tagISSQNTot($std);


        //Node referente a retenções de tributos
        /* Exemplos de atos normativos que definem obrigatoriedade da retenção de contribuições:

        a) IRPJ/CSLL/PIS/COFINS - Fonte - Recebimentos de Órgão Público Federal, Lei no 9.430, de 27 de dezembro de 1996, art. 64, Lei no 10.833/2003, art. 34, como normas infralegais, temos como exemplo: IN SRF 480/2004 e IN 539, de 25/04/05.

        b) Retenção do Imposto de Renda pelas Fontes Pagadoras, REMUNERAÇÃO DE SERVIÇOS PROFISSIONAIS PRESTADOS POR PESSOA JURÍDICA, Lei no 7.450/85, art. 52

        c) IRPJ, CSLL, COFINS e PIS - Serviços Prestados por Pessoas Jurídicas - Retenção na Fonte, Lei no 10.833 de 29.12.2003, art. 30, 31, 32, 35 e 36
         */
        $std = new \stdClass();
        $std->vRetPIS = 100.00;
        $std->vRetCOFINS = 100.00;
        $std->vRetCSLL = 100.00;
        $std->vBCIRRF = 100.00;
        $std->vIRRF = 100.00;
        $std->vBCRetPrev = 100.00;
        $std->vRetPrev = 100.00;

        $nfe->tagretTrib($std);


        //Node indicativo da forma de frete

        $std = new \stdClass();
        $std->modFrete = 1;

        $nfe->tagtransp($std);

        //Node com os dados da transportadora
        $std = new \stdClass();
        $std->xNome = 'Rodo Fulano';
        $std->IE = '12345678901';
        $std->xEnder = 'Rua Um, sem numero';
        $std->xMun = 'Cotia';
        $std->UF = 'SP';
        $std->CNPJ = '12345678901234'; //só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
        $std->CPF = null;

        $nfe->tagtransporta($std);

        //Node referente a retenção de ICMS do serviço de transporte
        $std = new \stdClass();
        $std->vServ = 240.00;
        $std->vBCRet = 240.00;
        $std->pICMSRet = 1.00;
        $std->vICMSRet = 2.40;
        $std->CFOP = '5353';
        $std->cMunFG = '3518800';

        $nfe->tagretTransp($std);

        //Node para informação do veículo trator
        $std = new \stdClass();
        $std->placa = 'ABC1111';
        $std->UF = 'RJ';
        $std->RNTC = '999999';

        $nfe->tagveicTransp($std);

        //Node para informar os reboques/Dolly

        $std = new \stdClass();
        $std->placa = 'BCB0897';
        $std->UF = 'SP';
        $std->RNTC = '123456';

        $nfe->tagreboque($std);

        //Node para informar o vagão usado

        $std = new \stdClass();
        $std->vagao = 'YY452-19';

        $nfe->tagvagao($std);

        //Node para informar a balsa usada
        $std = new \stdClass();
        $std->balsa = 'BNAV111';

        $nfe->tagbalsa($std);

        //Node com as informações dos volumes transportados

        $std = new \stdClass();
        $std->item = 1; //indicativo do numero do volume
        $std->qVol = 2;
        $std->esp = 'caixa';
        $std->marca = 'OLX';
        $std->nVol = '11111';
        $std->pesoL = 10.50;
        $std->pesoB = 11.00;

        $nfe->tagvol($std);

        //Node com a identificação dos lacres, referentes ao volume

        $std = new \stdClass();
        $std->item = 1; //indicativo do numero do volume
        $std->nLacre = 'ZZEX425365';

        $nfe->taglacres($std);

        //Node com os dados da fatura
        $std = new \stdClass();
        $std->nFat = '1233';
        $std->vOrig = 1254.22;
        $std->vDesc = null;
        $std->vLiq = 1254.22;

        $nfe->tagfat($std);


        //Node de informações das duplicatas

        $std = new \stdClass();
        $std->nDup = '1233-1';
        $std->dVenc = '2017-08-22';
        $std->vDup = 1254.22;

        $nfe->tagdup($std);

        //Node referente as formas de pagamento OBRIGATÓRIO para NFCe a partir do layout 3.10 e também obrigatório para NFe (modelo 55) a partir do layout 4.00

        $std = new \stdClass();
        $std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)

        $nfe->tagpag($std);

        //Node com o detalhamento da forma de pagamento OBRIGATÓRIO para NFCe e NFe layout4.00
        $std = new \stdClass();
        $std->tPag = '03';
        $std->vPag = 200.00; //Obs: deve ser informado o valor pago pelo cliente
        $std->CNPJ = '12345678901234';
        $std->tBand = '01';
        $std->cAut = '3333333';
        $std->tpIntegra = 1; //incluso na NT 2015/002
        $std->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

        $nfe->tagdetPag($std);

        /*
            NOTA: para NFe (modelo 55), temos ...

            vPag=0.00 mas pode ter valor se a venda for à vista

            tPag é usualmente:

            15 = Boleto Bancário
            90 = Sem pagamento
            99 = Outros
            Porém podem haver casos que os outros nodes e valores tenham de ser usados.

            function taginfAdic($std):DOMElement
        */

        //Node referente as informações adicionais da NFe
        $std = new \stdClass();
        $std->infAdFisco = 'informacoes para o fisco';
        $std->infCpl = 'informacoes complementares';

        $nfe->taginfAdic($std);

        /*
            Campo de uso livre do contribuinte, Informar o nome do campo no atributo xCampo e o conteúdo do campo no xTexto

            NOTA: pode ser usado, por exemplo, para indicar outros destinatários de e-mail, além do próprio destinatário da NFe, como o contador, etc.
        */

        $std = new \stdClass();
        $std->xCampo = 'email';
        $std->xTexto = 'algum@mail.com';

        $nfe->tagobsCont($std);

        //Campo de uso livre do Fisco. Informar o nome do campo no atributo xCampo e o conteúdo do campo no xTexto

        $std = new \stdClass();
        $std->xCampo = 'Info';
        $std->xTexto = 'alguma coisa';

        $nfe->tagobsFisco($std);

        //Node com a identificação do processo ou ato concessório
        $std = new \stdClass();
        $std->nProc = 'ks7277272';
        $std->indProc = 0;

        $nfe->tagprocRef($std);

        //Node com dados de exportação.
        $std = new \stdClass();
        $std->UFSaidaPais = 'PR';
        $std->xLocExporta = 'Paranagua';
        $std->xLocDespacho = 'Informação do Recinto Alfandegado';

        $nfe->tagexporta($std);

        //Node com a informação adicional de compra
        $std = new \stdClass();
        $std->xNEmp = 'ajhjs8282828';
        $std->xPed = '828288jjshsjhjwj';
        $std->xCont = 'contrato 1234';

        $nfe->tagcompra($std);

        //Node com as informações de registro aquisições de cana
        $std = new \stdClass();
        $std->safra = '2017';
        $std->ref = '09/2017';
        $std->qTotMes = 20000;
        $std->qTotAnt = 18000;
        $std->qTotGer = 38000;
        $std->vFor = 2500.00;
        $std->vTotDed = 500.00;
        $std->vLiqFor = 2000.00;

        $nfe->tagcana($std);

        //Node informativo do fornecimento diário de cana
        $std = new \stdClass();
        $std->dia = 1;
        $std->qtde = 1000;

        $nfe->tagforDia($std);

        //Node Grupo Deduções – Taxas e Contribuições da aquisição de cana
        $std = new \stdClass();
        $std->xDed = 'deducao 1';
        $std->vDed = 100.00;

        $nfe->tagdeduc($std);

        //Node das informações suplementares da NFCe.
        //Não é necessário informar será preenchido automaticamente após a assinatura da NFCe

        $std = new \stdClass();
        $std->qrcode;
        $std->urlChave;

        $nfe->taginfNFeSupl($std);

        //Node da informação referente ao Responsável Técnico NT 2018.005 Esta tag é OPCIONAL mas se for passada todos os campos devem ser passados para a função.
        $std = new \stdClass();
        $std->CNPJ = '99999999999999'; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        $std->xContato = 'Fulano de Tal'; //Nome da pessoa a ser contatada
        $std->email = 'fulano@soft.com.br'; //E-mail da pessoa jurídica a ser contatada
        $std->fone = '1155551122'; //Telefone da pessoa jurídica/física a ser contatada
        $std->CSRT = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO'; //Código de Segurança do Responsável Técnico
        $std->idCSRT = '01'; //Identificador do CSRT

        $nfe->taginfRespTec($std);


        //Este método chama o metodo monta(), mantido apenas para compatibilidade.
        $xml = $nfe->montaNFe();

        //Este método executa a montagem do XML
        //NOTA: irá retornar uma Exception caso existam erros na montagem OU retorna o XML montado caso não hajam erros.
        // $xml = $nfe->monta();

        //Este método retorna o XML em uma string, mesmo que existam erros.
        $xml = $nfe->getXML();

        //Este método retorna o numero da chave da NFe
        $chave = $nfe->getChave();

        //Este método retorna o modelo de NFe 55 ou 65

        $modelo = $nfe->getModelo();
    }

    public function getPdfXml(String $xml = '<h1>Hello world!</h1>')
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
        $mpdf->WriteHTML($xml);
        $mpdf->Output();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
