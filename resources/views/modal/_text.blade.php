<div class="form-group">
  <label class="control-label col-sm-4" for="{{$pageElement['field']}}">{{$pageElement['desc']}}:</label>
  <div class="col-sm-8">
    <input type="text" class="form-control" id="{{$pageElement['field']}}" name="{{$pageElement['field']}}" v-model="form.{{$pageElement['field']}}">

    <span class="help is-danger" v-if="form.errors.has('{{$pageElement['field']}}')" v-text="form.errors.get('{{$pageElement['field']}}')"></span>
  </div>
</div>
