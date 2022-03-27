@extends('admin.layouts.master-soyuz')
@section('title',__('All Subcategories'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Subcategories') }}
@endslot

@slot('menu1')
   {{ __('Subcategories') }}
@endslot

@slot('button')
@can('subcategory.create')

<div class="col-md-6">
    <div class="widgetbar">
        <a data-toggle="modal" data-target="#import_subcategories" role="button" class="btn btn-success-rgba mr-2">
          <i class="feather icon-file-text mr-2"></i> {{__("Import Subcategories")}}
        </a>
        <a  href=" {{url('admin/subcategory/create')}} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add Subcategory")}}
        </a>
    </div>                        
</div>


@endslot
@endcomponent
@endcan

<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title"> {{__('All Subcategories')}}</h5>
                </div>
               
                  
                

                <div class="card-body">
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="p-2 mb-3 bg-success text-white rounded">
                        <i class="fa fa-info-circle ml-1"></i> {{ __("Note") }}:
                        <ul>
                            <li>{{ __("Drag and Drop to sort the Subcategories") }}</li>
                            
                        </ul>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="full_detail_table" class="subcattable width100 table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>{{ __("ID") }}</th>
                          <th>{{ __("Image") }}</th>
                          <th>{{ __('Subcategory Detail') }}</th>
                          <th>{{ __('Icon') }}</th>
                          <th>{{ __('Status') }}</th>
                          <th>{{ __('Featured') }}</th>
                          <th>{{ __('Added/ Updated On') }}</th>
                          <th>{{ __('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody id="sortable">
                        
                        @foreach($subcategory as $key => $cat)
                        <tr class="row1" data-id="{{ $cat->id }}">
                          <td>{{ ++$key }}</td>
                          <td>{{ $cat->id }}</td>
                          <td>
                            @if($cat->image != '' && file_exists(public_path().'/images/subcategory/'.$cat->image) )
                              <img src=" {{url('images/subcategory/'.$cat->image)}}" class="pro-img" title="{{ $cat->title }}">
                            @else

                              <img title="{{ $cat->title }}" class="pro-img" src="{{ Avatar::create($cat->title)->toBase64() }}" />
                
                            @endif
                          </td>
                          <td>
                            <p><b>Name:</b> <span class="font-weight500">{{$cat->title}}</span></p>
                            <p class="font-weight500"><b>{{ __("Description") }}:</b> {{strip_tags($cat->description)}}</p>
                            <p class="font-weight500"><b>{{__("Parent Category")}}:</b> {{$cat->category['title'] ?? ''}}</p>
                
                          </td>
                
                          <td>
                            <p class="font-size-18"><i class="fa {{$cat->icon}}"></i></p>
                          </td>
                
                          <td>
                            @can('subcategory.edit')
                            <form method="POST" action="{{ route('sub.quick.update',$cat->id) }}">
                              {{ csrf_field() }}
                              <button @if(env('DEMO_LOCK')==0) type="submit" @else title="{{ __("This operation is disabled in Demo !") }}"
                                disabled="" @endif class="btn btn-rounded {{ $cat->status ==1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                {{ $cat->status==1 ? __('Active') : __('Deactive') }}
                              </button>
                            </form>
                            @endcan
                          </td>
                
                
                          <td>
                            @can('subcategory.edit')
                            <form method="POST" action="{{ route('sub.featured.quick.update',$cat->id) }}">
                              {{ csrf_field() }}
                              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __("This operation is disabled in Demo !") }}"
                                @endif class="btn btn-rounded {{ $cat->featured ==1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                {{ $cat->featured==1 ? __('Yes') : __('No') }}
                              </button>
                            </form>
                            @endcan
                          </td>
                          <td>
                            <p> <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                
                              <span class="font-weight500">{{ date('M jS Y',strtotime($cat->created_at)) }},</span></p>
                            <p><i class="fa fa-clock-o" aria-hidden="true"></i>
                              <span class="font-weight500">{{ date('h:i A',strtotime($cat->created_at)) }}</span></p>
                
                            <p class="greydashedborder"></p>
                
                            <p>
                              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                              <span class="font-weight500">{{ date('M jS Y',strtotime($cat->updated_at)) }}</span>
                            </p>
                
                            <p><i class="fa fa-clock-o" aria-hidden="true"></i>
                              <span class="font-weight500">{{ date('h:i A',strtotime($cat->updated_at)) }}</span></p>
                
                          </td>
                
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                @can('subcategory.edit')
                                  <a class="dropdown-item" href="{{url('admin/subcategory/'.$cat->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                  @endcan
              
                                  @can('subcategory.delete')
                                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id }}" >
                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                </a>
                                  @endcan
                              </div>
                          </div>
                          <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <form method="post" action="{{url('admin/subcategory/'.$cat->id)}}" class="pull-right">
                                            {{csrf_field()}}
                                            {{method_field("DELETE")}}
                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
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

