@extends('admin.layouts.master-soyuz')
@section('title',__("Tickets :ticket - ",['ticket' => $ticket->ticket_no]))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Tickets') }}
@endslot
@slot('menu1')
   {{ __('Support Tickets') }}
@endslot
@slot('menu2')
   {{ __('Tickets') }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a  href="{{ url('admin/tickets') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot


@endcomponent

<div class="contentbar">   

    <div class="row">
  
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
				  <h5 class="card-title"> {{__("Tickets")}}</h5>
			    </div>
                
                <div class="card-body">

					<div class="card border">
						<div class="card-header bg-primary-rgba">

							@if($ticket->status =="open")
							<h4 class="float-right badge badge-info">
								<i class="feather icon-volume-2" aria-hidden="true"></i>
								{{ ucfirst($ticket->status) }}
							</h4>
							@elseif($ticket->status=="pending")
							<h4 class="float-right badge badge-default">
								<i class="fa fa-clock-o mr-1"></i> 
								{{ ucfirst($ticket->status) }}
							</h4>
							@elseif($ticket->status=="closed")
							<h4 class="float-right badge badge-danger">
								<i class="fa fa-ban mr-1"></i> 
								{{ ucfirst($ticket->status) }}
							</h4>
							@elseif($ticket->status=="solved")
								<h4 class="float-right badge badge-success">
									<i class="fa fa-check mr-1"></i> {{ ucfirst($ticket->status) }}
								</h4>
							@endif
							
							<h4>Ticket #{{ $ticket->ticket_no }} {{ $ticket->issue_title }} By : {{ $ticket->users_t ? $ticket->users_t->name : 'User not found !' }}</h4>

							
						</div>
						<div class="card-body">
							@if($ticket->image != null)
							<img src="{{ url('images/helpDesk/'.$ticket->image) }}" class="img-fluid" alt="attached_image" title="Attached Image">
							@endif

							{!! $ticket->issue !!}

							
						</div>

					</div>

					<div class="form-group mt-2">
						<label>Change {{ __('Status:') }}</label>
						<select id="getStatus" onchange="status('{{ $ticket->id }}')" class="select2 form-control"
							name="status" id="">
							<option {{ $ticket->status =="open" ? "selected" : ""}} value="pending">{{ __("Pending") }}</option>
							<option {{ $ticket->status =="open" ? "selected" : ""}} value="open">{{ __("Open") }}</option>
							<option {{ $ticket->status =="closed" ? "selected" : ""}} value="closed">{{ __("Closed") }}</option>
							<option {{ $ticket->status =="solved" ? "selected" : "" }} value="solved">{{ __("Solved") }}</option>
						</select>
					</div>

					<button id="rpy_btn" class="btn btn-primary-rgba"><i class="feather icon-message-square"></i> {{ __("Reply") }}</button>
					<div class="collapse c" id="replay">
						<form action="{{ route('ticket.replay',$ticket->ticket_no) }}" method="POST">
							{{ csrf_field() }}
							<textarea class="form-control" name="msg" id="editor1" cols="30" rows="10"></textarea>
							<br>
							<button type="submit" class="btn btn-md btn-primary-rgba">{{ __("Send Mail") }}</button>
							<button type="button" id="cancel_btn" class="btn btn-md btn-danger-rgba">
								{{__("Cancel")}}
							</button>
						</form>

					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

            
					
@endsection     
                        
@section('custom-script')
<script>
	var url = @json(url('admin/update/ticket/'));
	var redirecturl = @json(route('ticket.show', $ticket->ticket_no));
</script>

<script src="{{asset('js/ticketshow.js')}}"></script>
@endsection      
									
					
					
								
					
					
					
					
										
					
					
                  
              
               
                  

    
                