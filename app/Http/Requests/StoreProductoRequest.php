<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => 'required|max:50|unique:productos,codigo',
            'nombre' => 'required|max:80|unique:productos,nombre',
            'descripcion' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'marca_id' => 'required|integer|exists:marcas,id',
            'presentacione_id' => 'required|integer|exists:presentaciones,id',
            'categorias' => 'required'
        ];
    }

    //función para que no muestre en el campo el mensaje marca_id, presentacione_id
    public function attributes(){
        return[
            'marca_id' => 'marca',
            'presentacione_id' => 'presentacion'
        ];
        
    }

    //función para enviar mensajes personalizados en los campos
    public function messages(){
        return[
            'codigo.required' => 'Se necesita ingresar un código'
        ];
        
    }


}
