@extends('layouts.app')

@section('content')
  <div class="container" id="spravochnik">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Spravochnik</div>

        <div class="panel-body">
          <ul class="nav nav-tabs">
            @foreach ($pageSruture as $pageElement)
              <li role="presentation" class="{{$loop->first ? 'active' : ''}}"><a href="#{{$pageElement['tabHref']}}" data-toggle="tab">{{$pageElement['tabName']}}</a></li>
            @endforeach
          </ul>

          <div class="tab-content">
            @foreach ($pageSruture as $pageElement)
              <div id="{{$pageElement['tabHref']}}" class="tab-pane fade {{$loop->first ? 'in active' : ''}}">
                &nbsp;
                <a href="{{url('/modal' . "?m=" . $pageElement['tabHref'])}}" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#{{$pageElement['tabHref']}}Modal">
                  Add new {{$pageElement['tabName']}}
                </a>


                {{--
                <h3>{{$pageElement['tabName']}}</h3>
                <p>Some content in {{$pageElement['tabHref']}}.</p>
                --}}
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                      </tr>
                      <tr>
                        <td>Mary</td>
                        <td>Moe</td>
                        <td>mary@example.com</td>
                      </tr>
                      <tr>
                        <td>July</td>
                        <td>Dooley</td>
                        <td>july@example.com</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                {{--start modal--}}
                <div class="modal fade" id="{{$pageElement['tabHref']}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$pageElement['tabHref']}}ModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    </div>
                  </div>
                </div>
                {{--end modal--}}
              </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="{{ asset('js/spravochnik.js') }}"></script>
@endsection
