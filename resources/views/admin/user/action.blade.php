<div class="dropdown">
  <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
    
    @can('users.edit')
      <a class="dropdown-item"  href="{{url('admin/users/'.$id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit User")}}</a>
    @endcan

    @can('users.delete')
      <a class="dropdown-item"@if(env('DEMO_LOCK')==0) data-toggle="modal" href="#deleteuser_{{ $id }}" @else
      title="{{ __("This action is disabled in demo !") }}" disabled="disabled" @endif><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
      @endcan
    </div>
</div>



@can('users.delete')
<div id="deleteuser_{{ $id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>
          {{__("Do you really want to delete this user? This process cannot be undone.")}}
        </p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admin/users/'.$id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}

          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endcan
