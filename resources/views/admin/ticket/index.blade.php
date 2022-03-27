@extends('admin.layouts.master-soyuz')
@section('title',__('View All Support Tickets | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('View All Support Tickets') }}
@endslot
@slot('menu1')
   {{ __('View All Support Tickets') }}
@endslot




@endcomponent

<div class="contentbar">   

    <div class="row">
  
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
				  <h5 class="card-title"> {{__("View All Support Tickets")}}</h5>
			    </div>
                
                <div class="card-body">
					<div class="table-responsive">
						<table id="ticket_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>
									{{__("Ticket No.")}}
								</th>
								<th>
									{{__("Issue Title")}}
								</th>
								<th>
									{{__("From")}}
								</th>
								<th>
									{{__("Status")}}
								</th>
								<th>
									{{__("Action")}}
								</th>
							</tr>
						</thead>
						<tbody>
				
				
						</tbody>
						
						</table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
               

@endsection     
                        
@section('custom-script')
<script>
var url = {!!json_encode( route('tickets.admin') )!!};
</script>
<script src="{{ url('js/ticket.js') }}"></script>
@endsection     
                    
    
                