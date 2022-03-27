@extends('admin.layouts.master-soyuz')
@section('title',__('Add New Coupan'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Coupan") }}
@endslot

@slot('menu2')
{{ __("Coupan") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ route('coupan.index') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
</div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">
    
    <div class="col-lg-12">
      @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></p>
        @endforeach
      </div>
      @endif

      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Add') }} {{ __('Coupan') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('coupan.store') }}" method="POST">
            @csrf
            <div class="box-body">

              <div class="form-group">
                <label>{{__("Coupon code")}}: <span class="required">*</span></label>
                <input required="" type="text" class="form-control" name="code">
              </div>
              <div class="form-group">
                <label>{{__('Discount type')}}: <span class="required">*</span></label>

                <select required="" name="distype" id="distype" class="form-control select2">

                  <option value="fix">{{ __('Fix Amount') }}</option>
                  <option value="per">{{ __('% Percentage') }}</option>

                </select>

              </div>
              <div class="form-group">
                <label>{{__('Amount')}}: <span class="required">*</span></label>
                <input required="" type="text" class="form-control select2" name="amount">

              </div>
              <div class="form-group">
                <label>{{__("Linked to")}}: <span class="required">*</span></label>

                <select required="" name="link_by" id="link_by" class="form-control select2">
                  <option value="cart">{{  __('Link to Cart') }}</option>
                  <option value="product">{{  __('Link By Variant Product') }}</option>
                  <option value="simple_product">{{  __('Link By Simple Product') }}</option>
                  <option value="category">{{  __('Link to Category') }}</option>
                </select>

              </div>

              <div id="probox" class="display-none form-group">
                <label>{{  __('Select Variant Product') }}: <span class="required">*</span> </label>
                <br>
                <select id="pro_id" name="pro_id" class="form-control select2">
                  @foreach(App\Product::where('status','1')->get() as $product)
                  @if(count($product->subvariants)>0)
                  <option value="{{ $product->id }}">{{ $product['name'] }}</option>
                  @endif
                  @endforeach
                </select>
              </div>

              <div id="simpleprobox" class="display-none form-group">
                <label>{{  __('Select Simple Product') }}: <span class="required">*</span> </label>
                <br>
                <select id="simple_pro_id" name="simple_pro_id" class="form-control select2">
                  @foreach(App\SimpleProduct::where('type','!=','ex_product')->where('status','1')->get() as $sproduct)

                  <option value="{{ $sproduct->id }}">{{ $sproduct['product_name'] }}</option>

                  @endforeach
                </select>
              </div>

              <div id="catbox" class="display-none form-group">
                <label>{{  __('Select Category') }}: <span class="required">*</span> </label>
                <br>
                <select id="cat_id" name="cat_id" class="form-control select2">
                  @foreach(App\Category::where('status','1')->get() as $cat)
                 
                    <option value="{{ $cat->id }}">{{ $cat['title'] }}</option>
                  
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>{{  __('Max Usage Limit') }}: <span class="required">*</span></label>
                <input required="" type="number" min="1" class="form-control" name="maxusage">
              </div>

              <div id="minAmount" class="form-group">
                <label>{{  __('Min Amount') }}: </label>
                <div class="input-group">
                  <input type="number" min="0.0" value="0.00" step="0.1" class="form-control" name="minamount"
                    aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-dollar-sign"></i></span>
                  </div>
                </div>
            
              </div>


              <div class="form-group">
                <label>{{  __('Expiry Date') }}: </label>
                <div class="input-group">
                  <input type="text" id="default-date" class="form-control" name="expirydate" placeholder="dd/mm/yyyy"
                    aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label>{{ __('Only For Registered Users') }}:</label>
                <br>
                <label class="switch">
                  <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="is_login" checked>
                  <span class="knob"></span>
                </label>
              </div>


            </div>

            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                {{ __("Reset") }}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Create") }}</button>
            </div>

            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection