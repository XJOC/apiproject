<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Waqf;
use Illuminate\Http\Request;

class WaqfController extends Controller
{
    public function createWaqf(Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            'details' => ['nullable','string'],
        ]);
        $waqf = auth()->user()->awqaf()->create($request->all());
        return response()->json($waqf, 201,[],JSON_PRETTY_PRINT);
        
    }
    public function awqafByUser(){
        $awqaf = auth()->user()->awqaf;
        return response()->json(['status' => 'success','data' => $awqaf], 200,[],JSON_PRETTY_PRINT);
    }
    public function updateWaqf(Request $request ,$id){   
        $waqf = Waqf::findOrFail($id);
        if ($waqf->user_id !== auth()->id()) {
            return response()->json(['error' => 'Not authorized'], 403,[],JSON_PRETTY_PRINT);
        }
        $validatedData = $request->validate([
            'name' => ['sometimes','required','string','max:255'],
            'details' => ['nullable','string'],
        ]);
        $waqf->update($validatedData);
        return response()->json($waqf, 200,[],JSON_PRETTY_PRINT);
    }
    public function deleteWaqf($id){
        $waqf = Waqf::findOrFail($id);
        if ($waqf->user_id !== auth()->id()) {
            return response()->json(['error' => 'Not authorized'], 403,[],JSON_PRETTY_PRINT);
        }
        $waqf->delete();
        return response()->json(null,204,[],JSON_PRETTY_PRINT); 
    }
}
