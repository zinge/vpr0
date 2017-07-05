@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">{{$pageTitle}}</div>
        <div class="panel-body">
          <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="collapse" href="#{{$pageHref}}AddForm" aria-expanded="false" aria-controls="{{$pageHref}}AddForm">{{$pageTitle}} добавить ?</button>
          <div class="collapse" id="{{$pageHref}}AddForm">
            <div class="well">
              <div class="panel">
                {{--<div class="panel panel-heading">заполните форму</div>--}}
                <div class="panel-body">

                  <form method="post" action="{{url($pageHref)}}" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                    {{ csrf_field() }}

                    @foreach ($pageStructure as $pageElement)
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
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pageParams as $tableContent)
                    <tr>
                      @foreach ($tableContent as $key => $value)
                        @if ($key != 'active')
                          <td>{{ $value }}</td>
                        @else
                          <td>{{ $value ? 'активный' : 'отключен' }}</td>
                        @endif
                      @endforeach
                      <td>
                        <form action="{{url($pageHref."/".$tableContent['id']."/edit")}}" method="get">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-xs btn-warning" name="edit">Edit</button>
                        </form>
                      </td>
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

  @foreach ($pageStructure as $value)
    @if ($value['type'] == 'list')

      {{--start modal--}}
      <div class="modal fade" id="{{$value['field']}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$value['field']}}ModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            {{-- @include('modal.index', $pageElement)--}}
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">добавить {{$value['desc']}}</h4>

            </div>
            <div class="modal-body">

              <form class="form-horizontal" action="{{url($value['field'])}}" method="post" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                {{ csrf_field() }}

                @foreach ($modalParams[$value['field']] as $pageElement)
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
      {{--end modal--}}
    @endif
  @endforeach


  <script src="js/form.js" charset="utf-8"></script>
  <script>

  new Vue({
    el: '#{{$pageHref}}AddForm',

    data: {
      form: new Form({
        @foreach ($pageStructure as $value)
        {{$value['field']}}: ''{{$loop->last ? '' : ','}}
        @endforeach
      }),

      @foreach ($pageStructure as $value)
        @if ($value['type'] == 'list')
          {{$value['field']}}:[
            @foreach ($value['data'] as $a)
              { id: {{$a['id']}}, val: "{{$a['val']}}"}{{$loop->last ? '' : ','}}
            @endforeach
          ]{{$loop->last ? '' : ','}}
        @endif
      @endforeach
    },

    methods: {
      onSubmit() {
        this.form.post('{{url($pageHref)}}')
        .then(response => location.reload());
      }
    }
  });

  @foreach ($pageStructure as $value)
  @if ($value['type'] == 'list')
  new Vue({
    el: '#{{$value['field']}}Modal',

    data: {
      form: new Form({
        @foreach ($modalParams[$value['field']] as $pageElement)
        {{$pageElement['field']}}: ''{{$loop->last ? '' : ','}}
        @endforeach
      })
    },

    methods: {
      onSubmit() {
        this.form.post('{{url($value['field'])}}')
        .then(response =>
          location.reload()
          {{-- $('#{{$value['field']}}Modal').modal('hide')--}}
        );
      }
    }
  });
  @endif
  @endforeach
</script>
@endsection
