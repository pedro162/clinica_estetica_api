<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\ProdutoRequest;
use \App\Produto;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\ProdutoException;

class ProdutoController extends Controller
{


    protected function requestProduto(Request $request)
    {
        $validador = Validator::make($request->all(),[

            'name'=>'required',
            'description'=>'required',
            'marca_id'=>'required',
            'categoria_id'=>'required'

        ]);

        return $validador;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//$registro = \App\Produto::where('active', '=', 'yes')->get();
        $registro = \DB::table('produtos')->join('categoria_produto', function($join){
            
            $join->on('produtos.id', '=', 'categoria_produto.produto_id');

        })->join('categorias', function($join){

            $join->on('categorias.id', '=', 'categoria_produto.categoria_id');

        })->join('marcas', function($join){

            $join->on('marcas.id', '=' ,'produtos.marca_id');

        })->select('produtos.*', 'categorias.name as categoria', 'marcas.name as marca')
            ->where('categoria_produto.active', '=', 'yes')
            ->where('produtos.active', '=', 'yes')
            ->where('categoria_produto.tipo', '=', 'principal')->get();


        return view('admin.produto.index', compact('registro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::where('active', '=', 'yes')->get();
        $categorias = Categoria::where('active', '=', 'yes')->get();
        return view('admin.produto.create', compact('marcas', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    {

        try{

            set_time_limit(9000000);

            $validator = $request->validated();

            $sentinela = null;
            \DB::transaction(function() use (&$request, &$sentinela){

                $dados = $request->all();

                $dadosRequest = [];

                $dadosRequest['marca_id']           = $dados['marca_id'];
                $dadosRequest['categoria_id']       = $dados['categoria_id'];
                $dadosRequest['sub_categoria_id']   = $dados['sub_categoria_id'];
                $dadosRequest['image']              = $dados['imagem'];
                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['description']        = $dados['description'];
                $dadosRequest['price']              = $dados['price'];
                //$dadosRequest['spotigth']           = $dados['spotigth'];
                $dadosRequest['stock']              = $dados['stock'];
                $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';


                
                //verifica a existencia de imagem
                $file = $request->file('imagem');
                if($file){

                    //cofigura o diretorio pra salvar a imagem do produto
                    $rand = rand(111111111, 999999999);
                    $diretorio = 'img/produtos';
                    $extensao = $file->guessClientExtension();
                    $nameArquivo = '_img_'.\Str::slug($dadosRequest['name']).'_'.$rand.'.'.$extensao;

                    if($file->move($diretorio, $nameArquivo)){

                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = $diretorio.'/'.$nameArquivo;
                    }else{

                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = '_img_standard.jpeg';
                    }


                }else{
                    
                    //adiciona o nome da imagem para salvar no banco
                    $dadosRequest['image'] = '_img_standard.jpeg';
                }

                //salva o produto
                $sentinela      = $produto = Produto::create($dadosRequest);

                $marca          = Marca::find($dados['marca_id']);
                $categoria      = Categoria::find($dados['categoria_id']);
                $subCategoria   = Categoria::find($dados['sub_categoria_id']);

                $resultCategoria    = $produto->adicionarCategoria($categoria,['active'=>'yes', 'tipo'=>'principal']);
                $resultSubCategoria = $produto->adicionarCategoria($subCategoria, ['active'=>'yes', 'tipo'=>'secundaria']);

                

            });

            if($sentinela){

                //\Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                //return redirect()->route('produto.index');

                return response()->json(['mensagem'=>$sentinela, 'class'=>'success'], 200);

            }else{

               // \Session::flash('mensagem', ['msg'=>'Erro ao salvar o registro', 'class'=>'alert alert-warning']);

                //return redirect()->back();

                return response()->json(['mensagem'=>'Erro ao cadastrar produto', 'class'=>'warning'], 400);
            }

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

           return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

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
        try{

            if( (!isset($id)) || ($id <= 0)){
                return response()->json(['errors'=>['error'=>'Parâmetro inválido']], 400);
            }

            \DB::beginTransaction();
            $registro = Produto::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if(! $registro){
                throw new ProdutoException('Registro não encontrado');
            }
            \DB::commit();

            return view('admin.produto.container', compact('registro'));
        
        }catch(ProdutoException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
       
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    public function info($id)
    {
        
        try{

            if($id <= 0){

                 \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                return redirect()->route('produto.index');

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $registro = Produto::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
        
            } );

            if($registro == null){

                \Session::flash('mensagem', ['msg'=>'Produto não encontrado', 'class'=>'alert alert-danger']);
                return redirect()->back();
            }


            //return view('admin.produto.info', compact('registro'));
            return view('admin.produto.info', compact('registro'));

        }catch(\Exception $e){

            \Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            return redirect()->back();

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
           // sleep(30);
            if($id <= 0){

                 \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                return redirect()->route('produto.index');

            }

            $registro = null;
            $marcas = null;
            $categorias = null;

            \DB::transaction(function() use (&$id, &$registro, &$marcas, &$categorias){

                $registro = \DB::table('produtos')->join('categoria_produto as c', function($join){
                    
                    $join->on('produtos.id', '=', 'c.produto_id');
                })
                ->join('categoria_produto as cp', function($join){
                    
                    $join->on('produtos.id', '=', 'cp.produto_id');

                })->join('marcas', function($join){

                    $join->on('marcas.id', '=' ,'produtos.marca_id');

                })->select('produtos.*', 'c.categoria_id as categoria_id_pri','cp.categoria_id as categoria_id_sec','c.tipo as tipo_pri', 'cp.tipo as tipo_sec', 'marcas.name as marca',
                    'c.tipo', 'cp.tipo')
                    ->where('c.tipo', '=', 'principal')
                    ->where('c.active', '=', 'yes')
                    ->where('cp.tipo', '=', 'secundaria')
                    ->where('cp.active', '=', 'yes')
                    ->where('produtos.id', '=', $id)->first();

                
                $marcas = Marca::where('active', '=', 'yes')->get();
                $categorias = Categoria::where('active', '=', 'yes')->get();

            } );

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>'Produto não encontrado', 'class'=>'alert alert-danger']);
                //return redirect()->back();

                return response()->json(['mensagem'=>'Erro, registro não encontrado.', 'class'=>'warning'], 400);
            }


            return view('admin.produto.edit', compact('registro', 'marcas', 'categorias'));

         }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

             return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, $id)
    {
        try{

            $validator = $request->validated();

            $dados = $request->all();
            $registro = null;

            \DB::transaction(function() use (&$dados, &$id, &$registro, &$request){

                $dadosRequest = [];

                $dadosRequest['marca_id']           = $dados['marca_id'];
                $dadosRequest['categoria_id']       = $dados['categoria_id'];
                $dadosRequest['sub_categoria_id']   = $dados['sub_categoria_id'];
                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['description']        = $dados['description'];
                $dadosRequest['price']              = $dados['price'];
                //$dadosRequest['spotigth']           = $dados['spotigth'];
                $dadosRequest['stock']              = $dados['stock'];
                $dadosRequest['user_id']            = 1;//trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';

                //tenta capturar a imagem do produto
                $file = $request->file('imagem');
                
                if($file){

                    //cofigura o diretorio pra salvar a imagem do produto
                    $rand = rand(111111111, 999999999);
                    $diretorio = 'img/produtos';
                    $extensao = $file->guessClientExtension();
                    $nameArquivo = '_img_'.\Str::slug($dadosRequest['name']).'_'.$rand.'.'.$extensao;

                    if($file->move($diretorio, $nameArquivo)){

                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = $diretorio.'/'.$nameArquivo;
                    }else{

                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = '_img_standard.jpeg';
                    }


                }else{
                    
                    //adiciona o nome da imagem para salvar no banco
                    $dadosRequest['image'] = '_img_standard.jpeg';
                }

                $produto = Produto::find($id);
                $categorias = $produto->categoria;

                for($i = 0; !($i == count($categorias)); $i++){

                    $produto->removeverCategoria($categorias[$i]);
                }
                $registro = $produto->update($dadosRequest);

                $categoria      = Categoria::find($dadosRequest['categoria_id']);
                $subCategoria   = Categoria::find($dadosRequest['sub_categoria_id']);

                $resultCategoria    = $produto->adicionarCategoria($categoria,['active'=>'yes', 'tipo'=>'principal']);
                $resultSubCategoria = $produto->adicionarCategoria($subCategoria, ['active'=>'yes', 'tipo'=>'secundaria']);

            });

            if($registro != null){

                //\Session::flash('mensagem', ['msg'=>'Registro atualizado com sucesso', 'class'=>'alert alert-success']);

                //return redirect()->route('produto.index');

                return response()->json(['mensagem'=>$registro, 'class'=>'success'], 200);
            }

           // \Session::flash('mensagem', ['msg'=>'Erroa ao atualizar registro', 'class'=>'alert alert-warning']);

               // return redirect()->route('produto.index');

            //return redirect()->back();

            return response()->json(['mensagem'=>'Erro ao atualizar registro', 'class'=>'warning'], 400);

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

             return response()->json(['mensagem'=>'Algo errado aconteceu no servidor : '.$e->getMessage(), 'class'=>'warning'], 500);

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
        try{

            if($id <= 0){

                 //\Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                //return redirect()->route('produto.index');
                 return response()->json([['mensagem'=>'Parâmetro inválido', 'class'=>'warning'], 400]);

            }

            $registro = null;

            \DB::transaction(function() use (&$id, &$registro){

                $produto = Produto::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
                if(! $produto){
                    $registro = null;
                }else{

                    $registro = $produto->update(['active'=>'no']);

                }


            } );

            if($registro == null){

                //\Session::flash('mensagem', ['msg'=>'Produto não encontrado', 'class'=>'alert alert-danger']);
                //return redirect()->back();
                 return response()->json(['mensagem'=>'Erro ao exclir registro', 'class'=>'warning'], 400);
            }


            return response()->json(['mensagem'=>'Registro deletado com sucesso', 'class'=>'success'], 200);

        }catch(\Exception $e){

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

             return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);

        }
    }

    public function head()
    {

        return view('admin.produto.head');
    }

    public function adicionarIngrediente($id)
    {
        try {

            $produto    = null;
            $registros  = null;
            \DB::transaction(function() use (&$id, &$produto, &$registros){

                $produto    = Produto::where('id', '=', $id)->first();
                $registros  = Produto::where('id', '!=', $id)->get();

            });

            if(($produto == null) || ($registros == null)){

                return response()->json(['mensagem'=>'Registro não encontrado', 'class'=>'warning'], 400);

            }

            return view('admin.produto.ingrediente_adicionar', compact('produto', 'registros'));

            
        } catch (\Exception $e) {
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
        }
        
        
    }

    public function ingredienteSalvar(ProdutoRequest $request,$id)
    {
        try {

            $produto    = null;
            $registros  = null;
            \DB::transaction(function() use (&$id, &$produto, &$registros){

                $produto    = Produto::where('id', '=', $id)->first();

            });

            if($produto == null){

                return response()->json(['mensagem'=>'Registro não encontrado', 'class'=>'warning'], 400);

            }

            
        } catch (\Exception $e) {
            return response()->json(['mensagem'=>'Algo errado aconteceu no servidor', 'class'=>'warning'], 500);
        }
        
        
    }

    /**
     * Return a listing of the resource in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        try{

            $params = $request->all();

            
            \DB::beginTransaction();

            //$registro = \App\Produto::where('active', '=', 'yes')->get();
            $registro = \DB::table('produtos')->join('categoria_produto', function($join){
                
                $join->on('produtos.id', '=', 'categoria_produto.produto_id');

            })->join('categorias', function($join){

                $join->on('categorias.id', '=', 'categoria_produto.categoria_id');

            })->join('marcas', function($join){

                $join->on('marcas.id', '=' ,'produtos.marca_id');

            })->select('produtos.*', 'categorias.name as categoria', 'marcas.name as marca')
                ->where('categoria_produto.active', '=', 'yes')
                ->where('produtos.active', '=', 'yes')
                ->where('categoria_produto.tipo', '=', 'principal')
                ->where('produtos.produto_final', '=', 'yes')
                ->where('produtos.revenda', '=', 'yes');
           
            if(isset($params['nmProduto']) && (strlen(trim($params['nmProduto'])) > 0)  ){
                $registro->where('produtos.name', 'like', '%'.trim($params['nmProduto']).'%');
            }

            $data = $registro->get();

            \DB::commit();

            return response()->json(['data'=>$data, 'class'=>'success'], 201);

        }catch(ProdutoException $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);
    
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }
}
