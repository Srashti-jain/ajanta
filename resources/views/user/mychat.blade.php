@extends('front.layout.master')
@section('title','My Chats | ')
@section('body')
<div class="container-fluid">

    <div class="row">
      <div class="col-xl-3 col-lg-12 col-sm-12">
        @include('user.sidebar')
      </div>
  
  
      <div class="col-xl-9 col-lg-12 col-sm-12">
  
        <div class="bg-white2">
          <h5 class="user_m2">My Chats ({{$conversations->count()}}) </h5>
          <hr>
            
          @forelse($conversations as $chat)
            <div class="shadow-sm card">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <p class="font-weight-bold">{{ __("Conversation ID") }}</p>
                            <a href="{{ route('user.chat.view',$chat->conv_id) }}">{{ $chat->conv_id }}</a>
                        </div>

                        <div class="col-md-4">
                            <p class="font-weight-bold">{{ __("Conversation with") }}</p>
                            <span>{{ $chat->sender->name }}</span>
                        </div>

                        <div class="col-md-4">
                            <p class="font-weight-bold">{{ __("Last Message") }}</p>
                            <span> <b>{{ $chat->chat->last()->message  }}</b> {{ __('from') }} {{ $chat->chat->last()->user->name }} - {{ $chat->chat->last()->created_at->format('jS M Y - h:i A') }} </span>
                        </div>
                    </div>
                    
                </div>
            </div>
          @empty
          @endforelse 
         
  
        </div>
      </div>
  
  
    </div>
  
  </div>
@endsection