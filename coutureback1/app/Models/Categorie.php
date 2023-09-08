<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;
    use SoftDeletes;

     protected $guarded = [];

    public function unites(){
        return $this->belongsToMany(Unite::class)
                    ->withPivot('etat','conversion')
                    ->orderByPivot('etat',"desc");
        
    }

    public static function booted(){
        static::created(function(Categorie $categorie){
            DB::transaction(function() use ($categorie){
                $unite = Unite::byLibelle(request()->unite)->first();
                if (!$unite) {
                   $unite=Unite::create([
                    "libelle"=>request()->unite
                    ]);
                }
                $categorie->unites()->attach(
                    [
                        $unite->id=>[
                            "etat"=>1,
                            "conversion"=>1
                        ]
                    ]
                );
            });
        });
    }


}