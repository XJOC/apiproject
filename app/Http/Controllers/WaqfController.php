<?php

namespace App\Http\Controllers;
use App\Models\Waqf;
use Illuminate\Http\Request;
class WaqfController extends Controller
{

    public function createWaqf(Request $request){
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401,[],JSON_PRETTY_PRINT);
        }
        $request->validate([
            'name' => ['required','string','max:255'],
            'details' => ['nullable','string'],
        ]);
        $waqf = auth()->user()->awqaf()->create($request->all());
        return response()->json($waqf, 201, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT);
        
    }
    public function awqafByUser(){
        if (!auth()->check()) {
            return response()->json(['error' =>'Unauthorized'], 401,[],JSON_PRETTY_PRINT);
        }
        
        $awqaf = auth()->user()->awqaf;
        return response()->json(['status' =>'success','data' => $awqaf], 200,[],JSON_PRETTY_PRINT);
    }
    public function updateWaqf(Request $request ,$id){   
        if (!auth()->check()) {
            return response()->json(['error'=>'Unauthorized'], 401,[],JSON_PRETTY_PRINT);
        }
        $waqf = Waqf::findOrFail($id);
        if (!$waqf) {
            return response()->json(['error'=>'Waqf not found'], 404,[],JSON_PRETTY_PRINT);
        }
        if ($waqf->user_id !== auth()->id()) {
            return response()->json(['error'=>'Not authorized'], 403,[],JSON_PRETTY_PRINT);
        }
        $validatedData = $request->validate([
            'name' => ['sometimes','required','string','max:255'],
            'details' => ['nullable','string'],
        ]);
        $waqf->update($validatedData);
        return response()->json($waqf, 200,[],JSON_PRETTY_PRINT);
    }
    public function deleteWaqf($id){
        if (!auth()->check()) {
            return response()->json(['error'=>'Unauthorized'], 401,[],JSON_PRETTY_PRINT);
        }
        $waqf = Waqf::find($id);
        if (!$waqf) {
            return response()->json(['error'=>'Waqf not found'], 404,[],JSON_PRETTY_PRINT);
        }
        if ($waqf->user_id !== auth()->id()) {
            return response()->json(['error'=>'Not authorized'], 403,[],JSON_PRETTY_PRINT);
        }
        $waqf->delete();
        return response()->json(['message'=>'Waqf successfully deleted'],200,[],JSON_PRETTY_PRINT); 
    }
}
