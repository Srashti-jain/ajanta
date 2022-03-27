@extends("admin/layouts.sellermastersoyuz")
@section('title',{{__('Add Product Variant')}})
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
{{ __('Add Product Variant ') }}
@endslot
@slot('menu1')
{{ __('Add Product Variant ') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('seller.add.var',$findpro->id) }}" class="btn btn-primary-rgba"><i
        class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">
  <!-- Start row -->
  <div class="row">
    <!-- Start col -->
    <div class="col-md-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title"> {{__('Add Product Variant For')}} <b>{{ $findpro->name }}</b></h5>
        </div>
        <div class="card-body">
          <form enctype="multipart/form-data" action="{{ route('seller.manage.stock.post',$findpro->id) }}"
            method="POST">
            {{ csrf_field() }}
            <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab"
                  aria-controls="home-line" aria-selected="true"><i class="feather icon-edit mr-2"></i> {{ __('Add Variant') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab"
                  aria-controls="profile-line" aria-selected="false"><i class="feather icon-database mr-2"></i>{{ __('Pricing & Weight') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="contact-tab-line" data-toggle="tab" href="#contact-line" role="tab"
                  aria-controls="contact-line" aria-selected="false"><i
                    class="feather icon-trending-up mr-2"></i>{{ __('Inventory') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="image-tab-line" data-toggle="tab" href="#image-line" role="tab"
                  aria-controls="image-line" aria-selected="false"><i class="feather icon-image mr-2"></i>{{ __('Variant Images') }}</a>
              </li>
            </ul>
            <div class="tab-content" id="defaultTabContentLine">
              <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                <div class="box box-info">
                  <div class="box-header with-border">
                    <div class="card-title">
                      <h5>{{ __('Add Stock') }}</h5>
                    </div>
                  </div>

                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-2">
                        <label>
                         {{__('Product Attributes')}}:
                        </label>
                      </div>


                      <div class="col-md-10">
                        @foreach($findpro->variants as $key=> $var)

                        <div class="card border mb-2">
                          <div class="card-header bg-primary-rgba">
                            <label>
                              <input required class="categories" type="checkbox" name="main_attr_id[]"
                                id="categories_{{ $var->attr_name }}" child_id="{{$key}}" value="{{ $var->attr_name }}">

                              @php
                              $key = '_';
                              @endphp
                              @if (strpos($var->getattrname->attr_name, $key) == false)

                              {{ $var->getattrname->attr_name }}

                              @else

                              {{str_replace('_', ' ', $var->getattrname->attr_name)}}

                              @endif
                            </label>
                          </div>

                          <div class="card-body">

                            @foreach($var->attr_value as $a => $value)
                            @php
                            $nameofvalue = App\ProductValues::where('id','=',$value)->first();
                            @endphp
                            <label>
                              <input required class="a a_{{ $var->attr_name }}" parents_id="{{ $var->attr_name }}"
                                value="{{ $value }}" type="radio" name="main_attr_value[{{$var->attr_name}}]"
                                id="{{ $key }}">

                              @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)

                              @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name == "Colour")

                              <div class="numberCircle">
                                <li class="dotremove" title="{{ $nameofvalue->values }}"><a href="#" title=""><i
                                      style="color: {{ $nameofvalue->unit_value }}" class="fa fa-circle"></i></a>
                              </div>
                              <span class="mr-3">{{ $nameofvalue->values }}</span>





                              @else
                              {{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
                              @endif
                              @else
                              {{ $nameofvalue->values }}
                              @endif


                            </label>
                            @endforeach
                          </div>
                        </div>
                        @endforeach
                        <label>{{__('Set Default Variant')}} :
                          <input type="checkbox" name="def">
                        </label>


                      </div>

                    </div>



                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                <div class="form-group">
                  <label for="">{{ __('Additional Price For This Variant') }}:</label>
                  <div class="row">
                    <div class="col-md-5">
                      <input required value="{{ old('price') }}" placeholder="Enter Price ex 499.99" type="text"
                        step=0.01 class="form-control editprice" name="price">
                    </div>
                  </div>
                  <small class="help-block">{{__('Please enter Price In Positive or Negative')}} <br></small>
                  <div class="row">
                    <div class="col-md-7">
                      <p class="p-3 mb-2 bg-primary-rgba text-blue mt-2">
                        <b>{{ __('Ex') }}. </b>{{__('If for this product price is 100 and you enter +10 than price will be 110')}}
                        <br> {{__('OR')}} <br>
                        {{__('If for this product price is 100 and you enter -10 than price will be 90')}}
                      </p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="weight">{{ __('Weight') }}:</label>
                  <div class="row">
                    <div class="col-md-4">

                      <input type="text" step=0.01 name="weight" class="form-control editprice" value="0.00"
                        placeholder="0.00">
                    </div>
                    <div class="col-md-4">
                      <select name="w_unit" class="select2 form-control">
                        <option value="">{{ __('Please Choose') }}</option>
                        @php
                        $unit = App\Unit::find(1);
                        @endphp
                        @if(isset($unit))
                        @foreach($unit->unitvalues as $unitVal)
                        <option value="{{ $unitVal->id }}">{{ ucfirst($unitVal->short_code) }}
                          ({{ $unitVal->unit_values }})</option>
                        @endforeach
                        @endif
                      </select>
                    </div>
                  </div>

                </div>

              </div>



              <div class="tab-pane fade" id="contact-line" role="tabpanel" aria-labelledby="contact-tab-line">
                <div class="row">
                  <div class="form-group col-md-4">
                    <label for="">{{ __('Add Stock') }}:</label>
                    <input required min="1" type="text" class="form-control price" name="stock"
                      placeholder="{{ __('Enter stock') }}" value="{{ old('stock') }}">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="">{{__('Min Qty')}} :</label>
                    <input required value="{{ old('min_order_qty')  }}" min="1" type="text" class="form-control price"
                      name="min_order_qty" placeholder="{{ __('Enter Min Qty For order') }}">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="">{{__('Max Qty')}} :</label>
                    <input value="{{ old('max_order_qty') }}" min="1" type="text" class="form-control price"
                      name="max_order_qty" placeholder="{{ __('Enter Max Qty For order') }}">
                  </div>
                </div>

              </div>
              <div class="tab-pane fade" id="image-line" role="tabpanel" aria-labelledby="image-tab-line">
                <div class="alert alert-danger">
                  <p><i class="fa fa-info-circle" aria-hidden="true"></i> {{ __('Important') }}</p>

                  <ul>
                    <li>{{__("Altleast two variant image is required")}} !</li>
                    <li>
                      {{__("Default image will be :image later you can change default image in edit variant section.",['image' => '<b><i>Image 1</i></b>'])}}
                    </li>
                  </ul>
                </div>

                <div class="row">

                  <div class="col-md-4 text-center">
                    <div class="card">
                      <label class="padding-one">{{ __('Image 1') }}</label>
                      <div class="card-body">
                        <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                          height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                      </div>
                      <div class="card-footer">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="file" name="chooseFile" name="image1" required=""
                              class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">
                              {{__('Choose file')}}
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>




                  <div class="col-md-4 text-center">
                    <div class="card">
                      <label class="padding-one">{{ __('Image 2') }}</label>
                      <div class="card-body">
                        <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                          height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                      </div>

                      <div class="card-footer">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="file" name="chooseFile" name="image2" required=""
                              class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">
                              {{__('Choose file')}}
                            </label>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="card">
                      <label class="padding-one">
                        {{__('Image 3')}}
                      </label>
                      <div class="card-body">
                        <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                          height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                      </div>

                      <div class="card-footer">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="file" name="chooseFile" name="image3" required=""
                              class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">
                              {{__('Choose file')}}
                            </label>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="card">
                      <label class="padding-one">
                        {{__('Image 4')}}
                      </label>
                      <div class="card-body">
                        <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                          height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                      </div>

                      <div class="card-footer">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="file" name="chooseFile" name="image4" required=""
                              class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">
                              {{__('Choose file')}}
                            </label>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="card">
                      <label class="padding-one">
                        {{__('Image 5')}}
                      </label>
                      <div class="card-body">
                        <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                          height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                      </div>

                      <div class="card-footer">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="file" name="chooseFile" name="image5" required=""
                              class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">
                              {{__('Choose file')}}
                            </label>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="card">
                      <label class="padding-one">
                        {{__('Image 6')}}
                      </label>
                      <div class="card-body">
                        <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                          height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                      </div>

                      <div class="card-footer">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="file" name="chooseFile" name="image6" required=""
                              class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">
                              {{__('Choose file')}}
                            </label>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>





                </div>
              </div>
            </div>
            <div class="form-group mt-3">

              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled="disabled"
                title="{{ __('This action is disabled in demo !') }}" @endif class="btn btn-primary-rgba">
                <i class="feather icon-plus"></i> {{__('Add Variant')}}
              </button>


            </div>

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
  var baseUrl = @json(url('/'));
</script>
<script src="{{ url('js/sellervariant.js') }}"></script>

@endsection