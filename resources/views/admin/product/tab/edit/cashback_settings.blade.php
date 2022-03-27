<h5>{{ __("Cashback Settings") }}</h5>
<hr>
<form action="{{ route("cashback.save",$products->id) }}" method="POST">
    @csrf
    <input type="hidden" name="product_type" value="variant_product">
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label class="text-dark">
                    {{__("Enable Cashback system :")}}
                </label>
                <br>
                <label class="switch">
                  <input id="enable" type="checkbox" name="enable"
                    {{ isset($cashback_settings) && $cashback_settings->enable =='1' ? "checked" : "" }}>
                  <span class="knob"></span>
                </label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="text-dark" for="cashback_type">{{ __("Select cashback type:") }} <span class="text-danger">*</span> </label>
                <select data-placeholder="{{ __("Select cashback type") }}" name="cashback_type" class="form-control select2">
                    <option value="">{{ __("Select cashback type") }}</option>
                    <option {{ isset($cashback_settings) && $cashback_settings->cashback_type == 'fix' ? "selected" : "" }} value="fix">{{ __("Fix") }}</option>
                    <option {{ isset($cashback_settings) && $cashback_settings->cashback_type == 'per' ? "selected" : "" }} value="per">{{ __("Percent") }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="text-dark" for="discount_type">{{ __("Discount type:") }} <span class="text-danger">*</span> </label>
                <select data-placeholder="{{ __("Select discount type") }}" name="discount_type" class="form-control select2">
                    <option value="">{{ __("Select cashback type") }}</option>
                    <option {{ isset($cashback_settings) && $cashback_settings->discount_type == 'flat' ? "selected" : "" }} value="flat">{{ __("Flat") }}</option>
                    <option {{ isset($cashback_settings) && $cashback_settings->discount_type == 'upto' ? "selected" : "" }} value="upto">{{ __("Upto") }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="text-dark"for="discount">{{ __("Discount:") }} <span class="text-danger">*</span> </label>
                <input value="{{ isset($cashback_settings) ? $cashback_settings->discount : 0 }}" step="0.001" type="number" min="0" class="form-control" required name="discount">
            </div>
        </div>

        <div class="col-md-12">
        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {{ __("Save")}}</button>
        </div>

    </div>

</form>