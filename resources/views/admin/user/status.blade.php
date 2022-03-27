 <form action="{{ route('user.quick.update',$id) }}" method="POST">
    {{ csrf_field() }}
  <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="{{ __("This action is disabled in demo !") }}" @endif class="btn btn-xs {{ $status == 1 ? "btn-success" : "btn-danger" }}">
    @if($status==1)
     {{__("Active")}}
    @else
      {{__("Deactive")}}
    @endif
  </button>
</form>