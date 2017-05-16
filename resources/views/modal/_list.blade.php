<div class="form-group">
  <label class="control-label col-sm-4" for="{{$field}}">{{$desc}}:</label>
  <div class="col-sm-8">
    <select class="form-control" id="{{$field}}" name="{{$field}}" v-model="form.{{$field}}">
      <!--<option class="disabled">выбери одно</option>-->
      @foreach ($data as $data)
          <option value="{{$data['id']}}">{{$data['val']}}</option>
      @endforeach
    </select>

    <span class="help is-danger" v-if="form.errors.has('{{$field}}')" v-text="form.errors.get('{{$field}}')"></span>
  </div>
</div>
