<div class="form-group">
  <label class="control-label col-sm-4" for="{{$pageElement['field']."_id"}}">{{$pageElement['desc']}}:</label>
  <div class="col-sm-8">
    <select class="form-control" id="{{$pageElement['field']."_id"}}">
      <option class="disabled">выбери одно</option>
      @foreach ($pageElement['data'] as $data)
          <option value="{{$data['id']}}">{{$data['val']}}</option>
      @endforeach
    </select>
  </div>
</div>
