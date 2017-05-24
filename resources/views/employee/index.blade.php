@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Сотрудники</div>
        <div class="panel-body">
          <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="collapse" href="#{{$pageHref}}AddForm" aria-expanded="false" aria-controls="{{$pageHref}}AddForm">добавить {{$pageTitle}}а</button>
          <div class="collapse" id="{{$pageHref}}AddForm">
            <div class="well">
              <div class="panel">
                {{--<div class="panel panel-heading">заполните форму</div>--}}
                <div class="panel-body">

                  <form method="post" action="{{url($pageHref)}}" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                    {{ csrf_field() }}

                    @foreach ($pageStructure as $pageElement)
                      {{--
                      ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
                      --}}
                      @include("modal._".$pageElement['type'], $pageElement)
                    @endforeach

                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">Сохранить</button>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
          @if (count($pageParams))
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>id</th>
                    @foreach ($pageStructure as $value)
                      <th>{{ $value['desc'] }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pageParams as $value)
                    <tr>
                      <td>{{ $value['id'] }}</td>
                      <td>{{ $value['firstname'] }}</td>
                      <td>{{ $value['patronymic'] }}</td>
                      <td>{{ $value['surname'] }}</td>
                      <td>{{ $value['department'] }}</td>
                      <td>{{ $value['address'] }}</td>
                      <td>{{ $value['active'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>


  <script src="js/spravochnik1.js" charset="utf-8"></script>
  <script>

  new Vue({
    el: '#{{$pageHref}}AddForm',

    data: {
      form: new Form({
        @foreach ($pageStructure as $value)
        {{$value['field']}}: ''{{$loop->last ? '' : ','}}
        @endforeach
      })
    },

    methods: {
      onSubmit() {
        this.form.post('{{url($pageHref)}}')
        .then(response => location.reload());
      }
    }
  });

  </script>

@endsection
