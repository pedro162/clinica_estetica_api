<?php

namespace App\Fiscal;
use App\Interaces\Nfe as NfeInterface;
use App\Fiscal\FacadeNfe;
use \stdClass;

class Nfe
{
    protected $objFacadeNfe;
    protected $errors;


    public function __construct(FacadeNfe $obj)
    {
        $this->objFacadeNfe = $obj;
    }

    public function infNfe(Array $dados)
    {
        //contêm os dados dos campos, nomeados conforme manual

        $std = new \stdClass();
        $std->versao    = $dados['versao']; //versão do layout (string)
        $std->Id        = $dados['Id']; //se o Id de 44 digitos não for passado será gerado automaticamente
        $std->pk_nItem  = $dados['pk_nItem']; //deixe essa variavel sempre como NULL

        $this->objFacadeNfe->taginfNFe($std);
    }

    public function Emitente(Array $dados)
    {
        
        //Node com os dados do emitente
        $std            = new \stdClass();
        $std->xNome     = $dados['xNome'];
        $std->xFant     = $dados['xFant'];
        $std->IE        = $dados['IE'];
        $std->IEST      = $dados['IEST'];
        $std->IM        = $dados['IM'];
        $std->CNAE      = $dados['CNAE'];
        $std->CRT       = $dados['CRT'];
        
        if(isset($dados['CPF']) && $dados['CPF']){
            $std->CPF       = $dados['CPF'];
        }else{
            $std->CNPJ      = $dados['CNPJ']; //indicar apenas um CNPJ ou CPF
        }
        

        $this->objFacadeNfe->tagemit($std);
    } 

    public function enderecoEmitente(Array $dados)
    {
        //Node com o endereço do emitente
        $std = new \stdClass();
        $std->xLgr      = $dados['xLgr'];
        $std->nro       = $dados['nro'];
        $std->xCpl      = $dados['xCpl'];
        $std->xBairro   = $dados['xBairro'];
        $std->cMun      = $dados['cMun'];
        $std->xMun      = $dados['xMun'];
        $std->UF        = $dados['UF'];
        $std->CEP       = $dados['CEP'];
        $std->cPais     = $dados['cPais'];
        $std->xPais     = $dados['xPais'];
        $std->fone      = $dados['fone'];

        $this->objFacadeNfe->tagenderEmit($std);
    }

    public function Destinatario(Array $dados)
    {
        //Node com os dados do destinatário
        $std = new \stdClass();
        $std->xNome         = $dados['xNome'];
        $std->indIEDest     = $dados['indIEDest'];
        $std->IE            = $dados['IE'];
        $std->ISUF          = $dados['ISUF'];
        $std->IM            = $dados['IM'];
        $std->email         = $dados['email'];
        
        if(isset($dados['CPF']) && $dados['CPF']){
            $std->CPF       = $dados['CPF'];
        }else{
            $std->CNPJ      = $dados['CNPJ']; //indicar apenas um CNPJ ou CPF
        }
        //$std->CNPJ          = $dados['CNPJ']; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
        //$std->CPF           = $dados['CPF'];
        $std->idEstrangeiro = $dados['idEstrangeiro'];

        $this->objFacadeNfe->tagdest($std);
    } 

    public function enderecoDestinatario(Array $dados)
    {
        //Node de endereço do destinatário
        $std            = new \stdClass();
        $std->xLgr      = $dados['xLgr'];
        $std->nro       = $dados['nro'];
        $std->xCpl      = $dados['xCpl'];
        $std->xBairro   = $dados['xBairro'];
        $std->cMun      = $dados['cMun'];
        $std->xMun      = $dados['xMun'];
        $std->UF        = $dados['UF'];
        $std->CEP       = $dados['CEP'];
        $std->cPais     = $dados['cPais'];
        $std->xPais     = $dados['xPais'];
        $std->fone      = $dados['fone'];

        $this->objFacadeNfe->tagenderDest($std);
    }