<div class="modal fade" id="import_subcategories" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleStandardModalLabel">{{__("Bulk Import Subcategories")}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- main content start -->
        <a href="{{ url('files/Subcategory.xlsx') }}" class="btn btn-md btn-success"> {{ __('Download Example xls/csv File') }}</a>
        <hr>
        <form action="{{ url('/import/subcategories') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="form-group col-md-12">
              <label for="file">{{__("Choose your xls/csv File")}} :</label>
              <!-- ------------ -->
              <div class="input-group mb-3">
                
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file" id="inputGroupFile01"
                    aria-describedby="inputGroupFileAddon01" required>
                  <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                </div>
                @if ($errors->has('file'))
                <span class="invalid-feedback text-danger" role="alert">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
                @endif
                <p></p>
              </div>
              <!-- ------------- -->
              <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> {{ __('Import') }}</button>
            </div>

          </div>

        </form>

        <div class="box box-danger">
          <div class="box-header with-border">
            <div class="box-title">{{ __('Instructions') }}</div>
          </div>

          <div class="box-body">
            <p><b>{{ __('Follow the instructions carefully before importing the file.') }}</b></p>
            <p>{{ __('The columns of the file should be in the following order.') }}</p>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>{{ __("Column No") }}</th>
                  <th>{{ __('Column Name') }}</th>
                  <th>{{ __("Required") }}</th>
                  <th>{{ __('Description') }}</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>1</td>
                  <td><b>name</b></td>
                  <td><b>{{ __('Yes') }}</b></td>
                  <td>{{ __("Enter category name") }}</td>
                </tr>

                <tr>
                  <td>2</td>
                  <td> <b>status</b> </td>
                  <td><b>{{ __('Yes') }}</b></td>
                  <td>{{__('Category status')}} (1 = {{ __('active') }}, 0 = {{ __('deactive') }})</b> .</td>
                </tr>
                

                <tr>
                  <td>3</td>
                  <td> <b>image</b> </td>
                  <td><b>{{ __('No') }}</b></td>
                  <td>{{ __('Name your image eg: example.jpg <b>(Image can be uploaded using Media Manager / Subcategory Files Tab. )') }}</b> .</td>
                </tr>

                <tr>
                  <td>4</td>
                  <td> <b>icon</b> </td>
                  <td><b>{{ __('No') }}</b></td>
                  <td>{{__("Icon class name eg:")}} fa-book.</b> .</td>
                </tr>

                <tr>
                  <td>5</td>
                  <td> <b>description</b> </td>
                  <td><b>{{ __('No') }}</b></td>
                  <td><b>{{ __("Description of your category.") }}</b></td>
                </tr>

                <tr>
                  <td>6</td>
                  <td> <b>featured</b> </td>
                  <td><b>{{ __('No') }}</b></td>
                  <td><b>{{ __('Set subcategory to be featured') }} 1 = {{ __('Yes') }}, 0 = {{ __('No') }}.</b></td>
                </tr>

                <tr>
                  <td>7</td>
                  <td> <b>parent_cat</b> </td>
                  <td><b>{{ __('Yes') }}</b></td>
                  <td><b>{{ __('Parent category id to be passed here. It means that this subcategory is linked with given category id.') }}</b></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        <!-- main content end -->
      </div>

    </div>
  </div>
</div>


<!-- /page content -->
@endsection
@section('custom-script')
<script>
  var url = @json(url('/reposition/subcategory/'));
</script>
<script src="{{ url('js/subcategory.js') }}"></script>
@endsection
