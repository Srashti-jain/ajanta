  <div class="panel-heading">
    <a data-toggle="modal" data-target="#addFAQ" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> {{ __('Add FAQ') }}</a>

  </div>
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>{{ __('Product Name') }}</th>
        <th>{{ __('Question') }}</th>
        <th>{{ __('Answer') }}</th>
        <th>{{ __('Action') }}</th>
      </tr>
    </thead>
    <tbody>

      @foreach($faqs as $key => $f)

      <tr>
        <td>{{$key+1}}</td>
        <td>{{$f->product['name']}}</td>
        <td>{{ $f->question }}</td>
        <td>{!! $f->answer !!}</td>
        <td>
          <div class="dropdown">
            <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                class="feather icon-more-vertical-"></i></button>
            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
              <a class="dropdown-item" title="{{ __('Edit FAQ') }}" data-toggle="modal" data-target="#editfaq{{ $f->id }}"><i
                  class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
              <a class="dropdown-item" data-toggle="modal" data-target="#faqdel{{ $f->id }}"><i
                  class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>

            </div>
          </div>
        </td>

      </tr>
      @endforeach

    </tbody>
  </table>





  @foreach($faqs as $key => $f)
  <div class="modal fade" id="faqdel{{ $f->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
          <p>{{__("Do you really want to delete this faq? This process cannot be undone")}}.</p>
        </div>
        <div class="modal-footer">
          <form method="post" action="{{url('admin/product_faq/'.$f->id)}}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">
              {{__("No")}}
            </button>
            <button type="submit" class="btn btn-danger">
              {{__("Yes")}}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  @foreach($faqs as $key => $f)
  <!-- EDIT FAQ Modal -->
  <div class="modal fade" id="editfaq{{ $f->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Edit FAQ') }}: {{ $f->question }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="demo-form2" method="post" action="{{route('product_faq.update',$f->id)}}">
            {{ method_field("PUT") }}
            @csrf
            <div class="form-group">
              <label for="">{{__("Question")}}: <span class="required">*</span></label>
              <input required="" type="text" name="question" value="{{ $f->question }}" class="form-control">
            </div>

            <div class="form-group">
              <label for="">{{__("Answer")}}: <span class="required">*</span></label>
              <textarea required="" cols="10" id="editor1" name="answer" rows="5"
                class="form-control editor1">{{ $f->answer }}</textarea>
              <input type="hidden" readonly name="pro_id" value="{{ $products->id }}">
              <small class="text-muted"><i class="fa fa-question-circle"></i>
                {{__('Please enter answer for above question !')}} </small>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
              {{ __("Create")}}</button>


          </form>
        </div>

      </div>
    </div>
  </div>
  @endforeach

  <!-- Create FAQ Modal -->
  <div class="modal fade" id="addFAQ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">{{ __('Add FAQ') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">
          <form id="demo-form2" method="post" action="{{url('admin/product_faq')}}">
            @csrf
            <div class="form-group">
              <label for="">Question: <span class="required">*</span></label>
              <input type="text" name="question" value="{{old('question')}}" class="form-control">
              <small class="text-muted"><i class="fa fa-question-circle"></i>{{ __('Please write question !') }}</small>
            </div>

            <div class="form-group">
              <label for="">Answer: <span class="required">*</span></label>
              <textarea cols="10" id="editor1" name="answer" rows="5" class="form-control">{{old('answer')}}</textarea>
              <input type="hidden" readonly name="pro_id" value="{{ $products->id }}">
              <small class="text-muted"><i
                  class="fa fa-question-circle"></i>{{ __('Please enter answer for above question !') }}</small>
            </div>

            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
              {{ __("Create")}}</button>


          </form>
        </div>

      </div>
    </div>
  </div>