    public function IdentificacaoDaNota(Array $dados)
    {
        //Node de identificação da NFe


        $std = new \stdClass();
        $std->cUF       = $dados['cUF'];
        $std->cNF       = $dados['cNF'];
        $std->natOp     = $dados['natOp'];

        $std->indPag    = $dados['indPag']; //NÃO EXISTE MAIS NA VERSÃO 4.00 Na NF-e existe o campo natOp - Descrição da Natureza da Operação da NF-e. Esse campo deve ser preenchido com a natureza da operação de que decorrer a saída ou a entrada, tais como: venda, compra, transferência, devolução, importação, consignação, remessa (para fins de demonstração, de industrialização ou outra), conforme previsto na alínea 'i', inciso I, art. 19 do CONVÊNIO S/Nº, de 15 de dezembro de 1970.

        $std->mod       = $dados['mod'];//55 = NF-e 65 = NFC-e
        $std->serie     = $dados['serie'];
        $std->nNF       = $dados['nNF']; //Número do Documento Fiscal da NF-e
        $std->dhEmi     = $dados['dhEmi'];//'2015-02-19T13:48:00-02:00';
        $std->dhSaiEnt  = $dados['dhSaiEnt'];
        $std->tpNF      = $dados['tpNF']; //0 = Entrada       1 = Saída//Tipo de Operação da NF-e
        $std->idDest    = $dados['idDest'];//Operação de Destino (idDest)
        $std->cMunFG    = $dados['cMunFG'];//cMunFG - Código do município de ocorrência do fato gerador do ICMS do transporte da NF-e
        $std->tpImp     = $dados['tpImp']; //Descrição Ele Pai Tipo Ocor. Tam. Dec. Observação 25 B21 tpImp Formato do DANFE 
        $std->tpEmis    = $dados['tpEmis'];//Na NF-e existe o campo tpEmis - Tipo de Emissão da NF-e. Esse campo pode ser preenchido com os seguintes valores:
        /*
         1 = Emissão normal (não em contingência)
        2 = Contingência FS-IA, com impressão do DANFE em formulário de segurança
        3 = Contingência SCAN (Sistema de Contingência do Ambiente Nacional)
        4 = Contingência DPEC (Declaração Prévia da Emissão em Contingência)
        5 = Contingência FS-DA, com impressão do DANFE em formulário de segurança
        6 = Contingência SVC-AN (SEFAZ Virtual de Contingência do AN)
        7 = Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)
         */

        $std->cDV       = $dados['cDV'];//Dígito Verificador da Chave de Acesso da NF-e
        $std->tpAmb     = $dados['tpAmb']; //Identificação de Ambiente da NF-e 1 = Produção.    2 = Homologação
        $std->finNFe    = $dados['finNFe']; //Na NF-e existe o campo finNFe - Finalidade de Emissão da NF-e. Esse campo pode ser preenchido com os seguintes valores:
        /*
        1 = NF-e normal.
        2 = NF-e complementar.
        3 = NF-e de ajuste.
        4 = Devolução de mercadoria.
        */
        
        $std->indFinal  = $dados['indFinal']; //Operação com Consumidor Final
        /*
        A tag IndFinal deverá ser preenchida com “0 – Normal” quando a operação não for realizada com consumidor final.
        A tag IndFinal deverá ser preenchida com “1 – Consumidor Final” quando a operação for realizada com consumidor final.
        */
        
        $std->indPres    = $dados['indPres']; //Como informar a tag indPres (Indicador de presença consumidor da
        $std->procEmi    = $dados['procEmi']; // Processo de emissão da NF-e
        /*
        0 = Emissão de NF-e com aplicativo do contribuinte.
        1 = Emissão de NF-e avulsa pelo Fisco.
        2 = Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco.
        3 = Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
        */
        $std->verProc    = $dados['verProc']; // Versão do Processo de emissão da NF-e
        $std->dhCont     = $dados['dhCont']; 
        $std->xJust      = $dados['xJust']; 
        

        $this->objFacadeNfe->tagide($std);
    } 

    /** 
     * Node referente a NFe referenciada
     */
    public function nfReferenciada(Array $dados)
    {
        //

        $std = new \stdClass();
        $std->refNFe    = $dados['refNFe'];
        
        $this->objFacadeNfe->tagrefNFe($std);
    } 

    public function nfReferenciadaDetalhes(Array $dados)
    {
        //

        $std = new \stdClass();
        $std->cUF   = $dados['cUF'];
        $std->AAMM  = $dados['AAMM'];
        $std->CNPJ  = $dados['CNPJ'];
        $std->mod   = $dados['mod'];
        $std->serie = $dados['serie'];
        $std->nNF   = $dados['nNF'];
        
        $this->objFacadeNfe->tagrefNF($std);
    } 

