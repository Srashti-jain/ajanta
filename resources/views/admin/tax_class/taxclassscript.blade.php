<script>
  "use strict";
   function addRow(){
    var rowCount = $('.xyz tr').length+1;

   var chck = '';
   var rate = '';
  if(rowCount == 1){
    chck = 'checked';
    rate = 1;
  }
      var n = ''
      var markup = '<tr id="count'+rowCount+'"><td><div class="form-group select2"><div class="col-md-12 col-sm-12 col-xs-12"><select name="taxRate_id" id="tax'+rowCount+'" class="form-control select2 col-md-12">@foreach(App\Tax::all() as $tax)<option value="{{$tax->id}}">{{$tax->name}}</option>@endforeach</select></div></div></td><td><div class="form-group"><div class="col-md-12 col-sm-12 col-xs-12 select2"><select name="based_on" id="based_on'+rowCount+'" class="form-control col-md-12" ><option value="0">{{ __("Please Choose") }}</option><option value="billing">{{ __("Billing Address") }}</option><option value="store">{{ __("Store Address") }}</option></select></div></div></td> <td><div class="form-group"><div class="col-md-12 col-sm-12 col-xs-12"><input type="text" id="priority'+rowCount+'" name="priority" class="form-control col-md-7 col-xs-12"></div></div></td><td><a onclick="removeRow(\'count'+rowCount+'\')" class="btn btn-danger owtbtn" ><i class="fa fa-minus-circle"></i></a></td></tr>';
      $(".xyz").append(markup);
         
  }
</script>