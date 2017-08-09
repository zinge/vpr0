<?php

namespace App\Http\Controllers;

use App\Fu;
use Illuminate\Http\Request;

use Storage;

class FuController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  private function createPageStructure()
  {
    $pageStructure = [
      ['type' => 'file', 'field' => 'file_name', 'desc' => 'имя файла'],
      ['type' => 'none', 'field' => 'mime_type', 'desc' => 'тип файла'],
      ['type' => 'none', 'field' => 'original_filename', 'desc' => 'оригинальное имя файла'],
    ];

    return $pageStructure;
  }

  private function createPageParams($id)
  {
    $pageParams = [];

    $files = $id ? Fu::find([$id]) : Fu::get();

    foreach ($files as $file) {
      array_push($pageParams, [
        'id' => $file->id,
        'file_name' => $file->file_name,
        'mime_type' => $file->mime_type,
        'original_filename' => $file->original_filename,
      ]);
    }

    return $pageParams;
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
    return view('fileupload.index')
    ->with('pageStructure', $this->createPageStructure())
    ->with('pageParams', $this->createPageParams(''))
    ->with('pageTitle', 'файл')
    ->with('pageHref', 'fu');
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
    $this->validate($request,[
      'file_name' => ['file', 'mimes:txt,csv', 'mimetypes:text/plain,text/csv']
    ]);

    $file = $request->file('file_name');
    $fileExt = $file->getClientOriginalExtension();
    Storage::disk('local')->put(
      'files/'.$file->getFilename().'.'.$fileExt,
      file_get_contents($file->getRealPath())
    );
    Fu::create([
      'mime_type' => $file->getClientMimeType(),
      'original_filename' => $file->getClientOriginalName(),
      'file_name' => 'files/'.$file->getFilename().'.'.$fileExt,
    ]);
    return redirect('/fu');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Fu  $fu
  * @return \Illuminate\Http\Response
  */
  public function show(Fu $fu)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Fu  $fu
  * @return \Illuminate\Http\Response
  */
  public function edit(Fu $fu)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Fu  $fu
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Fu $fu)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Fu  $fu
  * @return \Illuminate\Http\Response
  */
  public function destroy(Fu $fu)
  {
    //
    Storage::delete($fu->file_name);

    $fu->delete();

    return redirect('/fu');

  }
}
