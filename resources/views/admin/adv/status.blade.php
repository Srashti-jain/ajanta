<a @if(env('DEMO_LOCK') == 0) href="{{ route('adv.quick.update',$id) }}" @else disabled title="{{ __("This operation is disabled is demo !") }}" @endif class="btn btn-rounded  {{ $status == 1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
	{{ $status == 1 ? __("Active") : __("Deactive") }}
</a>