@extends('admin.layouts.master-soyuz')
@section('title',__('Invoice Design | '))
@section('body')

@component('admin.component.breadcumb',['secondaryactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Invoice Design") }}
@endslot


@endcomponent

<div class="contentbar">
    <div class="row">

        <div class="col-lg-8">
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
                    <h5 class="card-title">{{ __('Invoice Design') }}</h5>
                </div>
                <div class="card-body">
                   
                       <form action="{{ route("update.invoice.design") }}" method="POST">
                           @csrf

                           <div class="form-group">
                                <label>{{__("Show Logo in invoice")}} :</label>
                                <br>
                                <label class="switch">
                                <input {{ isset($design) && $design->show_logo == 1 ? "checked" : "" }} id="show_logo" type="checkbox" name="show_logo"/>
                                <span class="knob"></span>
                                </label>
                          </div>

                          <div class="form-group">
                            <label>{{__("Show QR in invoice")}} :</label>
                            <br>
                            <label class="switch">
                            <input {{ isset($design) && $design->show_qr == 1 ? "checked" : "" }} id="show_qr" type="checkbox" name="show_qr"/>
                            <span class="knob"></span>
                            </label>
                          </div>

                          <div class="form-group">
                            <label>{{__("Show VAT NO. in invoice")}} :</label>
                            <br>
                            <label class="switch">
                            <input {{ isset($design) && $design->show_vat == 1 ? "checked" : "" }} id="show_vat" type="checkbox" name="show_vat"/>
                            <span class="knob"></span>
                            </label>
                          </div>

                          <div class="form-group">
                            <label>{{__("Print default in Landscape mode")}} :</label>
                            <br>
                            <label class="switch">
                            <input {{ isset($design) && $design->print_mode != 'portrait' ? "checked" : "" }} id="print_mode" type="checkbox" name="print_mode"/>
                            <span class="knob"></span>
                            </label>
                          </div>

                          <div class="form-row">
                            <div class="col-4 form-group">
                                <label>
                                    {{__("Border Radius:")}}
                                </label>
                                <div class="input-group">
                                   <input value="{{ isset($design) && $design->border_radius ? $design->border_radius : 0 }}" class="form-control" type="number" min="0" name="border_radius">
                                    <div class="input-group-text">
                                        {{__("px")}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 form-group">
                                <label>
                                    {{__("Border Color:")}}
                                </label>
                                <div class="input-group initial-color" title="Choose border color">
                                    <input value="{{ isset($design) && $design->border_color ? $design->border_color : 0 }}" type="text" class="form-control input-lg" name="border_color" placeholder="#000000" value="#000000"/>
                                    <span class="input-group-append">
                                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-4 form-group">
                                <label>
                                    {{__("Border Style:")}}
                                </label>
                                <select name="border_style" class="select2 form-control" id="">
                                    <option value="">{{ __("Choose border style") }}</option>
                                    <option {{ isset($design) && $design->border_style == 'dashed' ? 'selected' : "" }} value="dashed">Dashed</option>
                                    <option {{ isset($design) && $design->border_style == 'solid' ? 'selected' : "" }} value="solid">Solid</option>
                                </select>
                            </div>

                            <div class="col-6 form-group">
                                <label>
                                    {{__("Invoice date format:")}}
                                </label>
                                <select name="date_format" class="select2 form-control" id="">
                                    <option value="">{{ __("Choose date format") }}</option>
                                    <option {{ isset($design) && $design->date_format == 'Y-m-d' ? 'selected' : "" }} value="Y-m-d">Y-m-d</option>
                                    <option {{ isset($design) && $design->date_format == 'd-m-Y' ? 'selected' : "" }} value="d-m-Y">d-m-Y</option>
                                    <option {{ isset($design) && $design->date_format == 'd/m/Y' ? 'selected' : "" }} value="d/m/Y">d/m/Y</option>
                                    <option {{ isset($design) && $design->date_format == 'd M, Y' ? 'selected' : "" }} value="d M, Y">d M, Y</option>
                                    <option {{ isset($design) && $design->date_format == 'jS M Y' ? 'selected' : "" }} value="jS M Y">jS M Y</option>
                                </select>
                            </div>

                          </div>

                          <div class="form-group col-12">
                            <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled
                                title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-danger-rgba"><i
                                    class="fa fa-ban"></i> {{ __("Reset") }}</button>
                            <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-primary-rgba"><i
                                    class="fa fa-check-circle"></i>
                                {{ __("Update") }}</button>
                        </div>

                       </form>


                </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection