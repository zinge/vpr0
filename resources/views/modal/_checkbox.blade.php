<div class="form-group">
  <div class="col-sm-offset-4 col-sm-8">
    <div class="checkbox">
      <label><input type="checkbox" name="{{$field}}" id="{{$field}}" v-model="form.{{$field}}">{{$desc}}</label>

      <span class="help is-danger" v-if="form.errors.has('{{$field}}')" v-text="form.errors.get('{{$field}}')"></span>
    </div>
  </div>
</div>
