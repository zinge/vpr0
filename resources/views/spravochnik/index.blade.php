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
                <p></p>
                <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#{{$pageElement['tabHref']}}Modal">
                  Add new {{$pageElement['tabName']}}
                </button>

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

                <div class="modal fade" id="{{$pageElement['tabHref']}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$pageElement['tabHref']}}ModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="{{$pageElement['tabHref']}}ModalLabel">{{$pageElement['tabName']}} edit</h4>
                      </div>
                      <div class="modal-body">

                        <form class="form-horizontal">
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="text-box">text:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="text-box">
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <div class="checkbox">
                                <label><input type="checkbox"> checkbox</label>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-sm-2" for="sel1">select:</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="sel1">
                                <option class="disabled">select one</option>
                                <option value="1">one its selected</option>
                                <option value="2">two its selected</option>
                                <option value="3">three its selected</option>
                              </select>
                            </div>
                            <button type="button" class="btn btn-default">+</button>
                          </div>

                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="https://unpkg.com/vue" charset="utf-8"></script>
  <script src="{{ asset('js/spravochnik.js') }}"></script>
@endsection
