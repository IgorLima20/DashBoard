<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['marca', 'imagem'];

    public function rules() {
        return [
            'marca' => 'required|unique:marcas,marca,'.$this->id.'',
            'imagem' => 'file'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'marca.unique' => 'O nome da marca já existe'
        ];
    }
}
