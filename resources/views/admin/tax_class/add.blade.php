@extends('admin.layouts.master-soyuz')
@section('title',__('Create new tax class'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Create new tax class') }}
@endslot
@slot('menu1')
   {{ __('Tax Classes') }}
@endslot
@slot('menu2')
   {{ __('Create new tax class') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a  href=" {{url('admin/tax_class')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   
  <div class="row">
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header">
              <h5 class="card-title"> {{__("Create new tax class")}}</h5>
            </div>
            <div class="card-body">
              <h4>{{ __("Tax Class :") }}</h4>
              <form class="form-horizontal form-label-left" method="post">

                {{csrf_field()}}
                <div class="row">
                  <div class="form-group col-md-6">
                    <label >
                      {{__('Tax Class Title')}} <span class="required">*</span>
                    </label>
                    <input placeholder="{{ __("Please enter tax class") }}" type="text" name="title" id="titles" class="form-control">
                  </div>
                 
                  <div class="form-group col-md-6">
                    <label>
                      {{__("Description")}} <span  class="required">*</span><br>
                    </label>
                    <input placeholder="{{ __("Please enter tax class description") }}" type="text" name="des" id="des" class="form-control">
                  </div>
                </div>
                
                <fieldset>
                  <h4>
                    {{__("Tax Rates :")}}
                  </h4>
                    <table id="full_detail_tables" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr class="table-heading-row">
                            <th>{{ __("Tax Rate") }}</th>
                            <th>{{ __("Based On") }}</th>
                            <th>{{ __("Priority") }}</th>
                        </tr>
                      </thead>
                      <tbody class="xyz">
                      
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"></td>
                          <td class="text-left"><button type="button" onclick="addRow();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="{{ __("Add Rule") }}"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                    </table>
                </fieldset>
         
                <a onclick="SubmitFormData();"  class="btn btn-primary">
                 <i class="fa fa-check-circle mr-2"></i> {{__("Create")}}
                </a>
              </form>
            <!-- /.box -->
             </div>
         </div>
     </div>
     <!-- End col -->
 </div>
 @endsection 
 
 @section('custom-script')
 @include('admin.tax_class.taxclassscript')
 <script>var baseUrl = @json(url('/'));</script>
 <script src="{{ url('js/taxclass.js') }}"></script>
@endsection        
               
                  
                        
                     

                          
                        
              
                  
               
                     
 
  
                 
                  
                
                 
                  
              
               

                  
               
               


        
  
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


