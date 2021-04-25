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

    public function Produto(Array $dados)
    {
        //Node de dados do produto/serviço

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


    public function Icms(Array $dados)
    {

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


}
