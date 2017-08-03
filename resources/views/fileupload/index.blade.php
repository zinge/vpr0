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

                  <form method="post" action="{{url($pageHref)}}" class="form-horizontal">
                    {{ csrf_field() }}

                    @foreach ($pageStructure as $pageElement)
                      @if ($pageElement['type'] != 'none')
                        @include("modal._".$pageElement['type'], $pageElement)
                      @endif
                    @endforeach

                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
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
                  @foreach ($pageParams as $tableContent)
                    <tr>
                      @foreach ($tableContent as $key => $value)
                        <td>{{ $value }}</td>
                      @endforeach
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
@endsection
