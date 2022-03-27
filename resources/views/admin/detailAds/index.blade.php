@extends('admin.layouts.master-soyuz')
@section('title',__('Block Detail Page Advertising'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('List Block Detail Page Ads') }}
@endslot

@slot('menu1')
   {{ __('List Block Detail Page Ads') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
      @can('blockadvertisments.create')
        <a  href=" {{url('admin/detailadvertise/create')}} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add New Block Detail Advertise")}}
        </a>
    </div>  
    @endcan                      
</div>
@endslot
@endcomponent
<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('List Block Detail Page Ads') }}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="full_detail_table" class="width100 table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{ __('ID') }}</th>
                          <th>{{ __('Preview') }}</th>
                          <th>{{ __('Ad Position') }}</th>
                          <th>{{ __('Details') }}</th>
                          <th>{{ __('Status') }}</th>
                          <th>{{ __('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                
                        @foreach($details as $key => $detail)
                
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td>
                            @if($detail->linkby != 'adsense')
                            <img src="{{ url('images/detailads/'.$detail->adimage) }}" alt="" class="pro-img">
                            @else
                            <b>
                              {{__('Google adsense preview not available !')}}
                            </b>
                            @endif
                          </td>
                          <td>
                
                            @if($detail->position == 'category')
                            <p><b>{{ __('On Category Page') }}</b></p>
                            @else
                            <p><b>{{ __('On Product Detail Page') }}</b></p>
                            @endif
                
                            <p><b>{{__('Display On')}}:</b>
                
                              @php
                
                
                              $detailpage = App\Category::where('id',$detail->linked_id)->first();
                
                              if(!isset($detailpage)){
                              $detailpage = App\Product::where('id',$detail->linked_id)->first();
                              }
                
                              @endphp
                
                              @if(isset($detailpage))
                              @if(isset($detailpage['name']))
                              {{ $detailpage['name'] ?? '-' }}
                              @else
                              {{ $detailpage['title'] ?? '-' }}
                              @endif
                              @endif
                            </p>
                          </td>
                          <td>
                            <p><b>Linked To:</b>
                              @if(isset($detailpage))
                              @if($detail->linkby == 'detail')
                              {{ $detail->product['name'] ?? '-' }}
                              @elseif($detail->linkby == 'category')
                              {{ $detail->category['title'] ?? '-' }}
                              @elseif($detail->linkby == 'url')
                              {{__("Custom URL")}}
                              @elseif($detail->linkby == 'adsense')
                              {{__("Google Adsense Script")}}
                              @endif</p>
                            @if($detail->top_heading !='')
                            <p><b>{{__("Heading Text")}}:</b> {{ $detail->top_heading }}</p>
                            @endif
                
                            @if($detail->btn_text != '')
                            <p><b>{{__("Button text")}}:</b> {{ $detail->btn_text }}</p>
                            @endif
                            @endif
                          </td>
                          <td>
                            @can('blockadvertisments.edit')
                            <form action="{{ route('detail_button.quick.update',$detail->id) }}" method="POST">
                              {{csrf_field()}}
                              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled="disabled"
                                title="{{ __("This operation is disabled in Demo !") }}" @endif
                                class="btn btn-rounded {{ $detail->status==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
                                {{ $detail->status ==1 ? __('Active') : __('Deactive') }}
                              </button>
                            </form>
                            @endcan
                          </td>
                
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                @can('blockadvertisments.edit')
                                  <a class="dropdown-item" href="{{route('detailadvertise.edit',$detail->id)}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                  @endcan
              
                                  @can('blockadvertisments.delete')
                                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $detail->id }}" >
                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                </a>
                                  @endcan
                              </div>
                          </div>
                          @can('blockadvertisments.delete')
                          <div class="modal fade bd-example-modal-sm" id="delete{{$detail->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <h4>{{ __('Are You Sure ?')}}</h4>
                                            <p>{{ __('Do you really want to delete')}}? {{ __('This process cannot be undone.')}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="{{route('detailadvertise.destroy',$detail->id)}}" class="pull-right">
                                            {{csrf_field()}}
                                            {{method_field("DELETE")}}
                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                           
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



@endsection
