@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <form action="{{url($pageHref).'/'.$pageParams[0]['id']}}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <button type="submit" class="btn btn-xs btn-block btn-danger">Удалить {{$pageTitle}}а </button>
          </form>
        </div>
        <div class="panel-body" id="{{$pageHref}}EditForm">

          <form method="post" action="{{url($pageHref)}}" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            {{ csrf_field() }}
            {{ method_field('put') }}

            @foreach ($pageStructure as $pageElement)
              @include("modal._".$pageElement['type'], $pageElement)
            @endforeach

            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">Исправить</button>
              </div>
            </div>
          </form>
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

  {{-- print_r($pageParams) --}}

  <script src="../../js/form.js" charset="utf-8"></script>
  <script>
  new Vue({
    el: '#{{$pageHref}}EditForm',

    data: {
      form: new Form({
        @foreach ($pageStructure as $value)
        {{$value['field']}}: '{{$pageParams[0][$value['field']]}}'{{$loop->last ? '' : ','}}
        @endforeach
      })
    },

    methods: {
      onSubmit() {
        this.form.put('{{url($pageHref)."/".$pageParams[0]['id']}}')
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
      }),
    },

    methods: {
      onSubmit() {

        this.form.post('{{url($value['field'])}}')
        .then(response => location.href = "{{url($pageHref)}}");
      }
    }
  });
  @endif
  @endforeach
  </script>
@endsection
