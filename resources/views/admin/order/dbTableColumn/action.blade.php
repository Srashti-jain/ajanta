<div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
       
        @can('order.view')
        <a title="Print Order" href="{{ route('order.print',$id) }}" target="_blank" class="dropdown-item"><i class="fa fa-print mr-2"></i>Print</a>
        @endcan

        @can('order.delete')
          <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $id }}" ><i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
          <div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
              <div class="modal-dialog modal-sm">

                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="delete-icon"></div>
                  </div>
                  <div class="modal-body text-center">
                    <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
                    <p>{{__("Do you really want to delete this order")}} <b>{{ $order_id }}</b>{{__("? This process cannot be undone.") }}</p>
                  </div>
                  <div class="modal-footer">
                  <form method="POST" action="{{ route('order.delete',$id) }}">
                        @csrf
                        {{ method_field("DELETE") }}

                      <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
                      <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        @endcan


    </div>
</div>