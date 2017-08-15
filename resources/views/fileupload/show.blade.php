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

                <div id="tab">
                  {{-- {{ dd($uploadTables) }} --}}
                </div>
            </div>
        </div>
    </div>

    <script>
      new Vue({
        el: '#tab',
        data: {
           uploadTables: {
            @foreach ($uploadTables as $element)
              {{$element['name']}}: {desc: '{{$element['desc']}}', fields: {
                @foreach ($element['fields'] as $key => $value)
                  {{$key}}: '{{$value}}'{{$loop->last ? '' : ','}}
                @endforeach
              }}{{$loop->last ? '' : ','}}
            @endforeach
          }
        }
      });
    </script>
@endsection
