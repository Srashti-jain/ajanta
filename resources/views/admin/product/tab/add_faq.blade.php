<form id="demo-form2" method="post" action="{{url('admin/product_faq')}}" data-parsley-validate
  class="form-horizontal form-label-left" enctype="multipart/form-data">
  {{ csrf_field() }}


  <br>
  <label for="exampleInputSlug">{{ __("Question:") }}</label>
  <input type="text" id="first-name" name="question" value="{{old('question')}}"
    class="form-control col-md-7 col-xs-12">
  <p class="txt-desc">{{ __("Please Enter Question") }}</p>

  <br>
  <label for="exampleInputSlug">{{ __("Answer :") }}</label>
  <input type="text" id="first-name" name="answer" value="{{old('answer')}}" class="form-control col-md-7 col-xs-12">
  <input type="textarea" name="pro_id" value="{{session()->get('last_id')['id']}}">
  <p class="txt-desc">{{ __("Please Enter Answer") }}</p>
  <br>
  <div class="box-footer">
    <button type="submit" class="btn btn-primary">
      {{__("Submit")}}
    </button>
  </div>
</form>