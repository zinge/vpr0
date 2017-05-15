<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">добавить {{$pageElement['tabName']}}</h4>
</div>
<div class="modal-body">

  <form method="post" action="{{url($tabHref)}}" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
  {{ csrf_field() }}

  @foreach ($tabStruture as $pageElement)
    {{--
      ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
    --}}
    @include("modal._".$pageElement['type'], $pageElement)
  @endforeach

  </form>


</div>
<div class="modal-footer">
  <div class="form-group">
    <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">Сохранить</button>
  </div>
</div>
