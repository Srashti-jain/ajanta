@extends('admin.layouts.master-soyuz')
@section('title',__('Wallet Setting | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Wallet Setting') }}
@endslot
@slot('menu1')
   {{ __('Wallet Setting') }}
@endslot



@endcomponent

<div class="contentbar">   
  <div class="card mb-5">
    <div class="card-body">
      <div class="row">
        <div class="form-group col-md-12">
          <label>{{__("Enable Wallet:")}} </label>
          <br>
          <label class="switch">
              <input {{ $wallet == 1 ? "checked" : "" }} type="checkbox" class="wallet_enable" name="wallet_enable">
              <span class="knob"></span>
          </label>
          <br>
          <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("It will activate the wallet on portal")}}
          </small>
        </div>
        <div class="wallet-dashboard {{ $wallet == 0 ? "hide" : "" }}">
          <h5 class="ml-md-3">{{ __("Wallet States:") }}</h5>
           
           
          <div class="row ml-1 mr-1">
            
            

            <div class="col-lg-12 col-xl-4 col-12">
              <div class="card m-b-30 bg-success-rgba shadow-sm">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-9">
                              <h4>{{ $states['activeuser'] }}</h4>
                              <p class="font-14 mb-0">{{ __('Active Wallet Users') }}</p>
                              
                          </div>
                          <div class="col-md-3 col-3">
                           <i class="text-success iconsize feather icon-bar-chart-line- "></i>
                          </div>
                          <div class="col-md-12 col-12">
                            <small class="text-muted">({{__("Counted active wallet users ONLY")}})</small>
                          </div>
                          
                         
                        </div>
                        
                         
                        
                      </div>
                  </div>
            </div>
            <div class="col-md-4">
              <div class="card m-b-30 bg-danger-rgba shadow-sm">
                  <div class="card-body">
                      <div class="row align-items-center">
                          <div class="col-9">
                              <h4>{{ $states['totaluser'] }}</h4>
                              <p class="font-14 mb-0">{{ __('Total Wallet Users') }}</p>
                            
                          </div>
                          <div class="col-md-3 col-3">
                             <i class="text-danger iconsize feather icon-users"></i>
                          </div>
                          <div class="col-md-12">
                            <small class="text-muted">({{__('Counted active and deactive wallet users')}})</small>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card m-b-30 bg-warning-rgba shadow-sm">
                  <div class="card-body">
                      <div class="row align-items-center">
                          <div class="col-7">
                              <h4>{{ $states['wallettxn'] }}</h4>
                              <p class="font-14 mb-0">{{ __("Wallet Transcations") }}</p>
                            
                          </div>
                          <div class="col-5 text-right">
                            <i class=" text-warning iconsize feather icon-bar-chart-line"></i>
                        
                          </div>
                          <div class="col-md-12">
                            <small class="text-muted">({{__("No of user wallet transcations made on")}} {{ config('app.name') }})</small>
                          </div>
        
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card m-b-30 bg-primary-rgba shadow-sm">
                  <div class="card-body">
                      <div class="row align-items-center">
                          <div class="col-7">
                              <h4 class=" {{ $states['overallwalletbalance'] < 0 ? "text-danger" : ""  }}"><i class="{{ $defCurrency->currency_symbol }}"></i> {{ $states['overallwalletbalance'] }}</h4>
                              <p class="font-14 mb-0">
                                {{__("Overall Wallet balance")}}
                              </p>
                            
                          </div>
                          <div class="col-5 text-right">
                            <i class="text-primary iconsize feather icon-credit-card"></i>
                        
                          </div>
                          <div class="col-md-12">
                            <small class="text-muted">({{__("Overall wallet balance of active wallet users")}})</small>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card m-b-30 bg-info-rgba shadow-sm">
                  <div class="card-body">
                      <div class="row align-items-center">
                          <div class="col-8">
                              <h4>{{ $states['walletorders'] }}</h4>
                              <p class="font-14 mb-0">
                                {{__("Total Wallet Orders")}}
                              </p>
                       
                          </div>
                          <div class="col-4 text-right">
                            <i class="text-info iconsize feather icon-shopping-cart"></i>
                        
                          </div>
                          <div class="col-md-12">
                            <small class="text-muted">({{__("Total no. of orders made by wallet")}})</small>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
           
            <div class="col-lg-12">
              <hr>
              <h5 class="card-title">{{ __("Order Wallet Report:") }}</h5>
              <div class="table-responsive">
                <table id="wallet_logs_table" class="w-100 table table-bordered table-striped">
                  <thead>
                      <th>#</th>
                      <th>{{ __("TXN ID") }}</th>
                      <th>{{ __("Note") }}</th>
                      <th>{{ __("Type") }}</th>
                      <th>{{ __("Amount") }}</th>
                      <th>{{ __("Balance") }}</th>
                      <th>{{ __("Transcation Date") }}</th>
                      <th>{{ __("Transcation Time") }}</th>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
            
              
                  
                  
                 
@endsection     
@section('custom-script')
<script>

    $(function () {
      "use strict";
      var table = $('#wallet_logs_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("admin.wallet.settings") }}',
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false},
              {data : 'wallet_txn_id', name : 'wallet_txn_id'},
              {data : 'note', name : 'note'},
              {data : 'type', name : 'type'},
              {data : 'amount', name : 'amount'},
              {data : 'balance', name : 'balance'},
              {data : 'txndate', name : 'txndate'},
              {data : 'txntime', name : 'txntime'},
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print'
          ],
          order : [[0,'DESC']]
      });
      
});

    $('.wallet_enable').on('change', function () {
        var status;
        if ($(this).is(':checked')) {
            status = 1;
            $('.wallet-dashboard').removeClass("hide");
        } else {
            status = 0;
            $('.wallet-dashboard').addClass("hide");
        }


        $.ajax({
            type: 'GET',
            url: '{{ route("admin.update.wallet.settings") }}',
            data: {
                wallet_enable: status
            },
            success: function (data) {
                if (data.code == 200) {

                    swal({
                        title: "Success ",
                        text: data.msg,
                        icon: 'success'
                    });


                } else {

                    swal({
                        title: "error",
                        text: data.msg,
                        icon: 'error'
                    });


                }
            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
            }
        });
    });
</script>
@endsection
                    
  
       


        
         
        
  
                  
                   
  
  
  
  


          
         

            
            
              
            
             
              
          
           
      

    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


