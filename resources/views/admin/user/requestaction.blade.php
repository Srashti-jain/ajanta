@can('stores.accept.request')
<form action="{{ route('store.acp.quick.update',$id) }}" method="POST">
    {{csrf_field()}}
    <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action is disabled in demo!" @endif class="btn btn-sm btn-success">
        <i class="fa fa-check-circle"></i> {{ __('Accept') }}
    </button>
  </form>
  <p></p>
    <button class="btn btn-sm btn-danger" @if(env('DEMO_LOCK') == 0) data-toggle="modal" href="#{{$id}}deletestore" @else disabled title="This action is disabled in demo !" @endif>
        <i class="fa fa-trash-o" aria-hidden="true"></i> {{__("Delete")}}
    </button>
  
    <div id="{{ $id }}deletestore" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
              <p>{{__("Do you really want to delete this")}} <b>{{ $name }}</b> {{__("request? This process cannot be undone.")}}</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{url('admin/stores/'.$id)}}" class="pull-right">
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