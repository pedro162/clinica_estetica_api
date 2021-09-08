<?php

namespace App\Fiscal;

class VaidateNfe
{

    protected $errors;


    public function __construct()
    {
        $this->errors = [];
    }

    
    public function infNfe(Array $dados, Array $apenas):Array
    {
        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        //Node com os dados do emitente
        if(in_array('versao', $apenas)){
            if(! (strlen(trim( $dados['versao'])) > 0)){
                $this->errors[] = 'A versão da nota é obrigatório';
            }
        }

        if(in_array('Id', $apenas)){
            if(! (strlen(trim( $dados['Id'])) == 44)){
                $this->errors[] = 'A chave da nota deve ter 44 caractéres';
            }
        }

        if(in_array('pk_nItem', $apenas)){
            if(! (strlen(trim( $dados['pk_nItem'])) === null)){
                $this->errors[] = 'O pk_nItem deve ser nulo';
            }
        }

        return $this->errors;
    }

    public function Emitente(Array $dados, Array $apenas):Array
    {
        
        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        //Node com os dados do emitente
        if(in_array('xNome', $apenas)){
            if(! (strlen(trim( $dados['xNome'])) > 0)){
                $this->errors[] = 'Nome do destinatário é obrigatório';
            }
        }

        if(in_array('xFant', $apenas)){
            if(! (strlen(trim( $dados['xFant'])) > 0)){
                $this->errors[] = 'Nome fantazia é obrigatório';
            }
        }
        if(in_array('IE', $apenas)){
            if(! (strlen(trim( $dados['IE'])) > 0)){
                $this->errors[] = 'Inscrição Estadual é obrigatória';
            }
        }
        
        if(in_array('IEST', $apenas)){
            if(! (strlen(trim( $dados['IEST'])) > 0)){
                $this->errors[] = 'Inscrição Estadual do subistituto tributário é obrigatória';
            }
        }

        if(in_array('IM', $apenas)){
            if(! (strlen(trim( $dados['IM'])) > 0)){
                $this->errors[] = 'IM é obrigatório';
            }
        }

        if(in_array('CNAE', $apenas)){
            if(! (strlen(trim( $dados['CNAE'])) > 0)){
                $this->errors[] = 'CNAE - Classificação Nacional de Atividades Econômicas é obrigatório';
            }
        }

        if(in_array('CRT', $apenas)){
            if(! (strlen(trim( $dados['CRT'])) > 0)){
                $this->errors[] = 'Código do Regime Tributário é obrigatório';
            }
        }

        if(in_array('CNPJ', $apenas)){
            if(! (strlen(trim( $dados['CNPJ'])) > 0)){
                $this->errors[] = 'CNPJ do remetente é obrigatório';
            }
        }

        if(in_array('CPF', $apenas)){
            if(! (strlen(trim( $dados['CPF'])) > 0)){
                $this->errors[] = 'CPF do remetente é obrigatório';
            }
        }

        return $this->errors;

    }

    public function enderecoEmitente(Array $dados, Array $apenas)
    {
        //Node com o endereço do emitente

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        //Node com os dados do emitente
        if(in_array('xLgr', $apenas)){
            if(! (strlen(trim( $dados['xLgr'])) > 0)){
                $this->errors[] = 'Logaradouro do destinatário é obrigatório';
            }
        }

        if(in_array('nro', $apenas)){
            if(! (strlen(trim( $dados['nro'])) > 0)){
                $this->errors[] = 'O número é obrigatório';
            }
        }
        //Na NF-e existe o campo xCpl - Complemento (Local de retirada) da NF-e. Esse campo pode ser preenchido com o complemento do endereço do local de retirada, sendo opcional e com no máximo de 60 caracteres.
        if(in_array('xCpl', $apenas)){
            if(! (strlen(trim( $dados['xCpl'])) > 0)){
                $this->errors[] = 'Complemento (Local de retirada) do destinatário é obrigatório';
            }
        }
        
        if(in_array('xBairro', $apenas)){
            if(! (strlen(trim( $dados['xBairro'])) > 0)){
                $this->errors[] = 'Bairro do destinatário é obrigatóro.';
            }
        }

        if(in_array('cMun', $apenas)){
            if(! (strlen(trim( $dados['cMun'])) > 0)){
                $this->errors[] = 'Código do  município do destinatário é obrigatório';
            }
        }

        if(in_array('xMun', $apenas)){
            if(! (strlen(trim( $dados['xMun'])) > 0)){
                $this->errors[] = 'Nome do município  do destinatário é obrigatório';
            }
        }

        if(in_array('UF', $apenas)){
            if(! (strlen(trim( $dados['UF'])) > 0)){
                $this->errors[] = 'UF do destinatário é  obrigatória';
            }
        }

        if(in_array('CEP', $apenas)){
            if(! (strlen(trim( $dados['CEP'])) > 0)){
                $this->errors[] = 'CEP do destinatário é  obrigatória';
            }
        }

        if(in_array('cPais', $apenas)){
            if(! (strlen(trim( $dados['cPais'])) > 0)){
                $this->errors[] = 'Código do país do destinatário é  obrigatória';
            }
        }

        if(in_array('xPais', $apenas)){
            if(! (strlen(trim( $dados['xPais'])) > 0)){
                $this->errors[] = 'Nome do país do destinatário é  obrigatória';
            }
        }

        if(in_array('fone', $apenas)){
            if(! (strlen(trim( $dados['fone'])) > 0)){
                $this->errors[] = 'Fone do destinatário é  obrigatória';
            }
        }
        
        return $this->errors;
    } 


