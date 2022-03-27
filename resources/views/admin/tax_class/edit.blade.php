@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Tax Classes | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Edit Tax Classes') }}
@endslot
@slot('menu1')
{{ __('Tax Classes') }}
@endslot
@slot('menu2')
{{ __('Edit Tax Classes') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{url('admin/tax_class')}}" class="btn btn-primary-rgba"><i
        class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title"> {{__("Edit Tax Classes")}}</h5>
        </div>
        <div class="card-body">
          <h4>
            {{__('Tax Class :')}}
          </h4>
          <form class="form-horizontal form-label-left" method="post">
            {{csrf_field()}}
            <div class="row">
              <div class="form-group col-md-6">
                <label>
                  {{__('Tax Class Title')}} <span class="required">*</span>
                </label>

                <input placeholder="{{ __("Please enter Tax class") }}" value="{{$tax->title}}" type="text" name="title"
                  id="titles" class="form-control">

              </div>
              <div class="form-group col-md-6">
                <label>
                  Description <span class="required">*</span>
                </label>

                <input placeholder="{{ __("Please enter Tax class") }}" value="{{$tax->des}}" type="text" name="des"
                  id="des" class="form-control">


              </div>
            </div>



            <fieldset>
              <h4>{{__("Tax Rates :")}} </h4>
              <table id="full_detail_tables" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr class="table-heading-row">
                    <th>{{__("Tax Rate")}} <span type="button" class="text-danger i-iconsize" data-toggle="tooltip"
                        data-placement="top"
                        title="{{ __("You Want to Choose Tax Class Then Apply same Tax Class And Tax Rate .") }}">
                        <i class="feather icon-alert-circle"></i>
                      </span>
                    </th>



                    <th>{{__("Based On")}}
                      <span type="button" class="text-danger i-iconsize" data-toggle="tooltip" data-placement="top"
                        title="{{ __("You want to choose billing address then billing address and zone address are same then tax will be applied, And if you choose store sddress then if Store Addrss And User Billing Address Is Same Then Tax Will Be Apply  .") }}">
                        <i class="feather icon-alert-circle"></i>
                      </span>
                    </th>


                    <th> {{__("Priority")}}
                      <span type="button" class="text-danger i-iconsize" data-toggle="tooltip" data-placement="top"
                        title="{{ __("1 Priority Is Higher Priority And All Numeric Number Is Lowest Priority. Priority Are Accept in Numeric Number ONLY.") }}">
                        <i class="feather icon-alert-circle"></i>
                      </span>
                    </th>
                  </tr>
                </thead>
                <tbody class="xyz">
                  <?php $counter=1;
                    ?>


                  @if(isset($tax->priority))
                  @foreach($tax->priority as $k=> $t)


                  <tr id="count{{$counter}}">
                    <td>

                      <div class="form-group">
                        <div class="col-12">
                          <select name="taxRate_id" id="tax{{$counter}}" class="form-control select2">
                            @foreach(App\Tax::all() as $taxs)
                            <option value="{{$taxs->id}}"
                              {{ $taxs->id == $tax->taxRate_id[$t] ? 'selected="selected"' : '' }}>{{$taxs->name}}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </td>


                    <td>



                      <div class="form-group">
                        <div class="col-md-12">
                          <select name="based_on" id="based_on{{$counter}}" class="form-control select2">

                            <option value="0">{{ __("Please Choose") }}</option>
                            <option value="billing" {{ $tax->based_on[$t] =='billing' ? 'selected="selected"' : '' }}>
                              Billing Address</option>
                            <option value="store" {{ $tax->based_on[$t] =='store' ? 'selected="selected"' : '' }}>Store
                              Address</option>

                          </select>
                        </div>
                      </div>

                    </td>
                    <input type="hidden" id="ids" value="{{$tax->id}}">
                    <td>
                      <div class="form-group">
                        <div class="col--12">
                          <input type="text" id="priority{{$counter}}" value="{{$t}}" name="priority"
                            class="form-control">
                        </div>

                      </div>
                    </td>
                    <td>
                      <a onclick="removeRow('count{{$counter}}')" class="btn btn-danger owtbtn"><i
                          class="fa fa-minus-circle"></i></a>
                    </td>
                  </tr>
                  <?php $counter++;?>

                  @endforeach
                  @endif

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td class="text-left"><button type="button" onclick="addRow();" data-toggle="tooltip" title=""
                        class="btn btn-primary" data-original-title="{{ __("Add Rule") }}"><i
                          class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>




            </fieldset>
            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <a onclick="UpdateFormData();" class="btn btn-primary">
              <i class="fa fa-check-circle mr-2"></i> {{__("Update")}}
            </a>
            <div id="msg"></div>
          </form>
          <!-- /.box -->
        </div>
      </div>
    </div>
    <!-- End col -->
  </div>




  @endsection

  @section('custom-script')
  <script>
    var baseUrl = "<?= url('/') ?>";
  </script>
  <script src="{{ url('js/taxclass.js') }}"></script>
  @include('admin.tax_class.taxclassscript')
  <script>
    var taxid = @json($tax->id);
    var urllike = @json(url('admin/taxclassUpdate'));
    var redirecturl = @json(route('tax_class.index'));
  </script>
  <script src="{{url('js/edittaxclass.js')}}"></script>
  @endsection