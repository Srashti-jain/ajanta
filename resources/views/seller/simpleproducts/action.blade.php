
  <div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
    

    
        <a class="dropdown-item"   target="__blank" role="menuitem" tabindex="-1" href="{{route('show.product',['id' => $row->id, 'slug' => $row->slug])}}"><i class="feather icon-eye mr-2"></i>{{ __("View product")}}</a>
        
       
      
        <a class="dropdown-item"  role="menuitem" tabindex="-1" href="{{route('simple-products.edit',$row->id)}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit Product")}}</a>
        <a class="dropdown-item" data-toggle="modal" href="#pro_{{ $row->id}}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
      </div>
</div>
  


 
  <div id="pro_{{ $row->id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="float-right close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
          <p>{{__("Do you really want to delete this product")}} <b>{{ $row->product_name}}</b>{{ __('? This process cannot be undone.') }}</p>
        </div>
        <div class="modal-footer">
          <form method="post" action="{{route('simple-products.destroy',$row->id)}}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
            <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