    public function Destinatario(Array $dados, Array $apenas):Array
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        //Node com os dados do destinatário
        if(in_array('xNome', $apenas)){
            if(! (strlen(trim( $dados['xNome'])) > 0)){
                $this->errors[] = 'Nome do destinatário é obrigatório';
            }
        }

        //Indicador da IE do Destinatário
        if(in_array('indIEDest', $apenas)){
            if(! (strlen(trim( $dados['indIEDest'])) > 0)){
                $this->errors[] = 'Indicador da IE do Destinatário é obrigatório';
            }
        }
        //Na NF-e existe o campo xCpl - Complemento (Local de retirada) da NF-e. Esse campo pode ser preenchido com o complemento do endereço do local de retirada, sendo opcional e com no máximo de 60 caracteres.
        if(in_array('IE', $apenas)){
            if(! (strlen(trim( $dados['IE'])) > 0)){
                $this->errors[] = 'IE do destinatário é obrigatório';
            }
        }
        
        if(in_array('ISUF', $apenas)){
            if(! (strlen(trim( $dados['ISUF'])) > 0)){
                $this->errors[] = 'ISUF é obrigatóro.';
            }
        }

        if(in_array('IM', $apenas)){
            if(! (strlen(trim( $dados['IM'])) > 0)){
                $this->errors[] = 'Código do  município do destinatário é obrigatório';
            }
        }

        if(in_array('email', $apenas)){
            if(! (strlen(trim( $dados['email'])) > 0)){
                $this->errors[] = 'E-mail  do destinatário é obrigatório';
            }
        }

        if(in_array('CNPJ', $apenas)){
            if(! (strlen(trim( $dados['CNPJ'])) > 0)){
                $this->errors[] = 'CNPJ do destinatário é  obrigatória';
            }
        }

        if(in_array('CPF', $apenas)){
            if(! (strlen(trim( $dados['CPF'])) > 0)){
                $this->errors[] = 'CPF do destinatário é  obrigatória';
            }
        }

        if(in_array('idEstrangeiro', $apenas)){
            if(! (strlen(trim( $dados['idEstrangeiro'])) > 0)){
                $this->errors[] = 'idEstrangeiro do destinatário é  obrigatória';
            }
        }

