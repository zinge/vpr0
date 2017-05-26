<div class="form-group">
  <label class="control-label col-sm-4" for="{{$field}}">{{$desc}}:</label>
  <div class="col-sm-8">
    <input type="text" class="form-control" id="{{$field}}" name="{{$field}}" v-model="form.{{$field}}">

    <div class="alert alert-danger" v-if="form.errors.has('{{$field}}')" v-text="form.errors.get('{{$field}}')"></div>
  </div>
</div>
