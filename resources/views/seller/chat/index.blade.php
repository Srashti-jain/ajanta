@extends('admin.layouts.sellermastersoyuz')
@section('title',__('My Chats'))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
  @slot('heading')
    {{ __('My Chats') }}
  @endslot

  @slot('menu2')
    {{ __("My Chats") }}
  @endslot

@endcomponent

  <div class="contentbar">
    <div class="row">
      
      <div class="col-lg-12">

        @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <p>
                    {{ $error}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </p>
            @endforeach
          </div>
        @endif

        <div class="card m-b-30">
          <div class="card-header">
            <h5 class="card-title">
                <i class="feather icon-message-circle"></i>
                {{ __('My Chats') }} ({{$conversations->count()}})
            </h5>

          </div>

          <div class="card-body">

            <div class="row">
                <div class="col-md-8">
                    @forelse($conversations as $chat)
                   
                        <div class="shadow-sm card mb-3 border">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="font-weight-bold">{{ __("Conversation ID") }}</p>
                                        <a href="{{ route('chat.screen',$chat->conv_id) }}">{{ $chat->conv_id }}</a>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="font-weight-bold">{{ __("Conversation with") }}</p>
                                        <span>{{ $chat->sender_id == auth()->id() ? $chat->reciever->name : $chat->sender->name }}</span>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="font-weight-bold">{{ __("Last Message") }}</p>
                                        <span> <b>{{ !empty( $chat->chat->last() ) ? $chat->chat->last()->message : "No "  }}</b> {{ __('from') }} {{ !empty( $chat->chat->last() ) ? $chat->chat->last()->user->name : '' }} - {{ !empty( $chat->chat->last() ) ? $chat->chat->last()->created_at->format('jS M Y - h:i A') : '' }} </span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    @empty

                        <h4 class="no_conv text-center text-muted">
                            <i class="feather icon-message-circle"></i> {{__("Start a new conversation")}}
                        </h4>

                    @endforelse
                </div>
                <div class="col-md-4">

                    <div class="chat-list">
                        <div class="chat-search">
                            <form>
                                <div class="input-group">
                                  <input type="search" name="user" class="form-control" placeholder="{{ __('Search') }}" aria-label="Search" aria-describedby="button-addon3">
                                  <div class="input-group-append">
                                    <button class="btn" type="submit" id="button-addon3"><i class="feather icon-search"></i></button>
                                  </div>
                                </div>
                            </form>
                        </div>
                        <div style="max-height: 300px;overflow:auto;" class="chat-user-list">
                            <ul class="list-unstyled mb-0">
                                
                                @foreach($users as $user)
                                    <a href="{{ route('chat.start',$user->id) }}">
                                      <li class="media">
                                        @if($user->image != '' && file_exists(public_path().'/images/user/'.$user->image))
                                            <img class="align-self-center rounded-circle" src="{{ url('images/user/'.$user->image) }}"/>
                                        @else 
                                            <img class="align-self-center rounded-circle" src="{{ Avatar::create($user->name)->toBase64() }}"/>
                                        @endif
                                        <div class="media-body">
                                            <h5>{{ $user->name }}</h5>
                                            <p>Admin</p>
                                        </div>
                                    </li>
                                    </a>
                                @endforeach
                                
                            </ul>
                            
                        </div>
                        {!! $users->links() !!}
                    </div>

                </div>
            </div>
             
          </div>

        </div>
      </div>
    </div>
  </div>

  @endsection