        return $this->errors;
    } 


    public function enderecoDestinatario(Array $dados, Array $apenas)
    {
        //Node com o endereço do emitente

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        //Node com os dados do emitente
        if(in_array('xLgr', $apenas)){
            if(! (strlen(trim( $dados['xLgr'])) > 0)){
                $this->errors[] = 'Logaradouro do destinatário é obrigatório';
            }
        }

        if(in_array('nro', $apenas)){
            if(! (strlen(trim( $dados['nro'])) > 0)){
                $this->errors[] = 'O número é obrigatório';
            }
        }
        //Na NF-e existe o campo xCpl - Complemento (Local de retirada) da NF-e. Esse campo pode ser preenchido com o complemento do endereço do local de retirada, sendo opcional e com no máximo de 60 caracteres.
        if(in_array('xCpl', $apenas)){
            if(! (strlen(trim( $dados['xCpl'])) > 0)){
                $this->errors[] = 'Complemento (Local de retirada) do destinatário é obrigatório';
            }
        }
        
        if(in_array('xBairro', $apenas)){
            if(! (strlen(trim( $dados['xBairro'])) > 0)){
                $this->errors[] = 'Bairro do destinatário é obrigatóro.';
            }
        }

        if(in_array('cMun', $apenas)){
            if(! (strlen(trim( $dados['cMun'])) > 0)){
                $this->errors[] = 'Código do  município do destinatário é obrigatório';
            }
        }

        if(in_array('xMun', $apenas)){
            if(! (strlen(trim( $dados['xMun'])) > 0)){
                $this->errors[] = 'Nome do município  do destinatário é obrigatório';
            }
        }

        if(in_array('UF', $apenas)){
            if(! (strlen(trim( $dados['UF'])) > 0)){
                $this->errors[] = 'UF do destinatário é  obrigatória';
            }
        }

        if(in_array('CEP', $apenas)){
            if(! (strlen(trim( $dados['CEP'])) > 0)){
                $this->errors[] = 'CEP do destinatário é  obrigatória';
            }
        }

        if(in_array('cPais', $apenas)){
            if(! (strlen(trim( $dados['cPais'])) > 0)){
                $this->errors[] = 'Código do país do destinatário é  obrigatória';
            }
        }

        if(in_array('xPais', $apenas)){
            if(! (strlen(trim( $dados['xPais'])) > 0)){
                $this->errors[] = 'Nome do país do destinatário é  obrigatória';
            }
        }

        if(in_array('fone', $apenas)){
            if(! (strlen(trim( $dados['fone'])) > 0)){
                $this->errors[] = 'Fone do destinatário é  obrigatória';
            }
        }
        
        return $this->errors;
    } 

    public function IdentificacaoDaNota(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('cUF', $apenas)){
            if(! (strlen(trim( $dados['cUF'])) > 0)){
                $this->errors[] = 'cUF é obrigatório';
            }
        }


        if(in_array('cNF', $apenas)){
            if(! (strlen(trim( $dados['cNF'])) > 0)){
                $this->errors[] = 'cNF é obrigatório';
            }
        }

        
        if(in_array('natOp', $apenas)){
            if(! (strlen(trim( $dados['natOp'])) > 0)){
                $this->errors[] = 'natOp é obrigatório';
            }
        }
        
        if(in_array('indPag', $apenas)){
            if(! (strlen(trim( $dados['indPag'])) > 0)){
                $this->errors[] = 'indPag é obrigatóro.';
            }
        }

        if(in_array('mod', $apenas)){
            if(! (strlen(trim( $dados['mod'])) > 0)){
                $this->errors[] = 'mod é obrigatório';
            }
        }

        if(in_array('serie', $apenas)){
            if(! (strlen(trim( $dados['serie'])) > 0)){
                $this->errors[] = 'serie é obrigatório';
            }
        }

        if(in_array('nNF', $apenas)){
            if(! (strlen(trim( $dados['nNF'])) > 0)){
                $this->errors[] = 'nNF é  obrigatória';
            }
        }

        if(in_array('dhEmi', $apenas)){
            if(! (strlen(trim( $dados['dhEmi'])) > 0)){
                $this->errors[] = 'dhEmi é  obrigatória';
            }
        }

        if(in_array('dhSaiEnt', $apenas)){
            if(! (strlen(trim( $dados['dhSaiEnt'])) > 0)){
                $this->errors[] = 'dhSaiEnt é  obrigatória';
            }
        }

        if(in_array('tpNF', $apenas)){
            if(! (strlen(trim( $dados['tpNF'])) > 0)){
                $this->errors[] = 'tpNF é  obrigatória';
            }
        }

        if(in_array('idDest', $apenas)){
            if(! (strlen(trim( $dados['idDest'])) > 0)){
                $this->errors[] = 'idDest é  obrigatória';
            }
        }

        if(in_array('cMunFG', $apenas)){
            if(! (strlen(trim( $dados['cMunFG'])) > 0)){
                $this->errors[] = 'cMunFG é  obrigatória';
            }
        }

        if(in_array('tpImp', $apenas)){
            if(! (strlen(trim( $dados['tpImp'])) > 0)){
                $this->errors[] = 'tpImp é  obrigatória';
            }
        }

        if(in_array('tpEmis', $apenas)){
            if(! (strlen(trim( $dados['tpEmis'])) > 0)){
                $this->errors[] = 'tpEmis é  obrigatória';
            }
        }

        if(in_array('cDV', $apenas)){
            if(! (strlen(trim( $dados['cDV'])) > 0)){
                $this->errors[] = 'cDV é  obrigatória';
            }
        }

        if(in_array('tpAmb', $apenas)){
            if(! (strlen(trim( $dados['tpAmb'])) > 0)){
                $this->errors[] = 'tpAmb é  obrigatória';
            }
        }

        if(in_array('finNFe', $apenas)){
            if(! (strlen(trim( $dados['finNFe'])) > 0)){
                $this->errors[] = 'finNFe é  obrigatória';
            }
        }

        if(in_array('indFinal', $apenas)){
            if(! (strlen(trim( $dados['indFinal'])) > 0)){
                $this->errors[] = 'indFinal é  obrigatória';
            }
        }

        if(in_array('indPres', $apenas)){
            if(! (strlen(trim( $dados['indPres'])) > 0)){
                $this->errors[] = 'indPres é  obrigatória';
            }
        }

        if(in_array('procEmi', $apenas)){
            if(! (strlen(trim( $dados['procEmi'])) > 0)){
                $this->errors[] = 'procEmi é  obrigatória';
            }
        }

        if(in_array('verProc', $apenas)){
            if(! (strlen(trim( $dados['verProc'])) > 0)){
                $this->errors[] = 'verProc é  obrigatória';
            }
        }

        if(in_array('dhCont', $apenas)){
            if(! (strlen(trim( $dados['dhCont'])) > 0)){
                $this->errors[] = 'dhCont é  obrigatória';
            }
        }

        if(in_array('xJust', $apenas)){
            if(! (strlen(trim( $dados['xJust'])) > 0)){
                $this->errors[] = 'xJust é  obrigatória';
            }
        }
        
        return $this->errors;
    }
    
    public function Produto(Array $dados, Array $apenas)
    {
        if(in_array('item', $apenas)){
            if(! (strlen(trim( $dados['item'])) > 0)){
                $this->errors[] = 'Item é  obrigatória';
            }
        }

        if(in_array('cProd', $apenas)){
            if(! (strlen(trim( $dados['cProd'])) > 0)){
                $this->errors[] = 'Código do item é  obrigatória';
            }
        }

        if(in_array('cEAN', $apenas)){
            if(! (strlen(trim( $dados['cEAN'])) > 0)){
                $this->errors[] = 'Código de barras do item é  obrigatória';
            }
        }

        if(in_array('xProd', $apenas)){
            if(! (strlen(trim( $dados['xProd'])) > 0)){
                $this->errors[] = 'Nome do item é  obrigatória';
            }
        }

        if(in_array('NCM', $apenas)){
            if(! (strlen(trim( $dados['NCM'])) > 0)){
                $this->errors[] = 'NCM do item é  obrigatória';
            }
        }

        if(in_array('cBenef', $apenas)){
            if(! (strlen(trim( $dados['cBenef'])) > 0)){
                $this->errors[] = 'cBenef do item é  obrigatória';
            }
        }

        if(in_array('EXTIPI', $apenas)){
            if(! (strlen(trim( $dados['EXTIPI'])) > 0)){
                $this->errors[] = 'EXTIPI do item é  obrigatória';
            }
        }

        if(in_array('CFOP', $apenas)){
            if(! (strlen(trim( $dados['CFOP'])) > 0)){
                $this->errors[] = 'CFOP do item é  obrigatória';
            }
        }

        if(in_array('uCom', $apenas)){
            if(! (strlen(trim( $dados['uCom'])) > 0)){
                $this->errors[] = 'uCom do item é  obrigatória';
            }
        }

        if(in_array('qCom', $apenas)){
            if(! (strlen(trim( $dados['qCom'])) > 0)){
                $this->errors[] = 'qCom do item é  obrigatória';
            }
        }

        if(in_array('vUnCom', $apenas)){
            if(! (strlen(trim( $dados['vUnCom'])) > 0)){
                $this->errors[] = 'vUnCom do item é  obrigatória';
            }
        }

        if(in_array('vProd', $apenas)){
            if(! (strlen(trim( $dados['vProd'])) > 0)){
                $this->errors[] = 'Valor do item é  obrigatória';
            }
        }

        if(in_array('cEANTrib', $apenas)){
            if(! (strlen(trim( $dados['cEANTrib'])) > 0)){
                $this->errors[] = 'cEANTrib do item é  obrigatória';
            }
        }

        if(in_array('uTrib', $apenas)){
            if(! (strlen(trim( $dados['uTrib'])) > 0)){
                $this->errors[] = 'uTrib do item é  obrigatória';
            }
        }

        if(in_array('qTrib', $apenas)){
            if(! (strlen(trim( $dados['qTrib'])) > 0)){
                $this->errors[] = 'qTrib do item é  obrigatória';
            }
        }

        if(in_array('vUnTrib', $apenas)){
            if(! (strlen(trim( $dados['vUnTrib'])) > 0)){
                $this->errors[] = 'vUnTrib do item é  obrigatória';
            }
        }

        if(in_array('vFrete', $apenas)){
            if(! (strlen(trim( $dados['vFrete'])) > 0)){
                $this->errors[] = 'vFrete do item é  obrigatória';
            }
        }

        if(in_array('vSeg', $apenas)){
            if(! (strlen(trim( $dados['vSeg'])) > 0)){
                $this->errors[] = 'vSeg do item é  obrigatória';
            }
        }

        if(in_array('vDesc', $apenas)){
            if(! (strlen(trim( $dados['vDesc'])) > 0)){
                $this->errors[] = 'Valor do desconto é  obrigatória';
            }
        }

        if(in_array('vOutro', $apenas)){
            if(! (strlen(trim( $dados['vOutro'])) > 0)){
                $this->errors[] = 'vOutro do item é  obrigatória';
            }
        }

        if(in_array('indTot', $apenas)){
            if(! (strlen(trim( $dados['indTot'])) > 0)){
                $this->errors[] = 'indTot do item é  obrigatória';
            }
        }

        if(in_array('xPed', $apenas)){
            if(! (strlen(trim( $dados['xPed'])) > 0)){
                $this->errors[] = 'xPed do item é  obrigatória';
            }
        }

        if(in_array('nItemPed', $apenas)){
            if(! (strlen(trim( $dados['nItemPed'])) > 0)){
                $this->errors[] = 'nItemPed do item é  obrigatória';
            }
        }

        if(in_array('nFCI', $apenas)){
            if(! (strlen(trim( $dados['nFCI'])) > 0)){
                $this->errors[] = 'nFCI do item é  obrigatória';
            }
        }
        
        return $this->errors;
    }
    

    public function nfReferenciada(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('refNFe', $apenas)){
            if(! (strlen(trim( $dados['refNFe'])) > 0)){
                $this->errors[] = 'A nota fiscal de referência é obrigatória';
            }
        }
        
        return $this->errors;
    }

    public function infoAdocionaisProduto(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('item', $apenas)){
            if(! (strlen(trim( $dados['item'])) > 0)){
                $this->errors[] = 'O itempara informações adicionais é obrigatório';
            }
        }

        if(in_array('infAdProd', $apenas)){
            if(! (strlen(trim( $dados['infAdProd'])) > 0)){
                $this->errors[] = 'A informação adicional do item é obrigatória';
            }
        }
        
        return $this->errors;
    }

    public function localEntregaRetirada(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('IE', $apenas)){
            if(! (strlen(trim( $dados['IE'])) > 0)){
                $this->errors[] = 'A inscrição estadual é obrigatória para entrega / retirada';
            }
        }

        if(in_array('xNome', $apenas)){
            if(! (strlen(trim( $dados['xNome'])) > 0)){
                $this->errors[] = 'O nome do responsável pela entrega / retirada é obrigatória';
            }
        }

        if(in_array('xLgr', $apenas)){
            if(! (strlen(trim( $dados['xLgr'])) > 0)){
                $this->errors[] = 'O logradouro para entrega / retirada é obrigatória';
            }
        }

        if(in_array('nro', $apenas)){
            if(! (strlen(trim( $dados['nro'])) > 0)){
                $this->errors[] = 'O número do endereço para entrega / retirada é obrigatória';
            }
        }

        if(in_array('xCpl', $apenas)){
            if(! (strlen(trim( $dados['xCpl'])) > 0)){
                $this->errors[] = 'A caixa postal do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('xBairro', $apenas)){
            if(! (strlen(trim( $dados['xBairro'])) > 0)){
                $this->errors[] = 'O bairro do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('cMun', $apenas)){
            if(! (strlen(trim( $dados['cMun'])) > 0)){
                $this->errors[] = 'O código do minicípio do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('xMun', $apenas)){
            if(! (strlen(trim( $dados['xMun'])) > 0)){
                $this->errors[] = 'O nome do minicípio do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('UF', $apenas)){
            if(! (strlen(trim( $dados['UF'])) > 0)){
                $this->errors[] = 'A UF do endereço para entrega / retirada é obrigatória';
            }
        }

        if(in_array('CEP', $apenas)){
            if(! (strlen(trim( $dados['CEP'])) > 0)){
                $this->errors[] = 'O cep do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('cPais', $apenas)){
            if(! (strlen(trim( $dados['cPais'])) > 0)){
                $this->errors[] = 'O código do país do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('xPais', $apenas)){
            if(! (strlen(trim( $dados['xPais'])) > 0)){
                $this->errors[] = 'O nome do país do endereço para entrega / retirada é obrigatório';
            }
        }

        if(in_array('fone', $apenas)){
            if(! (strlen(trim( $dados['fone'])) > 0)){
                $this->errors[] = 'O telefone de contato do responsável pela entrega / retirada é obrigatório';
            }
        }

        if(in_array('email', $apenas)){
            if(! (strlen(trim( $dados['email'])) > 0)){
                $this->errors[] = 'O e-mail de contato do responsável pela entrega / retirada é obrigatório';
            }
        }     
        
        return $this->errors;
    }


    public function nfReferenciadaDetalhes(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('IE', $apenas)){
            if(! (strlen(trim( $dados['cUF'])) > 0)){
                $this->errors[] = 'O código da UF da nota fiscal referencia é obrigatório';
            }
        }
        
        if(in_array('AAMM', $apenas)){
            if(! (strlen(trim( $dados['AAMM'])) > 0)){
                $this->errors[] = 'O AAMM da nota fiscal referencia é obrigatório';
            }
        }

        if(in_array('CNPJ', $apenas)){
            if(! (strlen(trim( $dados['CNPJ'])) > 0)){
                $this->errors[] = 'O CNPJ da nota fiscal referencia é obrigatório';
            }
        }

        if(in_array('mod', $apenas)){
            if(! (strlen(trim( $dados['mod'])) > 0)){
                $this->errors[] = 'O modelo da nota fiscal referencia é obrigatório';
            }
        }

        if(in_array('serie', $apenas)){
            if(! (strlen(trim( $dados['serie'])) > 0)){
                $this->errors[] = 'O número de série da nota fiscal referencia obrigatório';
            }
        }
        
        if(in_array('nNF', $apenas)){
            if(! (strlen(trim( $dados['nNF'])) > 0)){
                $this->errors[] = 'O número da nota fiscal referencia obrigatório';
            }
        }
        
        return $this->errors;
    }


    public function imposto(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('item', $apenas)){
            if(! (strlen(trim( $dados['item'])) > 0)){
                $this->errors[] = 'O item para imposto é obrigatório';
            }
        }

        if(in_array('vTotTrib', $apenas)){
            if(! (strlen(trim( $dados['vTotTrib'])) > 0)){
                $this->errors[] = 'O valor total para imposto é obrigatório';
            }
        }

        return $this->errors;
    }

    public function icms(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('item', $apenas)){
            if(! (strlen(trim( $dados['item'])) > 0)){
                $this->errors[] = 'O item para icms é obrigatório';
            }
        }

        if(in_array('orig', $apenas)){
            if(! (strlen(trim( $dados['orig'])) > 0)){
                $this->errors[] = 'A origem do item para icms é obrigatório';
            }
        }

        if(in_array('CST', $apenas)){
            if(! (strlen(trim( $dados['CST'])) > 0)){
                $this->errors[] = 'O CST do item para icms é obrigatório';
            }
        }
        
        if(in_array('modBC', $apenas)){
            if(! (strlen(trim( $dados['modBC'])) > 0)){
                $this->errors[] = 'A modalidade da base de calculao para icms é obrigatório';
            }
        }

        if(in_array('vBC', $apenas)){
            if(! (strlen(trim( $dados['vBC'])) > 0)){
                $this->errors[] = 'A base de calculao para icms é obrigatório';
            }
        }

        if(in_array('pICMS', $apenas)){
            if(! (strlen(trim( $dados['pICMS'])) > 0)){
                $this->errors[] = 'A porcentagem de icms do item é obrigatório';
            }
        }

        if(in_array('vICMS', $apenas)){
            if(! (strlen(trim( $dados['vICMS'])) > 0)){
                $this->errors[] = 'O valor de icms do item é obrigatório';
            }
        }

        if(in_array('pFCP', $apenas)){
            if(! (strlen(trim( $dados['pFCP'])) > 0)){
                $this->errors[] = 'A porecentagem do fundo de combate a pobreza do icms do item é obrigatório';
            }
        }

        if(in_array('vFCP', $apenas)){
            if(! (strlen(trim( $dados['vFCP'])) > 0)){
                $this->errors[] = 'O valor do fundo de combate a pobreza do icms do item é obrigatório';
            }
        }

        if(in_array('vBCFCP', $apenas)){
            if(! (strlen(trim( $dados['vBCFCP'])) > 0)){
                $this->errors[] = 'O valor da base de calculo do fundo de combate a pobreza do icms do item é obrigatório';
            }
        }

        if(in_array('modBCST', $apenas)){
            if(! (strlen(trim( $dados['modBCST'])) > 0)){
                $this->errors[] = 'A modalidade da base de calculo da substituição tributária do icms do item é obrigatório';
            }
        }
        
        if(in_array('pMVAST', $apenas)){
            if(! (strlen(trim( $dados['pMVAST'])) > 0)){
                $this->errors[] = 'A porcentagem da margem do valor agregado  da substituição tributária do icms do item é obrigatória';
            }
        }
        
        if(in_array('pRedBCST', $apenas)){
            if(! (strlen(trim( $dados['pRedBCST'])) > 0)){
                $this->errors[] = 'A porcentagem da redução da base de calculo da substituição tributária do icms do item é obrigatória';
            }
        }

        if(in_array('vBCST', $apenas)){
            if(! (strlen(trim( $dados['vBCST'])) > 0)){
                $this->errors[] = 'O valor da redução da base de calculo da substituição tributária do icms do item é obrigatório';
            }
        }
        
        if(in_array('pICMSST', $apenas)){
            if(! (strlen(trim( $dados['pICMSST'])) > 0)){
                $this->errors[] = 'A porcentagem do imcs de substituição tributária  do item é obrigatório';
            }
        }
        
        if(in_array('vICMSST', $apenas)){
            if(! (strlen(trim( $dados['vICMSST'])) > 0)){
                $this->errors[] = 'O valor do imcs de substituição tributária  do item é obrigatório';
            }
        }
        

        if(in_array('vBCFCPST', $apenas)){
            if(! (strlen(trim( $dados['vBCFCPST'])) > 0)){
                $this->errors[] = 'O valor da base de calculo do fundo de combate a pobresa da substituição tributária  do item é obrigatório';
            }
        }
        
        if(in_array('pFCPST', $apenas)){
            if(! (strlen(trim( $dados['pFCPST'])) > 0)){
                $this->errors[] = 'A porcentagem do fundo de combate a pobresa da substituição tributária  do item é obrigatória';
            }
        }

        if(in_array('vFCPST', $apenas)){
            if(! (strlen(trim( $dados['vFCPST'])) > 0)){
                $this->errors[] = 'O valor do fundo de combate a pobresa da substituição tributária  do item é obrigatório';
            }
        }
        
        if(in_array('vICMSDeson', $apenas)){
            if(! (strlen(trim( $dados['vICMSDeson'])) > 0)){
                $this->errors[] = 'O valor do icms desonerado do item é obrigatório';
            }
        }
        

        if(in_array('motDesICMS', $apenas)){
            if(! (strlen(trim( $dados['motDesICMS'])) > 0)){
                $this->errors[] = 'Motivo da desoneração do item é obrigatório';
            }
        }

        if(in_array('pRedBC', $apenas)){
            if(! (strlen(trim( $dados['pRedBC'])) > 0)){
                $this->errors[] = 'Porcentagem de redução da base de calculo do item é obrigatório';
            }
        }

        if(in_array('vICMSOp', $apenas)){
            if(! (strlen(trim( $dados['vICMSOp'])) > 0)){
                $this->errors[] = 'O  valor do imcms Op do item é obrigatório';
            }
        }
        

        if(in_array('pDif', $apenas)){
            if(! (strlen(trim( $dados['pDif'])) > 0)){
                $this->errors[] = 'A porcentagem do difal do  icms Op do item é obrigatório';
            }
        }
        

        if(in_array('vICMSDif', $apenas)){
            if(! (strlen(trim( $dados['vICMSDif'])) > 0)){
                $this->errors[] = 'O valor do difal do  icms Op do item é obrigatório';
            }
        }

        if(in_array('vBCSTRet', $apenas)){
            if(! (strlen(trim( $dados['vBCSTRet'])) > 0)){
                $this->errors[] = 'O valor da base de calculo da subistituição tributária retida do  icms do item é obrigatório';
            }
        }

        if(in_array('pST', $apenas)){
            if(! (strlen(trim( $dados['pST'])) > 0)){
                $this->errors[] = 'A porcentagem  da subistituição tributária do icms do item é obrigatório';
            }
        }

        if(in_array('vICMSSTRet', $apenas)){
            if(! (strlen(trim( $dados['vICMSSTRet'])) > 0)){
                $this->errors[] = 'O valor do ims de subistituição tributária  retida item é obrigatório';
            }
        }

        if(in_array('vBCFCPSTRet', $apenas)){
            if(! (strlen(trim( $dados['vBCFCPSTRet'])) > 0)){
                $this->errors[] = 'O valor da base de calculo do fundo de combate a pobreza de subistituição tributária  retida item é obrigatório';
            }
        }

        if(in_array('pFCPSTRet', $apenas)){
            if(! (strlen(trim( $dados['pFCPSTRet'])) > 0)){
                $this->errors[] = 'A porcentagem do fundo de combate a pobreza de subistituição tributária  retida item é obrigatória';
            }
        }

        if(in_array('vFCPSTRet', $apenas)){
            if(! (strlen(trim( $dados['vFCPSTRet'])) > 0)){
                $this->errors[] = 'O valor do fundo de combate a pobreza de subistituição tributária  retida item é obrigatório';
            }
        }

        if(in_array('pRedBCEfet', $apenas)){
            if(! (strlen(trim( $dados['pRedBCEfet'])) > 0)){
                $this->errors[] = 'A porcentagem de redução da base de calculo efetuada do item é obrigatório';
            }
        }

        if(in_array('vBCEfet', $apenas)){
            if(! (strlen(trim( $dados['vBCEfet'])) > 0)){
                $this->errors[] = 'O valor da base de calculo efetualda do item é obrigatório';
            }
        }

        if(in_array('pICMSEfet', $apenas)){
            if(! (strlen(trim( $dados['pICMSEfet'])) > 0)){
                $this->errors[] = 'A porcentagem valor da base de calculo efetualda do item é obrigatória';
            }
        }

        if(in_array('vICMSEfet', $apenas)){
            if(! (strlen(trim( $dados['vICMSEfet'])) > 0)){
                $this->errors[] = 'O valor do icms efetualdo do item é obrigatório';
            }
        }

        if(in_array('vICMSSubstituto', $apenas)){
            if(! (strlen(trim( $dados['vICMSSubstituto'])) > 0)){
                $this->errors[] = 'O valor do icms subistituto do item é obrigatório';
            }
        }
        
        return $this->errors;
    }


    public function imcsPartilha(Array $dados, Array $apenas)
    {

        if(! (count($dados) > 0)){
            $this->errors[] = 'Dados inválidos';
        }

        if(in_array('item', $apenas)){
            if(! (strlen(trim( $dados['item'])) > 0)){
                $this->errors[] = 'O item para partilha do icms é obrigatório';
            }
        }

        if(in_array('orig', $apenas)){
            if(! (strlen(trim( $dados['orig'])) > 0)){
                $this->errors[] = 'A origem para partilha do icms é obrigatória';
            }
        }

        if(in_array('CST', $apenas)){
            if(! (strlen(trim( $dados['CST'])) > 0)){
                $this->errors[] = 'O CST para partilha do icms é obrigatório';
            }
        }

        if(in_array('modBC', $apenas)){
            if(! (strlen(trim( $dados['modBC'])) > 0)){
                $this->errors[] = 'A modalidade da base de cálculo para partilha do icms é obrigatório';
            }
        }

        if(in_array('vBC', $apenas)){
            if(! (strlen(trim( $dados['vBC'])) > 0)){
                $this->errors[] = 'O valor da base de cálculo para partilha do icms é obrigatório';
            }
        }

        if(in_array('pRedBC', $apenas)){
            if(! (strlen(trim( $dados['pRedBC'])) > 0)){
                $this->errors[] = 'A porcentagem de redução da base de cálculo para partilha do icms é obrigatório';
            }
        }

        if(in_array('pICMS', $apenas)){
            if(! (strlen(trim( $dados['pICMS'])) > 0)){
                $this->errors[] = 'A porcentagem  do icms para partilha do icms é obrigatória';
            }
        }

        if(in_array('vICMS', $apenas)){
            if(! (strlen(trim( $dados['vICMS'])) > 0)){
                $this->errors[] = 'O valor do icms para partilha do icms é obrigatório';
            }
        }

        if(in_array('modBCST', $apenas)){
            if(! (strlen(trim( $dados['modBCST'])) > 0)){
                $this->errors[] = 'A modalidade da base de cáculo de substituição tributária do icms para partilha do icms é obrigatório';
            }
        }

        if(in_array('pMVAST', $apenas)){
            if(! (strlen(trim( $dados['pMVAST'])) > 0)){
                $this->errors[] = 'A porcentagem da margem de valor agregado de substituição tributária do icms para partilha do icms é obrigatório';
            }
        }

        if(in_array('pRedBCST', $apenas)){
            if(! (strlen(trim( $dados['pRedBCST'])) > 0)){
                $this->errors[] = 'A porcentagem de redução da base de cáldulo de substituição tributária do icms para partilha do icms é obrigatório';
            }
        }
        

        if(in_array('vBCST', $apenas)){
            if(! (strlen(trim( $dados['vBCST'])) > 0)){
                $this->errors[] = 'O valor da base de cáldulo de substituição tributária do icms para partilha do icms é obrigatório';
            }
        }

        if(in_array('pICMSST', $apenas)){
            if(! (strlen(trim( $dados['pICMSST'])) > 0)){
                $this->errors[] = 'A porcentagem do icms de substituição tributária  para partilha do icms é obrigatória';
            }
        }

        if(in_array('vICMSST', $apenas)){
            if(! (strlen(trim( $dados['vICMSST'])) > 0)){
                $this->errors[] = 'O valor do icms de substituição tributária  para partilha do icms é obrigatório';
            }
        }

        if(in_array('pBCOp', $apenas)){
            if(! (strlen(trim( $dados['pBCOp'])) > 0)){
                $this->errors[] = 'A porcentagem da base de calculo da operação para partilha do icms é obrigatório';
            }
        }

        if(in_array('UFST', $apenas)){
            if(! (strlen(trim( $dados['UFST'])) > 0)){
                $this->errors[] = 'UF da subistituição tributária para partilha do icms é obrigatório';
            }
        }
        
        
    }

}
