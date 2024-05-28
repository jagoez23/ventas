<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductoRequest;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Presentacione;
use App\Models\Producto;
use App\Models\Categoria;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with(['categorias.caracteristica','marca.caracteristica','presentacione.caracteristica'])->latest()->get();
        return view('producto.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = Marca::join('caracteristicas as c','marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)->get();

        $presentaciones = Presentacione::join('caracteristicas as c','presentaciones.caracteristica_id','=','c.id')
        ->select('presentaciones.id as id','c.nombre as nombre')
        ->where('c.estado',1)->get();

        $categorias = Categoria::join('caracteristicas as c','categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)->get();

        return view('producto.create',compact('marcas','presentaciones', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $producto = new Producto();
            if($request->hasFile('img_path')){
                $name = $producto->handleUploadImage($request->file('img_path'));
            }else{
                $name = null;
            }

            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacione_id' => $request->presentacione_id
            ]);
            $producto->save();
            //tabla categoría y producto
            $categorias = $request->get('categorias');
            $producto->categorias()->attach($categorias);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            //dd($e);
        }
        return redirect()->route('productos.index')->with('success','Producto registrado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
