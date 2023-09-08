<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unite extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function categories(){
    //     return $this->hasMany(Categorie::class);
    // }

    public function scopeByLibelle($query,string $libelle){
        return $query->whereRaw('LOWER(TRIM(libelle))=  ?',[ Str::lower( trim($libelle))]);
    }
}