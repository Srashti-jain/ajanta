<div class="dropdown">
  <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
    @can('brand.edit')
      <a class="dropdown-item" title="{{__("Edit brand")}} {{ $name }}" href="{{url('admin/brand/'.$id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
      @endcan

      @can('brand.delete')
      
        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $id }}">
          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
        </a>

      @endcan
  </div>
</div>
@can('brand.delete')
<div class="modal fade bd-example-modal-sm" id="delete{{$id}}" tabindex="-1" role="dialog"
  aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>{{ __('Are You Sure ?')}}</h4>
        <p>{{ __('Do you really want to delete')}}? {{ __('This process cannot be undone.')}}</p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ url('admin/brand',$id) }}" class="pull-right">
          @csrf
          @method('DELETE')
          <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
          <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endcan