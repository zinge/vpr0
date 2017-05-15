<div class="form-group">
  <div class="col-sm-offset-4 col-sm-8">
    <div class="checkbox">
      <label><input type="checkbox" name="{{$pageElement['field']}}" id="{{$pageElement['field']}}" v-model="form.{{$pageElement['field']}}">{{$pageElement['desc']}}</label>

      <span class="help is-danger" v-if="form.errors.has('{{$pageElement['field']}}')" v-text="form.errors.get('{{$pageElement['field']}}')"></span>
    </div>
  </div>
</div>
