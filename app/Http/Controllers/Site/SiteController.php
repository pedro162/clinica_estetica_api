<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Produto;

class SiteController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/*$registros = Produto::where('active', '=', 'yes')->where('spotlight', '=', 'yes')
        ->get();*/

        $registros = \DB::table('produtos')->join('categoria_produto', function($join){
            
            $join->on('produtos.id', '=', 'categoria_produto.produto_id');

        })->join('categorias', function($join){

            $join->on('categorias.id', '=', 'categoria_produto.categoria_id');

        })->join('marcas', function($join){

            $join->on('marcas.id', '=' ,'produtos.marca_id');

        })->select('produtos.*', 'categorias.name as categoria', 'marcas.name as marca')
            ->where('categoria_produto.active', '=', 'yes')
            ->where('categoria_produto.tipo', '=', 'principal')->get();

        //dd($registros);

        return view('site.index', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
