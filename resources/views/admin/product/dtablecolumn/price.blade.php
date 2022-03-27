<p><b>{{__("Entered Price:")}} </b> <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> {{ $vender_price }}</p>

@if($vender_offer_price != '')
<p><b>{{__("Entered Offer Price:")}} </b> <i class="cur_sym fa {{ $defCurrency->currency_symbol }}"></i> {{ $vender_offer_price }}</p>
@endif

<small><a id="hellosk" class="cursor ptl" data-proid="{{ $id }}">Additional Price Detail</a></small>

<!-- ------------------ -->
 <div class="modal fade" id="priceDetail{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog  {{ $vender_offer_price != '' ? 'modal-lg' : 'modal-md' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('Summary of Pricing for')}} {{ $name[app()->getLocale()] ?? $name[config('translatable.fallback_locale')] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="pricecontent{{ $id }}" class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                
            </div>
        </div>
    </div>
</div>
<!-- ------------------ -->


