<div class="form-group">
  <label class="control-label col-sm-4" for="{{$field}}">{{$desc}}:</label>
  <div class="col-sm-7">
    <select class="form-control" id="{{$field}}" name="{{$field}}" v-model="form.{{$field}}">
      <option disabled value="">выбери одно</option>
      <template v-for="option in {{$field}}">
        <option :value="option.id" v-text="option.val"></option>
      </template>
    </select>

    <div class="alert alert-danger" v-if="form.errors.has('{{$field}}')" v-text="form.errors.get('{{$field}}')"></div>
  </div>
  <div class="col-sm-1">

    <button type="button" class="btn btn-primary" name="button" data-toggle="modal" data-target="#{{$field}}Modal">+</button>

  </div>
</div>
