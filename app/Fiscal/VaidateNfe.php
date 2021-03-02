<?php

namespace App\Fiscal;

class VaidateNfe
{

    protected $errors;


    public function __construct()
    {
        $this->errors = [];
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

}
