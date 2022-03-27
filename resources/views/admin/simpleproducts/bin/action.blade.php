
  <div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
    

    
        <a class="dropdown-item"  data-toggle="modal" href="#restore_pro_{{ $id}}"><i class="feather icon-refresh-cw mr-2"></i>{{__("Restore")}}</a>
        
       
      
        <a class="dropdown-item"  data-toggle="modal"  href="#pro_{{ $id}}"><i class="feather icon-trash mr-2"></i>{{__("Delete")}}</a>
       
      </div>
</div>
  


<div id="restore_pro_{{ $id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
            <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
            <p> {{__("Do you really want to restore this product")}} <b>{{ $product_name[app()->getLocale()] ?? $product_name[config('translatable.fallback_locale')] }}</b>{{ __("? This process cannot be undone.") }}</p>
        </div>
        <div class="modal-footer">
            <form method="post" action="{{route('restore.simple.products',$id)}}" class="pull-right">
                @csrf
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
            <button type="submit" class="btn btn-md bg-green">{{ __("YES") }}</button>
            </form>
        </div>
        </div>
    </div>
</div>
  
<div id="pro_{{ $id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
          <p>{{__("Do you really want to delete this product")}} <b>{{ $product_name[app()->getLocale()] ?? $product_name[config('translatable.fallback_locale')] }}</b>{{ __("? This process cannot be undone.") }}</p>
        </div>
        <div class="modal-footer">
          <form method="post" action="{{route('force.trash.simple.products',$id)}}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
            <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
          </form>
        </div>
      </div>
    </div>
</div>