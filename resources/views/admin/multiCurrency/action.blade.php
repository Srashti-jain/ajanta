<div class="dropdown">
    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
      
        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#edit1{{ $id }}" ><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>                               
        @if($currencyextract['default_currency'] != 1)
        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete1{{ $id }}" ><i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
        @endif                               
      </div>
</div>
<!-- delete Modal start -->
<div class="modal fade bd-example-modal-sm" id="delete1{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
          <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
          <p>{{__("Do you really want to delete currency")}} <b>{{ $code }}</b> {{ __('? This process cannot be undone.') }}</p>
          </div>
          <div class="modal-footer">
              <form method="post" action="{{route('multiCurrency.destroy',$currencyextract['id'])}}" class="pull-right">
                  @method('delete')
                  @csrf
                  <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                  <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
              </form>
          </div>
      </div>
  </div>
</div>
<!-- delete Model ended -->

<!-- edit Modal start -->
<!-- Modal -->
<div class="modal fade" id="edit1{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">Edit Currency {{ $code }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form action="{{ route('multiCurrency.update',$code) }}" method="POST">
                  @csrf

                  @method('PUT')

                  <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="text-dark">{{__("Currency Code:")}} <span class="text-danger">*</span></label>
                        <input readonly placeholder="{{__("eg.")}} USD" value="{{ $code }}" required class="form-control width100"
                          type="text" name="code">
                      </div>
                    </div>


                    <div class="col-md-12">
                      <br>
                      <div class="form-group">
                        <label class="text-dark">
                          {{__("Additional Charge:")}}
                        </label>
                        <input placeholder="{{__("eg.")}} 0.50" min="0" step="0.01" value="{{ $currencyextract['add_amount'] }}"
                          class="form-control width100" type="number" name="add_amount">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <br>
                      <div class="form-group">
                        <label class="text-dark">{{__("Currency Position:")}} <span class="text-danger">*</span></label>
                        <br>
                        <select name="position" id="position" class="form-control">
                            <option value="">{{ __("Please select currency position") }}</option>
                            <option {{ $currencyextract['position'] == 'l' ? "selected" : "" }} value="l">{{ __("Left side currency icon") }}</option>
                            <option {{ $currencyextract['position'] == 'r' ? "selected" : "" }} value="r">{{ __("Right side currency icon") }}</option>
                            <option {{ $currencyextract['position'] == 'ls' ? "selected" : "" }} value="ls">{{ __("Left side with space currency icon") }}</option>
                            <option {{ $currencyextract['position'] == 'rs' ? "selected" : "" }} value="rs">{{ __("Right side with space currency icon") }}</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <br>
                      <div class="form-group">
                        <label class="text-dark">{{__("Currency Symbol:")}} <span class="text-danger">*</span></label>
                        <br>
                        <div class="input-group">
                          <input id="iconvalue{{ $id }}" name="currency_symbol" type="text" class="form-control" required value="{{ $currencyextract['currency_symbol'] }}">
                          <span class="input-group-append">
                          <button role="iconpicker" id="iconpick{{ $id }}" type="button" class="btn btn-outline-secondary iconpick"></button>
                          </span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <br>
                      <div class="form-group">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {{ __("Update")}}</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>  
                    
                      </div>
                    </div>

                  </div>

                </form>
                <!-- form end -->
            </div>
           
        </div>
    </div>
</div>
<!-- edit Model ended -->

<script>
  var iconpickerpresent = $("button").is('#iconpick'+'{{ $id }}');
				if (iconpickerpresent) {
				$('#iconpick'+'{{ $id }}').iconpicker()
					.iconpicker('setAlign', 'center')
					.iconpicker('setCols', 5)
					.iconpicker('setArrowPrevIconClass', 'fa fa-angle-left')
					.iconpicker('setArrowNextIconClass', 'fa fa-angle-right')
					.iconpicker('setIconset', {
					iconClass: 'fa',
					iconClassFix: 'fa-',
          icons: [
                  
                  'inr', 'eur', 'bitcoin', 
                  'btc', 'cny', 'dollar', 'gg-circle',
                  'gg', 'rub', 'ils', 'try', 'krw', 
                  'gbp', 'zar', 'rs','pula', 'aud', 
                  'egy', 'taka', 'mal', 'rub', 'brl', 
                  'idr','zwl', 'ngr', 'eutho', 'sgd',
                  'dzd','ghc','tnd', 'ksh','Kz','xaf'
            ]
					})
					.iconpicker('setIcon', '{{ substr($currencyextract['currency_symbol'],3) }}')
					.iconpicker('setSearch', false)
					.iconpicker('setFooter', true)
					.iconpicker('setHeader', true)
					.iconpicker('setSearchText', 'Type text')
					.iconpicker('setSelectedClass', 'btn-warning')
					.iconpicker('setUnselectedClass', 'btn-primary');

          $('#iconpick'+'{{ $id }}').on('change', function (e) {
            $('#iconvalue'+'{{ $id }}').val('fa ' + e.icon);
          });
			}
</script>