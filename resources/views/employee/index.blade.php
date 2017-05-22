@extends('layouts.app')

@section('content')
  @if (count($employees))
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>id</th>
                @foreach ($pageSruture as $value)
                  <th>$value['field']</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr v-for="pp in counts.pageParams">
                <td v-text="pp.id"></td>
                <td v-for="ps in counts.pageSruture" v-text="pp[ps.field]"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endif
@endsection
