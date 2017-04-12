@extends('layouts.app')

@section('content')

  <div class="container">
    &nbsp;
    <a href="#" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#theModal">
      Add new
    </a>

    <div id='p1-table'>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>id</th>
              <th v-for="ps in counts.pageSruture">@{{ ps.desc }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="pp in counts.pageParams">
              <td v-text="pp.id"></td>
              <td v-for="ps in counts.pageSruture" v-text="pp[ps.desc]"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  {{--<script src="{{ asset('js/p2.js') }}"></script>--}}
  <script>
  new Vue({

    el: "#p1-table",

    data: {
      counts: []
    },

    mounted() {
      axios.get('/address').then(response => this.counts = response.data);
    }
  });
  </script>
@endsection
