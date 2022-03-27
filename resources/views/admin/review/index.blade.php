@extends('admin.layouts.master-soyuz')
@section('title',__('All Reviews and Ratings | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('All Reviews and Ratings') }}
@endslot
@slot('menu1')
{{ __("All Reviews") }}
@endslot​
@endcomponent
<div class="contentbar">
  <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5>{{ __('Reviews') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <th>{{ __('Id') }}</th>
                <th>{{ __('Product') }}</th>
                <th>{{ __('User') }}</th>
                <th>{{ __('Review') }}</th>
                <th>{{ __('Quality') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Value') }}</th>
                <th>{{ __('Remark') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
              </thead>
              <tbody>
              <?php $i=1;
                $review_t = 0;
                $price_t = 0;
                $value_t = 0;
                $sub_total = 0;
                $count =  count($reviews);
                ?>
                @foreach($reviews as $review)

                  <tr>
                    <td>{{$i++}}</td>
                    <td>
                      @if(isset($review->pro))
                        {{ $review->pro->name }}
                      @endif

                      @if(isset($review->simple_product))
                        {{ $review->simple_product->product_name }}
                      @endif
                    </td>
                    <td>{{$review->users['name']}}</td>
                    
                    <td>{{$review->review}}</td>
                    <td>{{$review->qty}}</td>
                    <td>{{$review->price}}</td>
                    <td>{{$review->value}}</td>
                    <td>
                      {{$review->remark}}
                    </td>  
                    <td> 
                      <form action="{{ route('review.quick.update',$review->id) }}" method="POST">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-rounded {{ $review->status == 1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                      {{ $review->status ==1 ? __('Active') : __('Deactive') }}
                                    </button>
                        </form>
                    </td>
                    
                    <td>
                      <div class="dropdown">
                          <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                          <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                              
                              <a class="dropdown-item" href="{{url('admin/review/'.$review->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                            
                              <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{$review->id}}" >
                                  <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                              
                          </div>
                      </div>
                      <!-- delete Modal start -->
                      <div class="modal fade bd-example-modal-sm" id="delete{{ $review->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                  <div class="modal-header bg-danger border-danger">
                                      <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                          <h4>{{ __('Are You Sure ?')}}</h4>
                                          <p>{{ __('Do you really want to delete')}} <b> @if(isset($review->pro)) {{ $review->pro->name }} @endif</b> ? {{ __('This process cannot be undone.')}}</p>
                                  </div>
                                  <div class="modal-footer">
                                  <form method="post" action="{{url('admin/review/'.$review->id)}}" class="pull-right">
                                      {{csrf_field()}}
                                      {{method_field("DELETE")}}
                                          <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                                          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
                                      </form>
                                  </div>
                              </div>
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
      </div>
    </div>
  </div>
</div>
@endsection
