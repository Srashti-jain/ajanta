@extends("admin/layouts.master-soyuz")
@section('title',__('Edit State | '))
@section("body")

<div class="col-xs-12">
  <!-- general form elements -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"> {{__("Edit State")}} </h2>
        <div class="panel-heading">
          <a href=" {{url('admin/state')}} " class="btn btn-success pull-right owtbtn">
            < {{ __("Back") }}</a> </div> <div class="clearfix">
        </div>
    </div>
    <div class="x_content">
      <br />

      <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/state/'.$state->id)}}"
        data-parsley-validate class="form-horizontal form-label-left">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            State Name <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="first-name" name="state" value=" {{$state->state}} "
              class="form-control col-md-7 col-xs-12">
            <p class="txt-desc">Please Enter State</p>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
            Country
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="country_id" class="form-control col-md-7 col-xs-12">

              @foreach($countrys as $country)
              <option value="{{$country->id}}">{{$country->country}}</option>
              @endforeach
            </select>
            <p class="txt-desc">Please Chooce Country</p>
          </div>
        </div>
        <div class="box-footer">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
      <button class="btn btn-default "><a href="{{url('admin/state')}}" class="links">Cancel</a></button>
    </div>
    <!-- /.box -->
  </div>

  <!-- footer content -->
  @endsection