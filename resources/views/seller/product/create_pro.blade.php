@extends('admin.layouts.sellermastersoyuz')

@section('title',__(":product -",['product' => $products->name]))
@section('body')
<div class="box">
    <div class="box-header">
        <h3>{{$products->name ?? 'Product'}}</h3>
    </div>
    <div class="box-body">

        <ul class="nav nav-tabs" role="tablist" id="myTab">
            <li role="presentation" class="active"><a href="#lis" aria-controls="home" role="tab"
                    data-toggle="tab">{{ __('Product') }}</a></li>


            <li role="presentation"><a href="#tags" aria-controls="messages" role="tab" data-toggle="tab">{{ __('FAQ\'s') }}</a></li>

            <li role="presentation"><a href="#rel" aria-controls="messages" role="tab" data-toggle="tab">
                {{__('Related')}}
            </a>
            </li>



        </ul>


        <div class="tab-content">


            <div role="tabpanel" class="tab-pane fade in active" id="lis">
                <div class="col-md-8">
                    @include('admin/product/tab.product')
                </div>
            </div>


            <div role="tabpanel" class="fade tab-pane" id="tags">
                @include('admin/product/tab.faq')
            </div>

            <div role="tabpanel" class="fade tab-pane" id="rel">
                @include('admin/product/tab.edit.show_related')
            </div>


        </div>


    </div>
</div>
<!-- Nav tabs -->
@endsection