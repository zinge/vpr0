<?php

namespace App\Http\Controllers;

use App\Holder;
use Illuminate\Http\Request;

class HolderController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    private function createListData($className, $elementKeys, $separator)
    {

      $elementData = [];
      $elementValues = '';

      $className = 'App\\'.$className;
      $className = new $className();

      foreach ($className->get() as $element) {

        foreach ($elementKeys as $key => $value) {
          $elementValues = $key ? $elementValues = $elementValues . $separator . " " . $element->$value : $elementValues = $element->$value;
        }

        array_push($elementData, [
          'id' => $element->id,
          'val' => $elementValues
        ]);
      }

      return $elementData;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->createListData('Holder', ['name'], ',');
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
        $this->validate($request, [
          'name' => 'request|max:30'
        ]);

        $holder = new Holder([
          'name' => $request->name
        ]);

        $holder->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Holder  $holder
     * @return \Illuminate\Http\Response
     */
    public function show(Holder $holder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holder  $holder
     * @return \Illuminate\Http\Response
     */
    public function edit(Holder $holder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holder  $holder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holder $holder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holder  $holder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holder $holder)
    {
        //
    }
}
