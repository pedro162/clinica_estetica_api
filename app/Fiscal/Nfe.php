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

    } 


    public function IdentificacaoDaNota(Array $dados)
    {

    } 

    public function Produto(Array $dados)
    {

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
