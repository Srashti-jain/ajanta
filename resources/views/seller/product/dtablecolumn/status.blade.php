<form action="{{ route('product.quick.update',$id) }}" method="POST">
  @csrf
  <button type="submit" class="btn btn-rounded {{ $status == '1' ? 'btn-success-rgba' : 'btn-danger-rgba' }}"> {{ $status == '1' ? __('Active') : __('Deactive') }}</button>
  
</form> 