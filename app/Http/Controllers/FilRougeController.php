<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FilRouge;

class FilRougeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filRouges = FilRouge::all();
        return view("fil_rouge.index", ["fil_rouges"=>$filRouges]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("fil_rouge.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filRouge = new FilRouge();
        $filRouge->nom = $request->input("nom");
        $filRouge->numero = $request->input("numero");
        $filRouge->save();
        return redirect()->route('fil_rouge.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filRouge = FilRouge::find($id);
        
        return view("fil_rouge.edit", ["filRouge"=>$filRouge]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$filRouge = FilRouge::find($id);
    	$filRouge->nom = $request->input("nom");
    	$filRouge->numero = $request->input("numero");
    	$filRouge->save();
    	
    	return redirect()->route('fil_rouge.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filRouge = FilRouge::find($id);
        $filRouge->delete();
        return redirect()->route('fil_rouge.index');
    }
    
    public function getFilRouge(){
    	$filRouges = FilRouge::orderBy('numero', 'asc')->get();
    	return response()->json(["fil_rouges"=>$filRouges]);
    }
}
