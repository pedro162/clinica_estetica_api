<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\ServicoItemException;
use \App\FormularioGrupo;
use \App\Servico;
use \App\OrdemServico;
use \App\ServicoItem;
use \App\Pessoa;
use \App\Filial;
use \App\Profissional;
use \App\Rca;
use \App\Utilitarios;
use Illuminate\Support\Facades\Auth;
use \App\Impressao\Relatorios\Agendamentos;
use \App\Impressao\FichaAnamnese;
use \App\Impressao\MDFe\Damdfe;
use NFePHP\DA\NFe\Danfe;

class TestesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        #https://github.com/nfephp-org/sped-da/blob/master/src/Common/DaCommon.php
        $emitente = [];
        $emitente["nome"] = "EMPRESA FULANO DE TAL";
        $emitente["fone"] = "98982547048";
        $emitente["logradouro"] = "RUA X";
        $emitente["numero"] = "108";
        $emitente["complemento"] = "Bloco y ";
        $emitente["bairro"] = "Forquilha";
        $emitente["cep"] = "65054005";
        $emitente["cidade"] = "Sao Luis";
        $emitente["uf"] = "Ma";
        $emitente["inscricao"] = "1212122";
        $emitente["CNPJ"] = "32584751000180";
        $emitente["CPF"] = "";
        $itensArr = [];


        for ($i = 0; $i < 100; $i++) {
            $itensFields['cod'] = $i;
            $itensFields['registro'] = "*NÃO HOUVE REGISTRO*";
            $itensFields['data'] = "13/04/2023";
            $itensFields['horario'] = "20:40";
            $itensFields['pago'] = "Sim";

            $itensArr[] = $itensFields;
        }





        $dadosArr['emitente'] = $emitente;
        $dadosArr['itens'] = $itensArr;
        $dadosArr['dtInicial'] = '01/01/2000';
        $dadosArr['dtFinal']  = '13/04/2023';
        $objAgenda = new FichaAnamnese($dadosArr); //Agendamentos
        $objAgenda->montaMapa();
        $xml = $xmlFile = $objAgenda->render();
        $htmlSimples = htmlspecialchars($xml);
        /*  echo '<pre>';
        echo ($xml);
        echo '</pre>';
        die();
        $danfe = new Danfe($xml);
        $danfe->debugMode(false);
        $danfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
        $danfe->obsContShow(false);
        $danfe->epec('891180004131899', '14/08/2018 11:24:45'); //marca como autorizada por EPEC */
        // Caso queira mudar a configuracao padrao de impressao
        /*  $this->printParameters( $orientacao = '', $papel = 'A4', $margSup = 2, $margEsq = 2 ); */
        // Caso queira sempre ocultar a unidade tributável
        /*  $this->setOcultarUnidadeTributavel(true); */
        //Informe o numero DPEC
        /*  $danfe->depecNumber('123456789'); */
        //Configura a posicao da logo
        /*  $danfe->logoParameters($logo, 'C', false);  */
        //Gera o PDF
        //$pdf = $danfe->render(); //$logo

        header('Content-Type: application/pdf');
        echo $xml;
        return true;
        /* $damdfe = new Damdfe($xmlFile, 'P', 'A4', '', 'F', $pathPdf = '');
        $pdfContent = $damdfe->render(); */

        /* $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
        $mpdf->WriteHTML($xml);
        $mpdf->Output(); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idAssistente)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            //$this->validaAddItemRequest($request);

            \DB::beginTransaction();

            \DB::commit();
            //return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);

        } catch (OrdemServicoException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $idAssistente)
    {
    }


    public function info(Request $request, $id)
    {
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $idAssistente)
    {
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
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recalcularOrdemServico($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function head(Request $request)
    {
    }


    /**
     * Return a listing of the resource in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
    }



    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'servico_id' => 'required|min:1',
        ], [
            'servico_id.required' => 'O campo "Serviço" é obrigatório.',
            'servico_id.min' => 'O "Serviço" deve conter pelo menos :min caracteres.',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new ServicoItemException($msg);
        }

        return true;
    }
}
