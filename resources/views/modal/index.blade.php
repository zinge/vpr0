<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">добавить {{$pageTitle}}</h4>
</div>
<div class="modal-body">

  <form method="post" action="/{{$formHref}}" class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

  @foreach ($pageSruture as $pageElement)
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