    /** 
     * Node de dados do produto/serviço
     */
    public function Produto(Array $dados)
    {
        //
       
        $std = new \stdClass();
        $std->item      = $dados['item']; //item da NFe
        $std->cProd     = $dados['cProd'];
        $std->cEAN      = $dados['cEAN'];
        $std->xProd     = $dados['xProd'];
        $std->NCM       = $dados['NCM'];

        $std->cBenef    = $dados['cBenef']; //incluido no layout 4.00

        $std->EXTIPI    = $dados['EXTIPI'];
        $std->CFOP      = $dados['CFOP'];
        $std->uCom      = $dados['uCom'];
        $std->qCom      = $dados['qCom'];
        $std->vUnCom    = $dados['vUnCom'];
        $std->vProd     = $dados['vProd'];
        $std->cEANTrib  = $dados['cEANTrib'];
        $std->uTrib     = $dados['uTrib'];
        $std->qTrib     = $dados['qTrib'];
        $std->vUnTrib   = $dados['vUnTrib'];
        $std->vFrete    = $dados['vFrete'];
        $std->vSeg      = $dados['vSeg'];
        $std->vDesc     = $dados['vDesc'];
        $std->vOutro    = $dados['vOutro'];
        $std->indTot    = $dados['indTot'];
        $std->xPed      = $dados['xPed'];
        $std->nItemPed  = $dados['nItemPed'];
        $std->nFCI      = $dados['nFCI'];
        $this->objFacadeNfe->tagprod($std);
    } 

    /**
     * Informções adicionais para o item da nota
     */
    public function infoAdocionaisProduto(Array $dados)
    {
        $std = new \stdClass();
        $std->item    = $dados['infAdProd'];
        $std->infAdProd    = $dados['infAdProd'];
        
        $this->objFacadeNfe->taginfAdProd($std);
    } 


    /**
     * Node com a Nomenclatura de Valor Aduaneiro e Estatística do item da NFe
     */
    public function nomeclaturaAdicAtuaneiro(Array $dados)
    {
        $std = new \stdClass();
        $std->item  = $dados['item']; //item da NFe
        $std->NVE   = $dados['NVE'];

        $this->objFacadeNfe->tagNVE($std);
    } 

    /**
     * Node de detalhamento do Especificador da Substituição Tributária do item da NFe
     */
    public function cest(Array $dados)
    {
        $std = new \stdClass();

        $std->item      = $dados['item']; //item da NFe
        $std->CEST      = $dados['CEST'];
        $std->indEscala = $dados['indEscala']; //incluido no layout 4.00
        $std->CNPJFab   = $dados['CNPJFab']; //incluido no layout 4.00

        $this->objFacadeNfe->tagCEST($std);
    } 

     /**
     * Node com o número do RECOPI
     */
    public function recopi(Array $dados)
    {
        $std = new \stdClass();

        $std->item      = $dados['item']; //item da NFe
        $std->nRECOPI   = $dados['nRECOPI'];
        $this->objFacadeNfe->tagRECOPI($std);
    }
    
     /**
     * Node com informações da Declaração de Importação do item da NFe
     */
    public function declaracaoImportacao(Array $dados)
    {
        $std = new \stdClass();

        $std->item              = $dados['item']; //item da NFe
        $std->nDI               = $dados['nDI'];  
        $std->dDI               = $dados['dDI'];
        $std->xLocDesemb        = $dados['xLocDesemb'];
        $std->UFDesemb          = $dados['UFDesemb'];
        $std->dDesemb           = $dados['dDesemb'];
        $std->tpViaTransp       = $dados['tpViaTransp'];
        $std->vAFRMM            = $dados['vAFRMM'];
        $std->tpIntermedio      = $dados['tpIntermedio'];
        $std->CNPJ              = $dados['CNPJ'];
        $std->UFTerceiro        = $dados['UFTerceiro'];
        $std->cExportador       = $dados['cExportador'];
        $this->objFacadeNfe->tagDI($std);
    }


