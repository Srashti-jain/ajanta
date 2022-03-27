<div class="dropdown">
  <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
      @can('menu.edit')
        <a class="dropdown-item" href="{{ route('menu.edit',$id) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
      @endcan
      @can('menu.delete')
      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete1{{ $id}}" ><i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
      @endcan                             
  </div>
</div>
<!-- delete Modal start -->

<div class="modal fade bd-example-modal-sm" id="delete1{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="bg-danger border-danger modal-header">
            <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
            <p>{{__("Do you really want to delete this ? By clicking")}} <b>{{ __('YES') }}</b> {{__('This will be permanently deleted ! This process cannot be undone.') }}</p>
        </div>
        <div class="modal-footer">
            <form method="post" action="{{ route('menu.destroy',$id) }}" class="pull-right">
                @csrf
                @method('delete')
                <button type="reset" class="btn btn-secondary-rgba" data-dismiss="modal">{{ __("No") }}</button>
                <button type="submit" class="btn btn-danger-rgba">{{ __("YES") }}</button>
            </form>
        </div>
    </div>
</div>
</div>

<!-- delete Model ended -->