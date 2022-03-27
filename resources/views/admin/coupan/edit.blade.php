@extends('admin.layouts.master-soyuz')
@section('title',__('Edit New Coupan'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Coupan") }}
@endslot

@slot('menu2')
{{ __("Edit Coupan") }}
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
          <h5 class="box-title">
            {{ __("Edit Coupan") }}
          </h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{ route('coupan.update',$coupan->id) }}" method="POST">
            @csrf
            @method("PUT")
            <div class="box-body">

              <div class="form-group">
                <label>{{__("Coupon code")}}: <span class="required">*</span></label>
                <input value="{{ $coupan->code }}" type="text" class="form-control select2" name="code">
              </div>
              <div class="form-group">
                <label>{{__('Discount type')}}: <span class="required">*</span></label>

                <select required="" name="distype" id="distype" class="form-control select2">

                  <option {{ $coupan->distype == 'fix' ? "selected" : ""}} value="fix">
                    {{__("Fix Amount")}}
                  </option>
                  <option {{ $coupan->distype == 'per' ? "selected" : ""}} value="per">
                    {{__("% Percentage")}}
                  </option>

                </select>

              </div>
              <div class="form-group">
                <label>{{__('Amount')}}: <span class="required">*</span></label>
                <input type="text" value="{{ $coupan->amount }}" class="form-control select2" name="amount">

              </div>
              <div class="form-group">
                <label>{{__("Linked to")}}: <span class="required">*</span></label>

                <select required="" name="link_by" id="link_by" class="form-control select2">
                  <option {{ $coupan->link_by == 'product' ? "selected" : ""}} value="product">{{ __("Link By Product") }}</option>
                  <option {{ $coupan->link_by == 'simple_product' ? "selected" : ""}} value="simple_product">{{ __('Link By Simple Product') }}</option>
                  <option {{ $coupan->link_by == 'cart' ? "selected" : ""}} value="cart">{{  __('Link to Cart') }}</option>
                  <option {{ $coupan->link_by == 'category' ? "selected" : ""}} value="category">{{  __('Link to Category') }}
                  </option>
                </select>

              </div>

              <div id="probox" class="form-group {{ $coupan->link_by == 'product' ? "" : 'display-none' }}">
                <label>{{  __('Select Variant Product') }}: <span class="required">*</span> </label>
                <br>
                <select id="pro_id" name="pro_id" class="form-control select2">
                  @foreach(App\Product::where('status','1')->get() as $product)
                  @if(count($product->subvariants)>0)
                  <option {{ $coupan['pro_id'] == $product['id'] ? "selected" : "" }} value="{{ $product->id }}">
                    {{ $product['name'] }}</option>
                  @endif
                  @endforeach
                </select>
              </div>

              <div id="simpleprobox"
                class="form-group {{ $coupan->link_by == 'simple_product' ? "" : 'display-none' }}">
                <label>{{  __('Select Simple Product') }}: <span class="required">*</span> </label>
                <br>
                <select id="simple_pro_id" name="simple_pro_id" class="form-control select2">
                  @foreach(App\SimpleProduct::where('type','!=','ex_product')->where('status','1')->get() as $sproduct)

                  <option {{ $coupan['simple_pro_id'] == $sproduct['id'] ? "selected" : "" }}
                    value="{{ $sproduct->id }}">{{ $sproduct['product_name'] }}</option>

                  @endforeach
                </select>
              </div>

              <div id="catbox" class="form-group {{ $coupan->link_by == 'category' ? "" : 'display-none'}}">
                <label>{{  __('Select Category') }}: <span class="required">*</span> </label>
                <br>
                <select id="cat_id" name="cat_id" class="form-control select2">
                  @foreach(App\Category::where('status','1')->get() as $cat)
                  
                  <option {{ $coupan->cat_id == $cat->id ? "selected" : "" }} value="{{ $cat->id }}">{{ $cat['title'] }}
                  </option>
                  
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>{{  __('Max Usage Limit') }}: <span class="required">*</span></label>
                <input value="{{ $coupan->maxusage }}" type="number" min="1" class="form-control select2"
                  name="maxusage">
              </div>

              <div id="minAmount" class="form-group {{ $coupan->link_by=='product' ? 'display-none' : "" }}">
                <label>{{  __('Min Amount') }}: </label>
                <div class="input-group">
                  <input value="{{ $coupan->minamount }}" type="number" min="0.0" value="0.00" step="0.1"
                  class="form-control" name="minamount"
                  aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-dollar-sign"></i></span>
                  </div>
                </div>
              
              </div>

              <div class="form-group">
                <label>{{  __('Expiry Date') }}: </label>
                <div class="input-group">
                  <input type="text" id="default-date" class="form-control"
                    value="{{ date('Y-m-d',strtotime($coupan->expirydate)) }}" name="expirydate"
                    placeholder="dd/mm/yyyy" aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>
                </div>


              </div>

              <div class="form-group">
                <label>{{ __("Only For Registered Users") }}:</label>
                <br>
                <label class="switch">
                  <input {{ $coupan->is_login == 1 ? "checked" : "" }} type="checkbox"
                    class="quizfp toggle-input toggle-buttons" name="is_login">
                  <span class="knob"></span>
                </label>
              </div>


            </div>
            <div class="form-group">
              <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update") }}</button>
            </div>
            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection