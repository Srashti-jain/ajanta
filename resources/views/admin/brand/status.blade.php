<form action="{{ route('brand.quick.update',$id) }}" method="POST">
      {{csrf_field()}}
   <span   @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="{{ __("This operation is disabled in Demo !") }}" @endif class="btn btn-rounded {{ $status==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
        {{ $status ==1 ? __('Active') : __('Deactive') }}
   </span>
</form> 
