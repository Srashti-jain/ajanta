<div class="dropdown">
	<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
	<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
	
		<a  title="{{__("Edit Country")}} {{ $nicename }}" class="dropdown-item" href="{{url('admin/country/'.$cid.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
	
		
		<a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#country{{ $cid }}">
			<i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
		</a>
	</div>
</div>
	