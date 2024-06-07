<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresentacionRequest;
use App\Http\Requests\UpdatePresentacionRequest;
use Illuminate\Http\Request;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Exception;
use Illuminate\Support\Facades\DB;

class presentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentacion = Presentacione::with('caracteristica')->latest()->get();
        //dd($marcas);
        return view('presentacion.index',['presentacione' => $presentacion]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        //dd($e);

        return redirect()->route('presentaciones.index')->with('success', 'Presentación registrada con exito');
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
    public function edit(Presentacione $presentacion)
    {
        return view('presentacion.edit',['presentacione' => $presentacion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacionRequest $request, Presentacione $presentacion)
    {
        Caracteristica::where('id',$presentacion->caracteristica->id)
            ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'Presentación actualizada correctamente');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $presentacion = Presentacione::find($id);
        if($presentacion->caracteristica->estado == 1){
            Caracteristica::where('id',$presentacion->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Presentación inactivada';
        } else {  
            Caracteristica::where('id',$presentacion->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Presentación activada';  
        }   
        return redirect()->route('presentaciones.index')->with('success',$message);
    }
}
