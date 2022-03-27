@extends('admin.layouts.sellermastersoyuz')
@section('title',__('View :pro \'s all variants',['pro' => $pro->name]))
@section('body')

@component('seller.components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('View :pro \'s all variants',['pro' => $pro->name]) }}
@endslot
@slot('menu1')
   {{ __('Variant Product') }}
@endslot
@slot('menu2')
   {{ __('View All Variants') }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('my.products.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   
             
  <!-- Start row -->
  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">
					  {{__('View :pro \'s all variants',['pro' => $pro->name])}}

					@php
						$getstorename = App\Store::where('id',$pro->store_id)->first()->name;
					@endphp
					<small>{{__('Sold by :')}} {{ $getstorename }}</small>
					<br>
					<br>
					@php
					 $getcatname = App\Category::where('id',$pro->category_id)->first()->title;
					 $getsubcatname = App\Subcategory::where('id',$pro->child)->first()->title;
					 if(isset($pro->grand_id) && $pro->grand_id != 0){
						 $getchildaname = App\Grandcategory::where('id',$pro->grand_id)->first();
					 }
					 
					@endphp
	             </h5>
				 <h6>{{__('In:')}} <span class="font-weight">{{ $getcatname }}</b> <i class="feather icon-chevrons-right" aria-hidden="true"></i>
					<span class="font-weight">{{ $getsubcatname }}</span> <i class="feather icon-chevrons-right" aria-hidden="true"></i>
				   @if(isset($pro->grand_id) && $pro->grand_id != 0) {{ $getchildaname->title }} @endif
	            </h6>
              </div>
			  <div class="card-body">
			  <div class="table-responsive">
				<table id="productTable" class="table table-striped table-bordered">
				  <thead>
					<tr>
						<th>#</th>
						<th>
							{{__('Variant Detail')}}
						</th>
						<th>
							{{__("Pricing Details")}}
						</th>
						<th>
							{{__('Added / Updated On')}}
						</th>
						<th>
							{{__('Action')}}
						</th>
					</tr>
				  </thead>
				  <tbody>
					@foreach($pro->subvariants as $key=> $sub)
					<tr>
						<td class="align-middle">{{ $key+1 }}</td>
						<td class="align-middle">
							<div class="row">
								<div class="col-md-3">
									
									@if(count($pro->subvariants)>0)
										
		                                @if(isset($sub->variantimages['image2']))
		                                  
		                                  <img class="pro-img ximg2" title="{{ $pro->name }}" src="{{ url('variantimages/thumbnails/'.$sub->variantimages['main_image']) }}" alt="{{ $sub->variantimages['main_image'] }}">
		                                
		                                
		                              @endif
									@else
									<img  src="{{ asset('images/no-image.png') }}" alt="no-image.png" class="viewproduct-image">
									@endif
								</div>

								<div class="col-md-6">
									<p><b>Variant Name:</b> {{ $pro->name }} 
										(@foreach($sub->main_attr_value as $k => $getvar)

											{{-- Getting Attribute Names --}}
											@php 
												$getattrname = App\ProductAttributes::where('id',$k)->first()->attr_name
											@endphp
											{{-- Getting Attribute Values --}}
											
											
											@php 
												$getvalname = App\ProductValues::where('id',$getvar)->first();
											@endphp
											
											@if(strcasecmp($getvalname['values'], $getvalname['unit_value']) !=0 && $getvalname->unit_value != null )

												@if($getvalname->proattr->attr_name == "Color" || $getvalname->proattr->attr_name == "Colour" || $getvalname->proattr->attr_name == "color" || $getvalname->proattr->attr_name == "colour")
											{{ $getvalname['values'] }}
											@else
											{{ $getvalname['values'] }}{{ $getvalname->unit_value }},
											@endif
											@else
												{{ $getvalname['values']}},
											@endif
									    @endforeach)
								    </p>
											

							
									

									<p><b>Additional Price: </b> {{ $sub->price }}</p>
									<p><b>Min Qty. For Order:</b> {{ $sub->min_order_qty }}</p>

									<p><b>Stock :</b> {{ $sub->stock }} | <b>Max Qty. For Order:</b> {{ $sub->max_order_qty }}</p>
								</div>

							</div>
							
							
							
						</td>
						<td class="align-middle">
						
							@if($pro->vender_offer_price !=null)
							<p><b>Discounted Price : </b>{{ $pro->offer_price }}</p>
							<p><b>Selling Price : </b>{{ $pro->price }}</p>
							@else
							<p><b>Selling Price : </b>{{ $pro->price }}</p>
							@endif

							<p>(<b>Incl. Admin Commission in this rate</b>)</p>
						</td>

						<td>
                            <p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 
                              <span class="font-weight500">{{ date('M jS Y',strtotime($sub->created_at)) }},</span></p>
                            <p ><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="font-weight500">{{ date('h:i A',strtotime($sub->created_at)) }}</span></p>
                            
                            <p class="border-grey"></p>
                            
                            <p>
                               <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
                               <span class="font-weight500">{{ date('M jS Y',strtotime($sub->updated_at)) }}</span>
                            </p>
                           
                            <p><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="font-weight500">{{ date('h:i A',strtotime($sub->updated_at)) }}</span></p>
                            
                         </td>

						<td class="align-middle">
							<div class="dropdown">
								<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
								<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
									@php 
									$var_name_count = count($sub['main_attr_id']);
								
										$name;
									$var_name;
										$newarr = array();
									for($i = 0; $i<$var_name_count; $i++){
									$var_id =$sub['main_attr_id'][$i];
									$var_name[$i] = $sub['main_attr_value'][$var_id];
										
										$name[$i] = App\ProductAttributes::where('id',$var_id)->first();
										
									}
									try{
										$url = url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
									}catch(Exception $e)
									{
										$url = url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
									}
	
								@endphp


									<a class="dropdown-item"   href="{{ $url }}" ><i class="feather icon-eye mr-2"></i>{{ __("View product")}}</a>
									
									<a class="dropdown-item" href="{{ route('seller.edit.var',$sub->id) }}" ><i class="feather icon-grid mr-2"></i>{{ __(" Edit ")}}</a>
								
									
									<a class="dropdown-item" data-toggle="modal" href="#deletevar{{ $sub->id }}" ><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
								</div>
							</div>
							
							 

						</td>

						
					</tr>
					@endforeach
				</tbody>
				   
				 
			  </table>
		  </div>
          
        </div>
    </div>
    <!-- End col -->
</div>

@endsection     
                        
@section('custom-script')

@endsection                  
                  







                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


