@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Employee edit</div>
        <div class="panel-body" id="{{$pageHref}}EditForm">

          <form method="post" action="{{url($pageHref)}}" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            {{ csrf_field() }}
            {{ method_field('put') }}

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

  <script src="../../js/form.js" charset="utf-8"></script>
  <script>
  new Vue({
    el: '#{{$pageHref}}EditForm',

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
