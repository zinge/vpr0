@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      <div class="panel panel-default">

        <div class="panel-heading"><b>{{$pageParams['file_name']}}</b></div>
        <div class="panel-body">

          @if ($tableData)
          <div class="table-responsive">
            <table  class="table table-hover table-bordered">
              <thead>
                <tr>
                  @for ($i=0; $i < count($tableData[0]); $i++)
                    <th>Столбец: {{$i+1}}</th>
                  @endfor
                </tr>
              </thead>
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
            <form action="{{url($pageHref."/".$pageParams['id'])}}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="form-group">Загружаем в таблицу:
              <select v-model="tabName" name="tabName" @change="onChange('showFields')">
                <option disabled value="">Выбери таблицу для загрузки файла</option>
                <option v-for="(item, index) in uploadTables" :value="index">@{{ item.desc }}</option>
              </select>
            </div>

            <div v-if="showFields" class="form-group">
              <div class="table-responsive">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th v-for="(item, index) in uploadTables[tabName].fields">@{{index}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td v-for="(item, index) in uploadTables[tabName].fields">
                        <select v-model="item.val" :name="item.pos" @change="onChange('showButton')">
                          <option disabled value="">столбец</option>
                          <option v-for="n in Object.keys(uploadTables[tabName].fields).length">@{{ n }}</option>
                        </select>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div v-if="showButton" class="form-group">
                <button type="submit" class="btn btn-success">Load</button>
              </div>
            </form>
          </div>
          @endif
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
        '{{$element['name']}}': { desc: '{{$element['desc']}}', fields: {
          @foreach ($element['fields'] as $key => $value)
          '{{$value}}': {pos: '{{$key}}', val: ''}{{$loop->last ? '' : ','}}
          @endforeach
        }}{{$loop->last ? '' : ','}}
        @endforeach
      },
      tabName: '',
      showFields: false,
      showButton: false
    },

    methods: {
      onChange: function(a){
        this[a] = true;
      }
    }
  });
  </script>
@endsection
