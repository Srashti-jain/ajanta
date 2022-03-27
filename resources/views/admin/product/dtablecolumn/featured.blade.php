 <form action="{{ route('product.featured.quick.update',$id) }}" method="POST">
     @csrf
     <button type="submit" class="btn btn-rounded {{ $featured == '1' ? "btn-success-rgba" : "btn-danger-rgba" }}">
         {{ $featured == '1' ? __('Yes') : __('No') }}
     </button>
 </form>
