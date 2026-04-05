<?php

namespace App\Http\Controllers\Admin;

use App\Contrato;
use App\Filial;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContratoRequest;
use App\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        try {

            if ((! isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['params' => 'Parametro inválido']], 400);
            }


            $registro = DB::transaction(function () use (&$id) {
                $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();
                $filial = Filial::where('active', '=', 'yes')->get();
                return ['pessoa' => $pessoa, 'filial' => $filial];
            });

            $filial     = $registro['filial'];
            $registro   = $registro['pessoa'];

            if ($registro == null) {
                return response()->json(['errors' => ['erro' => 'Erro ao carregar o registro'], 'class' => 'warning'], 400);
            }

            return view('admin.contrato.create', compact('registro', 'filial'));
        } catch (\Exception $e) {
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor']], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContratoRequest $request, $id)
    {
        try {

            if ((! isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['params' => 'Parametro inválido']], 400);
            }

            $errors = $request->validated();
            $dados  = $request->all();
            $registro = DB::transaction(function () use (&$id, &$dados) {
                $pessoa = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();

                if (! $pessoa) {
                    return false;
                }

                $filial = Filial::where('active', '=', 'yes')->where('id', '=', $dados['filial_id'])->first();
                if (! $filial) {
                    return false;
                }

                $toCommit                       = [];
                $toCommit['filial_id']          = $dados['filial_id'];
                $toCommit['vrAdesao']           = $dados['vrAdesao'];
                $toCommit['vrContrato']         = $dados['vrContrato'];
                $toCommit['dtVencimento']       = $dados['dtVencimento'];
                $toCommit['tpVencimento']       = $dados['tpVencimento'];
                $toCommit['isLiberaCatraca']    = $dados['isLiberaCatraca'] == true ? 'yes' : 'no';
                $toCommit['user_id']            = Auth::User()->id;
                $toCommit['active']             = 'yes';

                $result = Contrato::create($toCommit);
                return $result;
            });

            if ($registro == false) {
                return response()->json(['errors' => ['erro' => 'Erro ao carregar o registro'], 'class' => 'warning'], 400);
            }


            return response()->json(['data' => $registro], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor ' . $e->getMessage()]], 500);
        }
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
