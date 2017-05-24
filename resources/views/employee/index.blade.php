@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Сотрудники</div>
        <div class="panel-body">
          <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#employeeModal">добавить сотрудника</button>
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
@endsection
