<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\menu;
use App\tenan;

class kasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $menu           = menu::all();
        $tenan          = tenan::all();
        // dd($menu,$tenan);
        return view('kasir',['menu'=>$menu,'tenan'=>$tenan]);
    }

    public function search(Request $request)
    {
        $tenan = $request->get('tenan');
        $hasil = menu::where('id_tenan',$tenan)->get();
        echo(json_encode($hasil));
    }
    public function search2(Request $request)
    {
        $menu  = $request->get('menu');
        $hasil = menu::find($menu);
        echo(json_encode($hasil));
    }
    public function search3()
    {
        $hasil = tenan::all();
        echo(json_encode($hasil));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
