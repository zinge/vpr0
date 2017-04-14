<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">{{"добавить ".$pageTitle}}</h4>
</div>
<div class="modal-body">

  <form class="form-horizontal">

  @foreach ($pageSruture as $pageElement)
    {{--
      ['type' => 'text', 'field' => 'city', 'desc' => 'город'],
    --}}
    @include("modal._".$pageElement['type'], $pageElement)
  @endforeach

  </form>


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary">Save changes</button>
</div>
