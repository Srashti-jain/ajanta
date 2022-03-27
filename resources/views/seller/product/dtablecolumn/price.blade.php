<p><b>{{__("Selling Price")}}: </b> <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> {{ $price }}</p>

@if($vender_offer_price != '')
<p><b>{{__("Selling Offer Price")}}: </b> <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> {{ $offer_price }}</p>
@endif

<small><a id="hellosk" class="cursor ptl" data-proid="{{ $proid }}">{{ __('Additional Price Detail') }}</a></small>

  <!-- Modal -->
<div class="modal fade" id="priceDetail{{ $proid }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog {{ $vender_offer_price != '' ? "modal-lg" : "modal-md" }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{__("Summary of Pricing for")}} {{ $productname }}</h4>
      </div>
      <div id="pricecontent{{ $proid }}" class="modal-body">
          
          

        
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
        
      </div>
    </div>
  </div>
</div>

