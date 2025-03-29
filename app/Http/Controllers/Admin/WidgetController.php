<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\ContaReceber as CobrancaReceber;
use \App\Pessoa;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\Utilitarios;
use \App\OperadorFinanceiro;
use \App\OrdemServico;
use \App\Filial;
use \App\VendaItem;
use \App\Venda;
use \App\ServicoItem;
use \App\Servico;
use \App\User;
use \App\Rca;
use \App\Exceptions\CobrancaReceberException;
use \App\ExceptionApplication;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ContaReceberHelper;
use App\Helpers\AtendimentoHelper;

class WidgetController extends Controller
{
    protected ContaReceberHelper $objCobReceberHelper;

    public function __construct(ContaReceberHelper $objCobReceberHelper)
    {
        $this->objCobReceberHelper = $objCobReceberHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faturamentoLiquidezAgrupadoMesAnoWidgetJson(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $registro = $this->objCobReceberHelper->faturamentoLiquidezMesAnoWidgetJson($data);

            \DB::commit();


            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faturamentoLiquidezAgrupadoFilialWidgetJson(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $registro = $this->objCobReceberHelper->faturamentoLiquidezFilialWidgetJson($data);

            \DB::commit();


            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faturamentoLiquidezAgrupadoProfissionalWidgetJson(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $registro = $this->objCobReceberHelper->faturamentoLiquidezProfissionallWidgetJson($data);

            \DB::commit();


            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function atendimentosPorTipoWidgetJson(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $objHelper = new AtendimentoHelper();

            $registro = $objHelper->qtdAtendimentosPorTipo($data);

            \DB::commit();


            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (CobrancaReceberException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            //return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
            return response()->json(['errors' => ['error' => $msg]], 404);
        } catch (\Exception $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $msg]], 500);
        }
    }
}
