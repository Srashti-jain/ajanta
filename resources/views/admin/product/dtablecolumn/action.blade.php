<div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
      @if(isset($subvariants[0]))
         @php
             $url = App\Helpers\ProductUrl::getUrl($subvariants[0]['id']);
         @endphp
        <a class="dropdown-item" href="{{ $url }}"><i class="feather icon-eye mr-2"></i>View product</a>
        <a href="{{ route('pro.vars.all',$id) }}" class="dropdown-item"><i class="feather icon-grid mr-2"></i>
            {{__("View All Variants")}}    
        </a>
      
      @endif
        <a class="dropdown-item" href="{{ route('add.var',$id) }}"><i class="feather icon-plus-square mr-2"></i> {{ __("Add Variant") }}</a>
        <a class="dropdown-item" href="{{url('admin/products/'.$id.'/edit')}}"><i class="feather icon-edit mr-2"></i> {{ __("Edit Product") }}</a>  
        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete1{{ $id}}" ><i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>                               
    </div>
</div>
<!-- delete Modal start -->

<div class="modal fade bd-example-modal-sm" id="delete1{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
              <p>{{__("Do you really want to delete this plan")}} <b>{{ $name[app()->getLocale()] ?? $name[config('translatable.fallback_locale')] }}</b> ? By clicking <b>YES</b> subscriptions if any related to this plans also will be deleted ! This process cannot be undone.</p>
          </div>
          <div class="modal-footer">
              <form method="post" action="{{url('admin/products/'.$id)}}" class="pull-right">
              {{csrf_field()}}
              {{method_field("DELETE")}}
                  <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                  <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- delete Model ended -->