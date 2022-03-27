<div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
        @can('digital-products.edit')
        <a class="dropdown-item" href="{{route('simple-products.edit',$row->id)}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
        @endcan
        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete1{{ $row->id}}" ><i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>                               
      </div>
</div>
<!-- delete Modal start -->

<div class="modal fade bd-example-modal-sm" id="delete1{{ $row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header bg-danger border-danger">
              <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
          <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
          <p>{{__("Do you really want to delete this product")}} <b>{{ $row->product_name }}</b>{{ __("? This process cannot be undone.") }}</p>
          </div>
          <div class="modal-footer">
              <form method="post" action="{{route('simple-products.destroy',$row->id)}}" class="pull-right">
              {{csrf_field()}}
              {{method_field("DELETE")}}
                  <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                  <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- delete Model ended -->