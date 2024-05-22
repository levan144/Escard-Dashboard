<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::all();
        
        return view('cards.index', compact('cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $card = new Card;
        $card->color = $request->color;
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/cards'), $filename);
            $card->featured_image = 'https://dashboard.escard.ge'.'/cards/' . $filename;
        }
        
        $card->save();
        
         return redirect()->route('cards')->with('success','Card Created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cards = Card::all();
        $card = Card::findOrFail($id);
        
        
        return view('cards.edit', compact('card','cards'));
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
        $card = Card::findOrFail($id);
        $card->color = $request->color;
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/cards'), $filename);
            $card->featured_image = 'https://dashboard.escard.ge'.'/cards/' . $filename;
        }
        $card->save();
        return redirect()->route('cards')->with('success','Card Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}