@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      <div class="panel panel-default">

        <div class="panel-heading">{{$pageTitle}}</div>
        <div class="panel-body">

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
            <form class="" action="{{url($pageHref."/".$pageParams[0]['id'])}}" method="post">
              {{ csrf_field() }}
              {{ method_field('put') }}
              <div class="form-group">
                <select v-model="tabName" name="tabName" @change="onChange">
                  <option disabled value="">Выбери таблицу для загрузки файла</option>
                  <option v-for="(item, index) in uploadTables" >@{{ index }}</option>
                </select>

                <span>Загружаем в таблицу: @{{ tabName }}</span>
              </div>

              <div v-if="showFields" class="form-group">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th v-for="(val, key, index) in uploadTables[tabName]">@{{index}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success" name="load">Load</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  Vue.component('fields', {
    template: '',
  });

  new Vue({
    el: '#tab',
    data: {
      uploadTables: {
        @foreach ($uploadTables as $element)
        '{{$element['desc']}}': {
          @foreach ($element['fields'] as $key => $value)
          '{{$value}}': {pos: '{{$key}}', val: ''}{{$loop->last ? '' : ','}}
          @endforeach
        }{{$loop->last ? '' : ','}}
        @endforeach
      },
      tabName: '',
      showFields: false,
    },

    methods: {
      onChange: function(){
        this.showFields = true;
      }
    }
  });
  </script>
@endsection
