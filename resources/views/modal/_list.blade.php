<div class="form-group">
  <label class="control-label col-sm-4" for="{{$field}}">{{$desc}}:</label>
  <div class="col-sm-7">
    <select class="form-control" id="{{$field}}" name="{{$field}}" v-model="form.{{$field}}">
      <option disabled value="">выбери одно</option>-->
      @foreach ($data as $data)
        <option value="{{$data['id']}}">{{$data['val']}}</option>
      @endforeach
    </select>

    <div class="alert alert-danger" v-if="form.errors.has('{{$field}}')" v-text="form.errors.get('{{$field}}')"></div>
  </div>
  <div class="col-sm-1">
    <button type="button" class="btn btn-primary" name="button" data-toggle="modal" data-target="#{{$field}}Modal">+</button>
  </div>
</div>

{{--start modal--}}
<div class="modal fade" id="{{$field}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$field}}ModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{-- @include('modal.index', $pageElement)--}}
      <div class="modal-header">
        {{----}}
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="#" method="post">
          {{ csrf_field() }}


        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
{{--end modal--}}
