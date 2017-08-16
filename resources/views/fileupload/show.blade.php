@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      <div class="panel panel-default">

        <div class="panel-heading">{{$pageTitle}}</div>
        <div class="panel-body">

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

          <div id="tab">           <form action="{{url($pageHref."/".$pageParams[0]['id'])}}" method="post" name="tst">
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
                      <th v-for="(item, index) in uploadTables[tabName]">@{{index}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td v-for="(item, index) in uploadTables[tabName]">
                        <select v-model="item.val" :name="item.pos">
                          <option v-for="n in Object.keys(uploadTables[tabName]).length">@{{ n }}</option>
                        </select>
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
