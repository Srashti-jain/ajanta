@extends("front.layout.master")
@section('title', __("All deals"))
@section('meta_tags')
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta property="og:title" content="{{ __("All deals") }}" />
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{ url()->full() }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ url()->full() }}" />
@endsection
@section("body")
    <div class="breadcrumb">
        <div class="container-fluid">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
            <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li><a href="{{ url()->full() }}">{{ __("Flash deals") }}</a></li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    
    <div class="body-content outer-top-xs outer-top-xs-one detail-page-block">
        <div class='container'>
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row">

                    
                        @forelse($deals as $deal)

                            <div style="width: 300px;" class="mx-auto mt-2 col-lg-3 col-sm-12">
                                <div class="shadow-sm card" style="width: 18rem;">
                                    <img src="{{ url('images/flashdeals/'.$deal->background_image) }}" class="card-img-top" alt="{{ $deal->background_image }}">
                                    <div class="card-body">
                                      <h5 class="card-title">{{ $deal->title }}</h5>
                                      <hr>
                                      <p class="card-text font-weight-normal">
                                          {{__("Sale Start Date:")}} {{ date('d-m-Y @ h:i A',strtotime($deal->start_date)) }}
                                      </p>
                                      <p class="card-text font-weight-normal">
                                        {{__("Sale End Date:")}} {{ date('d-m-Y @ h:i A',strtotime($deal->end_date)) }}
                                      </p>
                                      <a href="{{ route('flashdeals.view',['id' => $deal->id, 'slug' => str_slug($deal->title,'-')]) }}" class="btn btn-outline-primary">
                                          {{__("View Deal")}}
                                      </a>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="col-md-12">
                                <h4 class="text-center">{{ __("No deals") }}</h4>
                            </div>
                        @endforelse

                        
                    </div>

                    <div class="mt-2 mx-auto" style="width: 200px;" >
                        {!! $deals->links() !!}
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

@endsection