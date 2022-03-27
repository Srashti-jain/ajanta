<form action="{{ route('store.quick.update',$id) }}" method="POST">
  {{csrf_field()}}
  <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action is disabled in demo !" @endif class="btn btn-rounded {{ $status == 1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
    {{ $status ==1 ? __('Active') : __('Deactive') }}
  </button>
</form> 