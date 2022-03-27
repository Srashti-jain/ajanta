@extends('admin.layouts.master-soyuz')
@section('title',__('Create Flashdeal | '))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Flashdeals') }}
@endslot

@slot('menu1')
{{ __('Flashdeals') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a href=" {{ route('flash-sales.index') }} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
        </a>
    </div>
</div>

@endslot
@endcomponent

<div class="contentbar">
    <div class="row">
        <div class="col-md-12 mb-3">

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
                    <h3 class="card-title">
                        {{__("Create new flash deal")}}
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('flash-sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">

                            <label for="">{{ __("Title:") }} <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" class="required" name="title"
                                placeholder="{{ __('Halloween Sale') }}" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("Background image:") }} <span class="text-danger">*</span> </label>
                            <div class="input-group ">
                                
                                <div class="custom-file">

                                    <input required type="file" name="background_image" class="custom-file-input"
                                        id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{__('Choose background image')}} (2000x2000)</label>

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("Start date:") }} <span class="text-danger">*</span> </label>
                            <input required value="{{ old('start_date') ?? now()->addDays(1)->format('Y-m-d h:i a') }}"
                                type="text" class="timepickerwithdate form-control" class="required"
                                name="start_date" />
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("End date:") }} <span class="text-danger">*</span> </label>
                            <input required value="{{ old('end_date') ?? now()->addDays(7)->format('Y-m-d h:i a') }}"
                                type="text" class="timepickerwithdate form-control" class="required" name="end_date" />
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("Detail:") }}</label>
                            <textarea name="detail" id="editor1" cols="30" rows="10">{{ old("detail") }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{__("Status")}} :</label>
                            <br>
                            <label class="switch">
                                <input id="status" type="checkbox" name="status" {{ old('status') ? "checked" : "" }}>
                                <span class="knob"></span>
                            </label>
                        </div>

                        <h4>{{ __('Select Products') }}</h4>

                        <table class="productlist table table-bordered table-hover">
                            <thead>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __("Discount type") }}</th>
                                <th>
                                    {{ __('#') }}
                                </th>
                            </thead>

                            <tbody>

                                @if(!old('product'))

                                    <tr>
                                        <td>
                                            <input type="text" class="product form-control" placeholder="Search product"
                                                required name="product[]">
                                            <input type="hidden" class="form-control product_type" name="type[]">
                                            <input type="hidden" class="form-control product_ids" name="product_id[]">
                                        </td>
                                        <td>
                                            <div class="input-group">

                                                <input type="number" min="1" class="form-control" placeholder="50" required
                                                    name="discount[]">
                                                <span class="input-group-text">
                                                    %
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                    <option value="">{{ __('Select discount type') }}</option>
                                                    <option value="fixed">{{ __('Fixed') }}</option>
                                                    <option value="upto">{{ __('Upto') }}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                <i class="feather icon-plus"></i>
                                            </button>
                                            <button type="button" class="removeBtn btn-danger-rgba btn-sm">
                                                <i class="feather icon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>


                                @else 

                                    @foreach(old('product') as $key => $product)
                                    
                                        <tr>
                                            <td>
                                                <input type="text" class="product form-control" placeholder="Search product"
                                                    required name="product[]" value="{{ $product ?? '' }}">
                                                <input value="{{ old('type')[$key] }}" type="hidden" class="form-control product_type" name="type[]">
                                                <input type="hidden" value="{{ old('product_id')[$key] }}" class="form-control product_ids" name="product_id[]">
                                            </td>
                                            <td>
                                                <div class="input-group">

                                                    <input value="{{ old('discount')[$key] }}" type="number" min="1" class="form-control" placeholder="50" required
                                                        name="discount[]">
                                                    <span class="input-group-text">
                                                        %
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                        <option value="">{{ __('Select discount type') }}</option>
                                                        <option {{ old('discount_type')[$key] == 'fixed' ? "selected" : "" }} value="fixed">Fixed</option>
                                                        <option {{ old('discount_type')[$key] == 'upto' ? "selected" : "" }} value="upto">Upto</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                                <button type="button" class="removeBtn btn-danger-rgba btn-sm">
                                                    <i class="feather icon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                
                                    @endforeach

                                @endif
                            </tbody>
                        </table>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success-rgba">
                                <i class="feather icon-plus"></i> {{__("Create")}}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-script')
<script>
    function enableAutoComplete($element) {



        $element.autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: @json(url('/admin/search/products')),
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function (data) {

                        var resp = $.map(data, function (obj) {
                            return {
                                type: obj.product_type,
                                label: obj.label,
                                value: obj.value,
                                id: obj.id,
                            }
                        });

                        response(resp);
                    }
                });
            },
            select: function (event, ui) {

                if (ui.item.value != 'No result found') {
                    this.value = ui.item.value.replace(/\D/g, '');
                    $(this).closest('td').find('input.product_type').val(ui.item.type);
                    $(this).closest('td').find('input.product_ids').val(ui.item.id);
                } else {
                    $(this).val('');
                    $(this).closest('td').find('input.product_type').val('');
                    $(this).closest('td').find('input.product_ids').val('');
                    return false;
                }

            },
            minlength: 1,

        });
    }

    $(document).ready(function () {
        $(".product").each(function (index) {
            enableAutoComplete($(this));
        });
    });

    $(".productlist").on('click', 'button.addnew', function () {

        var n = $(this).closest('tr');
        addNewRow(n);


        function addNewRow(n) {

            // e.preventDefault();

            var $tr = n;
            var allTrs = $tr.closest('table').find('tr');
            var lastTr = allTrs[allTrs.length - 1];
            var $clone = $(lastTr).clone();
            $clone.find('td').each(function () {
                var el = $(this).find(':first-child');
                var id = el.attr('id') || null;
                if (id) {

                    var i = id.substr(id.length - 1);
                    var prefix = id.substr(0, (id.length - 1));
                    el.attr('id', prefix + (+i + 1));
                    el.attr('name', prefix + (+i + 1));
                }
            });

            $clone.find('input').val('');

            $tr.closest('table').append($clone);

            $('input.product').last().focus();

            enableAutoComplete($("input.product:last"));
        }

    });

    $('.productlist').on('click', '.removeBtn', function () {

        var d = $(this);
        removeRow(d);

    });

    function removeRow(d) {
        var rowCount = $('.productlist tr').length;
        if (rowCount !== 2) {
            d.closest('tr').remove();
        } else {
            console.log('Atleast one sell is required');
        }
    }
</script>
@endsection