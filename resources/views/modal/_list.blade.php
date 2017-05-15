<div class="form-group">
  <label class="control-label col-sm-4" for="{{$pageElement['field']}}">{{$pageElement['desc']}}:</label>
  <div class="col-sm-8">
    <select class="form-control" id="{{$pageElement['field']}}" name="{{$pageElement['field']}}" v-model="form.{{$pageElement['field']}}">
      <!--<option class="disabled">выбери одно</option>-->
      @foreach ($pageElement['data'] as $data)
          <option value="{{$data['id']}}">{{$data['val']}}</option>
      @endforeach
    </select>

    <span class="help is-danger" v-if="form.errors.has('{{$pageElement['field']}}')" v-text="form.errors.get('{{$pageElement['field']}}')"></span>
  </div>
</div>
