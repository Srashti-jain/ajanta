<div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
        
        <a href="{{ route('offline-orders.show',[$id, 'orderid' => $order_id]) }}" class="dropdown-item">
            <i class="feather icon-eye"></i> {{__("View order")}}
        </a>   

        <a href="{{ route('offline-orders.edit',[$id, 'orderid' => $order_id]) }}" class="dropdown-item">
            <i class="feather icon-edit"></i> {{__("Edit order")}} 
        </a>

        <a data-toggle="modal" data-target="#deleteOrder{{ $id }}" class="dropdown-item">
            <i class="feather icon-trash"></i> {{__("Delete order")}} 
        </a>

        <a href="{{ route('offline-orders.show',[$id, 'orderid' => $order_id]) }}" class="dropdown-item">
            <i class="feather icon-printer"></i> {{__("Print order")}} 
        </a>
      
    </div>
</div>


<div id="deleteOrder{{ $id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            <h5 class="modal-title" id="my-modal-title">{{__("Delete Order")}} <b>#{{ $order_id }}</b></h5>
                
            </div>
            <div class="modal-body">
                <form action="{{ route('offline-orders.destroy',$id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                 <h5> <b>{{__('Are you sure you want to delete this order #:order',['order' => $order_id] )}}</b> </h5>
                 <hr>
                 <button type="button" data-dismiss="modal" class="btn btn-default btn-md">{{__('Cancel') }}</button>
                 <button type="submit" class="btn btn-danger btn-md">{{__('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>