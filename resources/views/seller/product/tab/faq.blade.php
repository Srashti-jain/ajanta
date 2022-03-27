  <div class="panel-heading">
    <a href=" {{url('admin/product_faq/create')}} " class="btn btn-success owtbtn">+ {{ __('Add FAQ') }}</a>
  </div>
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>{{ __("S.No") }}</th>
        <th>{{ __('Product Name') }}</th>
        <th>{{ __('Question') }}</th>
        <th>{{ __('Answer') }}</th>
        <th>{{ __('Action') }}</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;?>
      @if(!empty($faqs))
      @foreach($faqs as $brand)

      <tr>
        <td>{{$i++}}</td>
        <td>{{$brand->product['name']}}</td>
        <td>{{$brand->question}}</td>
        <td>{!!$brand->answer!!}</td>
        <td>

          <form method="post" action="{{url('admin/product_faq/'.$brand->id)}}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
            <button class="btn btn-danger abc">Delete</button>
          </form>

        </td>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>