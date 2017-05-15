@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Spravochnik</div>

        <div id="root" class="panel-body">
          <tabs>
            @foreach ($pageSruture as $pageElement)
              <tab name="{{$pageElement['tabHref']}}" desc="{{$pageElement['tabName']}}" :selected="{{$loop->first ? 'true' : 'false'}}">
                &nbsp;
                <a href="{{url('/modal?m=' . $pageElement['tabHref'])}}" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#{{$pageElement['tabHref']}}Modal">
                  добавить {{$pageElement['tabName']}}
                </a>


                <tab-table name="{{$pageElement['tabHref']}}"></tab-table>
              </tab>
            @endforeach
          </tabs>
        </div>

      </div>
    </div>
  </div>
  <script src="js/spravochnik1.js" charset="utf-8"></script>

    @foreach ($pageSruture as $pageElement)

      {{--start modal--}}
      <div class="modal fade" id="{{$pageElement['tabHref']}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$pageElement['tabHref']}}ModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
          </div>
        </div>
      </div>
      {{--end modal--}}
    @endforeach


<script>

    @foreach ($pageSruture as $pageElement)
      // {{$loop->first ? '' : ''}}

      new Vue({
        el: '#{{$pageElement['tabHref']}}Modal',

        data: {
          form: new Form({
            @foreach ($pageElement['formFields'] as $value)
              {{$value}}: ''{{$loop->last ? '' : ','}}
            @endforeach
          })
        },

        methods: {
          onSubmit() {
              this.form.post('/{{$pageElement['tabHref']}}')
                .then(response => alert('+++'));
          }
        }
      });
    @endforeach

</script>


@endsection
