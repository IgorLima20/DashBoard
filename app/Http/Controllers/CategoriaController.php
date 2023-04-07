<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public $categoria;

    public function __construct(Categoria $categoria) {
        $this->categoria = $categoria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categoria.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->categoria->rules(), $this->categoria->feedback());

        $categoria = new Categoria;
        $categoria->categoria = $request->categoria;

        $imagem = $request->file('imagem');
        if ($imagem) {
            $imagem_urn = $imagem->store('imagens/categorias', 'public');
            $categoria->imagem = $imagem_urn;
        }
        
        $categoria->save();
        return response()->json(['categoria' => $categoria, 'msg' => 'Categoria Criada com Sucesso!!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categorium)
    {
        return response()->json(['categoria' => $categorium], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categorium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categorium)
    {
        if($categorium === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($categorium->rules() as $input => $regra) {
                
                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas, $categorium->feedback());

        } else {
            $request->validate($categorium->rules(), $categorium->feedback());
        }

        //preenchendo o objeto marca com todos os dados do request
        $categorium->fill($request->all());

        if ($request->file('imagem')) {
            Storage::disk('public')->delete($categorium->imagem);
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/categorias', 'public');
            $categorium->imagem = $imagem_urn;
        }

        $categorium->save();
        return response()->json(['marca' => $categorium, 'msg' => 'Categoria Editada com Sucesso!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categorium)
    {
        if($categorium === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        //remove o arquivo antigo
        Storage::disk('public')->delete($categorium->imagem);        

        $categorium->delete();
        return response()->json(['msg' => 'Categoria Removida com Sucesso!!'], 200);
    }

    public function carregarTabela(Request $request)
    {
        if ($request->search) {
            return response()->json([
                'categoria' =>  $this->categoria::where('categoria', 'LIKE', "%{$request->search}%")->paginate(10),
                'search' => $request->search
            ], 200);
        } else {
            return response()->json([
                'categoria' => $this->categoria::paginate(10)
            ], 200);
        }
    }
}
