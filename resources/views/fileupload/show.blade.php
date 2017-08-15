@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                {{-- {{ dd($tableData) }} --}}
                <div class="table-responsive">
                   <table  class="table table-hover table-bordered">
                       <tbody>
                          @foreach ($tableData as $tableContent)
                          <tr>
                              @foreach($tableContent as $key => $value)
                                <td>{{$value}}</td>
                              @endforeach
                          </tr>
                          @endforeach
                       </tbody>
                   </table> 
                </div>
            </div>
        </div>
    </div>
@endsection