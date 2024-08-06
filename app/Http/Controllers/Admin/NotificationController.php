<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use App\Profissional;
use App\Filial;
use App\Exceptions\NotificationException;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NotificationHelper;

class NotificationController extends Controller
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

            $objNotificationHelper = new NotificationHelper();

            $registro = $objNotificationHelper->json($consulta);

            \DB::commit();

            //dd( $registro);

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (NotificationException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
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

            \DB::beginTransaction();
            $dados = $request->all();
            $objNotificationHelper = new NotificationHelper();
            $registro = $objNotificationHelper->store($dados);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (NotificationException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 400);
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
    public function emailStore(Request $request)
    {
        try {

            \DB::beginTransaction();
            $dados = $request->all();
            $objNotificationHelper = new NotificationHelper();
            $registro = $objNotificationHelper->emailStore($dados);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (NotificationException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 400);
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
    public function whatsAppStore(Request $request)
    {
        try {

            \DB::beginTransaction();
            $dados = $request->all();
            $objNotificationHelper = new NotificationHelper();
            $registro = $objNotificationHelper->whatsAppStore($dados);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (NotificationException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 400);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
        }
    }

    public function info(Request $request, $id)
    {

        try {

            \DB::beginTransaction();

            $dados = $request->all();
            $objNotificationHelper = new NotificationHelper();
            $registro = $objNotificationHelper->info($dados, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (NotificationException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {

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

            \DB::beginTransaction();
            $dados = $request->all();
            $objNotificationHelper = new NotificationHelper();
            $registro = $objNotificationHelper->store($dados, $id);
            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (NotificationException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage(), 'class' => 'warning'], 500);
            //throw $th;
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
            $objNotificationHelper = new NotificationHelper();
            $objNotificationHelper->destroy($id);
            \DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (NotificationException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
            //throw $th;
        }
    }
}
