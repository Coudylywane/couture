<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategorieRequestStore;
use App\Http\Resources\CategorieCollection;
use App\Http\Resources\CategorieResource;
use Symfony\Component\HttpFoundation\Response;

class CategorieController extends Controller
{
    // index ===> all categories + pagination
    public function all(Request $request){
        $query = $request->input('limit')??4;
        return new CategorieCollection(Categorie::paginate($query));
    }
    
    // add   ===> add categories + unite
    public function store(CategorieRequestStore $request){
       // dd($request->validated());
       $validated = $request->validated();
       return DB::transaction(function () use( $validated){
         $categorie = Categorie::create([
            "libelle"=>$validated['libelle']
           ]);
           return response()->json([
            "data"=> CategorieResource::make($categorie),
            'succes'=>true,
            'message'=>"Une categorie ajoutee avec success",
            'statut'=>Response::HTTP_CREATED,
        ]);
       });
       
    }
        
    // delete ===> supprimer categories
    public function delete(Request $request,int $id){
        Categorie::WhereIn("id",$request->categories)->delete();
    }
    
    // update ===> add categories + unite
    public function update(Request $request , Categorie $categorie){
       // dd($categorie);
    DB::transaction(function() use($categorie,$request){
       $categorie->update([
            "libelle"=>$request->libelle 
        ]);

        $unite = Unite::byLibelle(request()->unite)->first();
                if (!$unite) {
                   $unite=Unite::create([
                    "libelle"=>request()->unite
                    ]);
                }
        $categorie->unites()->sync([$unite->id=>["conversion"=>1,"etat"=>1]]);
    });
    return response()->json([
            "data"=> CategorieResource::make($categorie),
            'succes'=>true,
            'message'=>"Une categorie ajoutee avec success",
            'statut'=>Response::HTTP_CREATED,
        ]);
}

    public function byLibelle(CategorieRequestStore $request){
      return response()->json([
           "data"=>[],
           'succes'=>true
       ]);
    }
    
}