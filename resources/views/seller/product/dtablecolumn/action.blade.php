
  <div class="dropdown">
      <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
        @if(isset($subvariants[0]))

        @php
            $url = App\Helpers\ProductUrl::getUrl($subvariants[0]['id']);
        @endphp
          <a class="dropdown-item"   href="{{ $url }}"><i class="feather icon-eye mr-2"></i>{{ __("View product")}}</a>
          
          <a class="dropdown-item"  href="{{ route('seller.pro.vars.all',$id) }}"><i class="feather icon-grid mr-2"></i>{{ __(" View All Variants")}}</a>
         
          @endif
          <a class="dropdown-item"  href="{{ route('seller.add.var',$id) }}"><i class="feather icon-plus-square mr-2"></i>{{ __("Add Variant")}}</a>
          <a class="dropdown-item"  href="{{ route('my.products.edit',$id) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit Product")}}</a>
          <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
        </div>
  </div>
    

  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">{{ __('Do you really want to delete this product') }}? {{__('This process cannot be undone.')}}</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{route('my.products.destroy',$id)}}" class="pull-right">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
            </form>
            </div>
        </div>
    </div>
</div>

