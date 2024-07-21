<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\EspecialidadeException;
use Illuminate\Support\Facades\Validator;
use App\Especialidade;
use \App\Helpers\EspecialidadeHelper;

class EspecialidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function json(Request $request)
    {

        try {
            \DB::beginTransaction();

            $consulta = $request->all();

            $objEspecialidadeHelper = new EspecialidadeHelper();
            $registro = $objEspecialidadeHelper->json($consulta);
            if (!$registro) {
                throw new EspecialidadeException('Registro não identifiado');
            }
            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (EspecialidadeException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
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
            $validator = $this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();
            $objEspecialidadeHelper = new EspecialidadeHelper();
            $result = $objEspecialidadeHelper->store($dados);

            \DB::commit();

            return response()->json(['mensagem' => $result, 'class' => 'sucess'], 200);
        } catch (EspecialidadeException $th) {
            \DB::rollback();
            //return response()->json(['mensagem' => $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile()], 500);
            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile(), 'class' => 'warning'], 500);
        }
    }



    public function info(Request $request, $id)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();

            $dados = $request->all();
            $objEspecialidadeHelper = new EspecialidadeHelper();
            $registro = $objEspecialidadeHelper->info($dados, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (EspecialidadeException $th) {
            \DB::rollback();
            //return response()->json(['mensagem' => $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile()], 500);
            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile(), 'class' => 'warning'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $id, $idAssistente)
    {

        try {

            \DB::beginTransaction();

            $dados = $request->all();
            $objEspecialidadeHelper = new EspecialidadeHelper();
            $registro = $objEspecialidadeHelper->edit($dados, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (EspecialidadeException $th) {
            \DB::rollback();
            //return response()->json(['mensagem' => $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile()], 500);
            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile(), 'class' => 'warning'], 500);
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
            $objEspecialidadeHelper = new EspecialidadeHelper();
            $registro = $objEspecialidadeHelper->update($dados, $id);

            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (EspecialidadeException $th) {
            \DB::rollback();
            //return response()->json(['mensagem' => $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile()], 500);
            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile(), 'class' => 'warning'], 500);
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

            $objEspecialidadeHelper = new EspecialidadeHelper();
            $registro = $objEspecialidadeHelper->destroy($id);

            \DB::commit();
            return response()->json(['mensagem' => 'Registro atulizado com sucesso', 'class' => 'success']);
        } catch (EspecialidadeException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new EspecialidadeException($msg);
        }

        return true;
    }
}
