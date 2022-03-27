@extends('admin.layouts.sellermastersoyuz')
@section('title', __('Available Brands'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])

@slot('heading')
   {{ __('Available Brands') }}
@endslot

@slot('menu1')
   {{ __('Available Brands') }}
@endslot

@slot('button')

  <div class="col-md-6">
    <div class="widgetbar">
        <a data-toggle="modal" data-target="#exampleStandardModal" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>	{{__("Request New Brand")}}</a>
    </div>                        
  </div>
  
@endslot
    

@endcomponent

<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Available Brands') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="brandDataTable" class="table table-striped table-bordered">
                 <thead>
                   <tr>

                    <th>#</th>
                    <th>{{ __("Brand Logo") }}</th>
                    <th>{{ __("Brand Name") }}</th>
                    <th>{{ __("Status") }}</th>
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


<div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleStandardModalLabel">{{__("Request New Brand")}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('request.brand.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              
              <div class="form-group">
                <label>{{__("Brand Name")}}: <span class="required">*</span></label>
                <input required="" name="name" type="text" class="form-control" placeholder="{{ __('Enter brand name') }}">
              </div>
   
              <div class="form-group">
                <label for="">{{__("Brand Logo")}}: <span class="required">*</span></label>
              <div class="input-group mb-3">
                <div class="custom-file">
                  <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">
                    {{__('Choose file')}}
                  </label>
                </div>
              </div>
               

               
              </div>
   
              <div class="form-group">
                <label>{{__("Categories")}}: <span class="required">*</span></label>
                <select style="width: 100%" required="" class="form-control select2" multiple="multiple" name="category_id[]" id="category_id">
                  @foreach(App\Category::where('status','=','1')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                  @endforeach
                </select>
                <p class="help-block">({{__("Select categories for brand availability")}})</p>
              </div>
   
              <div class="form-group">
                <label for="">{{__("Brand Proof")}}:</label>
                <div class="input-group mb-3">
                  <div class="custom-file">
                    <input type="file"  name="brand_proof" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">
                      {{__('Choose file')}}
                    </label>
                  </div>
                </div>
              
                <p class="help-block">({{__("Required if you submitting your own brand")}})</p>
              </div>
   
              <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
              {{ __("Request")}}</button>
   
              
            </form>
         </div>
          
      </div>
  </div>
</div>
</div>
@endsection

@section('custom-script')
  <script>var url = {!! json_encode( route('seller.brand.index') ) !!};</script>
  <script src="{{ url('js/seller/sellerbrand.js') }}"></script>
@endsection