    /** 
     * NOTA: Ajustado para NT 2018.005 Node indicativo de local de retirada diferente do endereço do emitente
     */
    public function localRetirada(Array $dados)
    {
        
        $std = new \stdClass();
        if(isset($dados['CPF']) && $dados['CPF']){
            $std->CPF       = $dados['CPF'];//indicar apenas um CNPJ ou CPF
        }else{
            $std->CNPJ      = $dados['CNPJ']; //indicar apenas um CNPJ ou CPF
        }
        $std->IE        = $dados['IE'];
        $std->xNome     = $dados['xNome'];
        $std->xLgr      = $dados['xLgr'];
        $std->nro       = $dados['nro'];
        $std->xCpl      = $dados['xCpl'];
        $std->xBairro   = $dados['xBairro'];
        $std->cMun      = $dados['cMun'];
        $std->xMun      = $dados['xMun'];
        $std->UF        = $dados['UF'];
        $std->CEP       = $dados['CEP'];
        $std->cPais     = $dados['cPais'];
        $std->xPais     = $dados['xPais'];
        $std->fone      = $dados['fone'];
        $std->email     = $dados['email'];

        $this->objFacadeNfe->tagretirada($std);
    }

    /** 
     * NOTA: Ajustado para NT 2018.005 Node indicativo de local de retirada diferente do endereço do emitente
     */
    public function localEntrega(Array $dados)
    {
        
        $std = new \stdClass();
        if(isset($dados['CPF']) && $dados['CPF']){
            $std->CPF       = $dados['CPF'];//indicar apenas um CNPJ ou CPF
        }else{
            $std->CNPJ      = $dados['CNPJ']; //indicar apenas um CNPJ ou CPF
        }
        $std->IE        = $dados['IE'];
        $std->xNome     = $dados['xNome'];
        $std->xLgr      = $dados['xLgr'];
        $std->nro       = $dados['nro'];
        $std->xCpl      = $dados['xCpl'];
        $std->xBairro   = $dados['xBairro'];
        $std->cMun      = $dados['cMun'];
        $std->xMun      = $dados['xMun'];
        $std->UF        = $dados['UF'];
        $std->CEP       = $dados['CEP'];
        $std->cPais     = $dados['cPais'];
        $std->xPais     = $dados['xPais'];
        $std->fone      = $dados['fone'];
        $std->email     = $dados['email'];

        $this->objFacadeNfe->tagentrega($std);
    }

    /**
     * Node inicial dos Tributos incidentes no Produto ou Serviço do item da NFe
     */
    public function imposto(Array $dados)
    {
        //
        $std = new \stdClass();
        $std->item = $dados['item']; //item da NFe
        $std->vTotTrib = $dados['vTotTrib'];

        $this->objFacadeNfe->tagimposto($std);
    } 

    /**
     * NOTA: Ajustado conforme NT 2018.005_1.10 Node com informações do ICMS do item da NFe
     */
    public function icms(Array $dados)
    {
        $std = new \stdClass();
        $std->item          = $dados['item']; //item da NFe
        $std->orig          = $dados['orig'];
        $std->CST           = $dados['CST'];
        $std->modBC         = $dados['modBC'];
        $std->vBC           = $dados['vBC'];
        $std->pICMS         = $dados['pICMS'];
        $std->vICMS         = $dados['vICMS'];
        $std->pFCP          = $dados['pFCP'];
        $std->vFCP          = $dados['vFCP'];
        $std->vBCFCP        = $dados['vBCFCP'];
        $std->modBCST       = $dados['modBCST'];
        $std->pMVAST        = $dados['pMVAST'];
        $std->pRedBCST      = $dados['pRedBCST'];
        $std->vBCST         = $dados['vBCST'];
        $std->pICMSST       = $dados['pICMSST'];
        $std->vICMSST       = $dados['vICMSST'];
        $std->vBCFCPST      = $dados['vBCFCPST'];
        $std->pFCPST        = $dados['pFCPST'];
        $std->vFCPST        = $dados['vFCPST'];
        $std->vICMSDeson    = $dados['vICMSDeson'];
        $std->motDesICMS    = $dados['motDesICMS'];
        $std->pRedBC        = $dados['pRedBC'];
        $std->vICMSOp       = $dados['vICMSOp'];
        $std->pDif          = $dados['pDif'];
        $std->vICMSDif      = $dados['vICMSDif'];
        $std->vBCSTRet      = $dados['vBCSTRet'];
        $std->pST           = $dados['pST'];
        $std->vICMSSTRet    = $dados['vICMSSTRet'];
        $std->vBCFCPSTRet   = $dados['vBCFCPSTRet'];
        $std->pFCPSTRet     = $dados['pFCPSTRet'];
        $std->vFCPSTRet     = $dados['vFCPSTRet'];
        $std->pRedBCEfet    = $dados['pRedBCEfet'];
        $std->vBCEfet       = $dados['vBCEfet'];
        $std->pICMSEfet     = $dados['pICMSEfet'];
        $std->vICMSEfet     = $dados['vICMSEfet'];
        $std->vICMSSubstituto  = $dados['vICMSSubstituto']; //NT2018.005_1.10_Fevereiro de 2019

        $this->objFacadeNfe->tagICMS($std);
    } 

    /**
     * Node com informações da partilha do ICMS entre a UF de origem e UF de destino ou a UF definida na legislação
     */
    public function imcsPartilha(Array $dados)
    {
        
        $std = new \stdClass();
        $std->item          = $dados['item']; //item da NFe
        $std->orig          = $dados['orig'];
        $std->CST           = $dados['CST'];
        $std->modBC         = $dados['modBC'];
        $std->vBC           = $dados['vBC'];
        $std->pRedBC        = $dados['pRedBC'];
        $std->pICMS         = $dados['pICMS'];
        $std->vICMS         = $dados['vICMS'];
        $std->modBCST       = $dados['modBCST'];
        $std->pMVAST        = $dados['pMVAST'];
        $std->pRedBCST      = $dados['pRedBCST'];
        $std->vBCST         = $dados['vBCST'];;
        $std->pICMSST       = $dados['pICMSST'];
        $std->vICMSST       = $dados['vICMSST'];
        $std->pBCOp         = $dados['pBCOp'];
        $std->UFST          = $dados['UFST'];

        $this->objFacadeNfe->tagICMSPart($std);
    }

    /**
     * Node de registro de pessoas autorizadas a acessar a NFe
     * Indicar um CNPJ ou CPF
     */
    public function autorizaPessoaAcessXml(Array $dados)
    {
        $std = new \stdClass();
        if(isset($dados['CPF']) && $dados['CPF']){
            $std->CPF       = $dados['CPF'];//indicar apenas um CNPJ ou CPF
        }else{
            $std->CNPJ      = $dados['CNPJ']; //indicar apenas um CNPJ ou CPF
        }
     
        $this->objFacadeNfe->tagautXML($std);
    }

    public function IcmsSn(Array $dados)
    {

    } 


    public function PisConfins(Array $dados)
    {

    } 

    public function Totais(Array $dados)
    {

    } 


    public function Transporte(Array $dados)
    {

    } 



    public function Pagamento(Array $dados)
    {

    } 


    public function EnviarAltorizar(Array $dados)
    {

    } 

    public function setErrors(String $erro):bool
    {
        if(strlen(trim($erro))){
            return false;
        }

        $this->errors[] = $erro;

        return true;
    }


    //-------------------------------------------------------------------------------------------------------
    public function config($razaoSocial, $siglauf, $cnpj, $tokenIbpt, $csc, $cscId, $chemes="PL_009_V4", $versao='4.00', $dtAtualizaçao= null, $tpAmbiente=2, $proxyConf = [
            "proxyIp"   => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    )
    {
        $arr = [
            "atualizacao" => $dtAtualizaçao ?? date('Y-m-d H:i:s'),
            "tpAmb"       => $tpAmbiente,
            "razaosocial" => $razaoSocial,
            "cnpj"        => $cnpj,
            "siglaUF"     => $siglauf,
            "schemes"     => $chemes,
            "versao"      => $versao,
            "tokenIBPT"   => $tokenIbpt,
            "CSC"         => $csc,//"GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G"
            "CSCid"       => $cscId,//"000001",
            "proxyConf"   => $proxyConf,
        ];
        $configJson = json_encode($arr);

        return $configJson;
    }

    public function getCertificade($path)
    {
        $pfxcontent = file_get_contents($path);
        return $pfxcontent;
    }

}
