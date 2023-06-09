<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{

    public $marca;

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('marca.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca = new Marca;
        $marca->marca = $request->marca;

        $imagem = $request->file('imagem');
        if ($imagem) {
            $imagem_urn = $imagem->store('imagens/marcas', 'public');
            $marca->imagem = $imagem_urn;
        }
        
        $marca->save();
        return response()->json(['marca' => $marca, 'msg' => 'Marca Criada com Sucesso!!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        return response()->json(['marca' => $marca], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        if($marca === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($marca->rules() as $input => $regra) {
                
                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas, $marca->feedback());

        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        //preenchendo o objeto marca com todos os dados do request
        $marca->fill($request->all());

        if ($request->file('imagem')) {
            Storage::disk('public')->delete($marca->imagem);
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/categorias', 'public');
            $marca->imagem = $imagem_urn;
        }

        $marca->save();
        return response()->json(['marca' => $marca, 'msg' => 'Marca Editada com Sucesso!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        if($marca === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        //remove o arquivo antigo
        Storage::disk('public')->delete($marca->imagem);        

        $marca->delete();
        return response()->json(['msg' => 'Marca Removida com Sucesso!!'], 200);
    }

    public function carregarTabela(Request $request)
    {
        if ($request->search) {
            return response()->json([
                'marca' =>  $this->marca::where('marca', 'LIKE', "%{$request->search}%")->paginate(10),
                'search' => $request->search
            ], 200);
        } else {
            return response()->json([
                'marca' => $this->marca::paginate(10)
            ], 200);
        }
    }
}
