<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ParametroException;
use App\Helpers\ParametroHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
    public function json(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();
            $objParameter = new ParametroHelper();
            $registro = $objParameter->json($data);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 201);
        } catch (ParametroException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);
        }
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

            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();
            $objParameter = new ParametroHelper();
            $registro = $objParameter->save($dados)->build();
            \DB::commit();

            if ($registro) {
                return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
            } else {
                throw new ParametroException('Erro ao cadastrar');
            }
        } catch (ParametroException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 400);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
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
        try {
            $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $objParameter = new ParametroHelper();
            $registro = $objParameter->update($dados)->build();

            \DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (ParametroException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            \DB::beginTransaction();

            $dadosRequest = [];

            $dadosRequest['user_update_id']     = \Auth::User()->id; //trocar pelo id do usuario logado
            $dadosRequest['active']             = 'no';
            $bairro = Caixa::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if ($bairro->vrSaldo == 0) {
                throw new ParametroException('Este caixa ainda possui saldo.');
            }
            $bairro->update($dadosRequest);
            $bairro->delete();

            \DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (ParametroException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'type' => 'required',
            'vrMin' => 'required|min:0',
            'vrMax' => 'required|min:0',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'type.required' => 'O campo "TIPO" é obrigatório.',
            'vrMin.min' => 'O "VALOR MÍNIMO" deve conter pelo meno :min caracteres.',
            'vrMax.min' => 'O "VALOR MÁXIMO" deve conter pelo meno :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new ParametroException($msg);
        }

        return true;
    }
}
