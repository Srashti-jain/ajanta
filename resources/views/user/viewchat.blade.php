@extends('front.layout.master')
@section('title','View Chat: '.$conversation->conv_id.' | ')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url("/css/lightbox.min.css") }}">
@endsection
@section('body')
<div class="container-fluid">

    <div class="row">
      <div class="col-xl-3 col-lg-12 col-sm-12">
        @include('user.sidebar')
      </div>
  
  
      <div class="col-xl-9 col-lg-12 col-sm-12">
  
        <div class="bg-white2">
            <p class="float-right user_m2">{{ __('View Chat : ') }}{{$conversation->conv_id}} </p>
            <h5 class="user_m2">
                @if($conversation->sender_id == auth()->id())
                    {{__("Chat with")}} {{ $conversation->reciever->name }}
                @else 
                   {{__("Chat with")}} {{ $conversation->sender->name }}
                @endif
                <br>
                <div class="text-success">
                    <small class="indicators_status"></small>
                </div>
            </h5>
          
          
          <hr>

          
            <div class="row rounded-lg shadow-sm">
             
              <!-- Chat Box-->
              <div class="col-12 px-0">
                
                <div style="max-height: 400px;overflow-y:auto;" id="chat-body" class="px-4 chat-body chat-box bg-white">

                    @forelse($conversation->chat as $chat)
                    
                        @if(auth()->id() != $chat->user_id)
                            <!-- Sender Message-->
                            <div class="media w-50 mb-3">

                                <div class="media-body ml-3">
                                <div class="bg-light rounded py-2 px-3 mb-2">
                                    @if($chat->type == 'media' )
                                        <a href="{{ url('images/conversations/'.$chat->media) }}"
                                            data-lightbox="image-1" data-title="{{ $chat->media }}">    
                                                <img src="{{ url('images/conversations/'.$chat->media)  }}" alt="{{ $chat->media }}" width="300px" class="img-fluid img-thumbnail">
                                        </a>
                                    @else
                                        <p class="text-small mb-0 text-muted">{{$chat->message}}</p>
                                    @endif
                                </div>
                                <p class="small text-muted">{{ $chat->created_at->format('d-m-Y - h:i A') }}</p>
                                </div>
                            </div>
                        @else 
                            <!-- Reciever Message-->
                            <div class="media w-50 ml-auto mb-2">
                                <div class="media-body">
                                <div class="bg-primary rounded py-2 px-3 mb-2">
                                    @if($chat->type == 'media' )
                                        <a href="{{ url('images/conversations/'.$chat->media) }}"
                                            data-lightbox="image-1" data-title="{{ $chat->media }}">    
                                                <img src="{{ url('images/conversations/'.$chat->media)  }}" alt="{{ $chat->media }}" width="300px" class="img-fluid img-thumbnail">
                                        </a>
                                    @else 
                                        <p class="text-small mb-0 text-white">{{$chat->message}}</p>
                                    @endif
                                </div>
                                <p class="small text-muted">{{ $chat->created_at->format('d-m-Y - h:i A') }}</p>
                                </div>
                            </div>
                        @endif
            
                    @empty

                        <h4 class="no_conv text-center text-muted">
                            <i class="fa fa-commenting-o"></i> {{__("Start a conversation with ")}} 
                            @if($conversation->sender_id == auth()->id())
                                {{ $conversation->reciever->name }}
                            @else 
                                {{ $conversation->sender->name }}
                            @endif
                        </h4>

                    @endforelse

                    <div class="chatscreen">
                    </div>

                </div>

                
          
                <!-- Typing area -->
                <form class="chatform w-100" enctype="multipart/form-data" id="chatform" action="javascript:void(0)">
                  <div class="input-group">
                    <input name="message" type="text" placeholder="Type a message" aria-describedby="button-addon2" class="typemessage form-control rounded-0 border-0 py-4 bg-light">
                    <input type="file" accept="image/*" name="media" class="d-none file_choose form-control">
                    <div class="input-group-append">
                      <button id="button-addonlink" type="button" class="btn btn-link"> <i class="fa fa-file-image-o"></i></button>
                      <button id="button-addon2" type="button" class="sendMessage btn btn-link"> <i class="fa fa-paper-plane"></i></button>
                    </div>
                  </div>
                </form>
          
              </div>
            </div>
            
        </div>
      </div>
  
  
    </div>
  
  </div>
@endsection
@section('script')
<script src="//js.pusher.com/7.0/pusher.min.js"></script>
<script src='{{ url('js/lightbox.min.js') }}' type='text/javascript'></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>

    "use Strict";
    
    setTimeout(() => {
        scrolldown();
    }, 1000);

    function scrolldown(){
        $('body').css('overflow','auto');
        var objDiv = document.getElementById("chat-body");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
                           
    var rec = @json($conversation->sender_id == auth()->id() ? $conversation->receiver_id : $conversation->sender_id);
    var conv_id = @json($conversation->id);
    var id = @json(auth()->id());


    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    // This will apply the debounce effect on the keyup event
    // And it only fires 500ms or half a second after the user stopped typing

    //sent event that user is stopped typing
    $('.typemessage').on('keyup', debounce(function () {

        // alert('typig close');
        
        $.ajax({
            method : 'POST',
            url  : @json(route('typing.message',$conversation->id)),
            dataType : 'json',
            data : {typing : 0, receiver_id : rec },
            success : function(response){
                
                if(response.status == 'success'){
                    console.log(response);
                }else{
                    console.log('Failed to sent indication: '+response.message);
                    return false;
                }
            }
        });

    }, 300));

    //sent event that user is stopped typing

    $('.typemessage').on('keypress',function (){
         
         $.ajax({
            method : 'POST',
            url  : @json(route('typing.message',$conversation->id)),
            dataType : 'json',
            data : {typing : 1, receiver_id : rec },
            success : function(response){
                if(response.status == 'success'){
                   console.log(response);
                }else{
                    console.log('Failed to sent indication: '+response.message);
                    return false;
                }
            }
        });

    });

    $('.sendMessage').on('click',function(){

        if($('.file_choose').val() == '' && $('.typemessage').val() == ''){
            alert('Message or media is required !');
            return false;
        }

        "use Strict";
        message();

    });

    $('.chatform').on('submit',function(){

        "use Strict";
        message();

    });

    $('#button-addonlink').on('click',function(){
        $('.file_choose').click();
    });

    $('.file_choose').on('change', function(e) {
        if (!confirm("are you sure want to sent this file "+ e.target.files[0].name+'?')) {
            e.preventDefault();
            $('.file_choose').val('');
        }else{
            message();
        }
    });

    function message(message){

        var formData =  new FormData($('#chatform')[0]);
        formData.append('rec_id',rec);

        $.ajax({
            method : 'POST',
            url  : @json(route('send.message',$conversation->id)),
            dataType : 'json',
            cache : false,
            contentType: false,
            processData: false,
            data : formData,
            success : function(response){
                if(response.status == 'success'){
                   console.log(response);
                }else{
                    alert('Failed to sent message: '+response.message);
                    return false;
                }
            }
        });

        
    }

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var secret = @json(env('PUSHER_APP_KEY'));

    var cluster = @json(env("PUSHER_APP_CLUSTER"));

    var pusher = new Pusher(secret, {
        cluster: cluster
    });

   

    var channel = pusher.subscribe('chat-message');
    var rec_msg_sound = new Audio(@json(url('admin_new/assets/sounds/note.mp3')));
    var typing_sound = new Audio(@json(url('admin_new/assets/sounds/typingsound.mp3')));

    /** If you recieve any message */

    channel.bind('conversation_'+conv_id+'_user_'+id, function (data) {

        var rec_message = data.data.message;
        var time    = data.data.time;

        $('.no_conv').html('');
        
        if(data.data.type != 'media'){
            $(".chatscreen").append('<div class="media w-50 mb-3"><div class="media-body ml-3"><div class="bg-light rounded py-2 px-3 mb-2"><p class="text-small mb-0 text-muted">'+rec_message+'</p></div><p class="small text-muted">'+time+'</p></div></div>');
        }else{

            $(".chatscreen").append('<div class="media w-50 mb-3"><div class="media-body ml-3"><div class="bg-light rounded py-2 px-3 mb-2"><a href="'+data.data.media+'" data-lightbox="image-1" data-title="image"><img src="'+data.data.media+'" width="300px" class="img-fluid img-thumbnail"></a></div><p class="small text-muted">'+time+'</p></div></div>');

        }

        scrolldown();

        rec_msg_sound.play();


    });

    /** If you send any message cross platform live sync*/

    var channel2 = pusher.subscribe('chat-msg-own');

    channel2.bind('conversation_own_'+conv_id+'_user_'+id, function (data) {

        var rec_message = data.data.message;
        var time = data.data.time;

        $('.no_conv').html('');
                    
        if(data.data.type == 'text'){

            $(".chatscreen").append('<div class="media w-50 ml-auto mb-3"><div class="media-body"><div class="bg-primary rounded py-2 px-3 mb-2"><p class="text-small mb-0 text-white">'+rec_message+'</p></div><p class="small text-muted">'+time+'</p></div></div>');

        }else{

            $(".chatscreen").append('<div class="media w-50 ml-auto mb-3"><div class="media-body"><div class="bg-primary rounded py-2 px-3 mb-2"><a href="'+data.data.media+'" data-lightbox="image-1" data-title="image"><img src="'+data.data.media+'" width="300px" class="img-fluid img-thumbnail"></a></div><p class="small text-muted">'+time+'</p></div></div>');

        }

        $('.typemessage').val('');
        $('.file_choose').val('');

        scrolldown();


    });

    /** if your reciver is typing on this converation */

    var typing_channel = pusher.subscribe('typing-channel');

    typing_channel.bind('typing-event-conv-'+conv_id+'-user-'+id, function (data) {


        $('.indicators_status').html('');

        if(data.typingstatus == true){
            typing_sound.play();
            $(".indicators_status").html('<i class="fa fa-commenting-o"></i> Typing...');
        }else{
            typing_sound.pause();
            typing_sound.currentTime = 0;
            $('.indicators_status').html('');
        }


    });


</script>
@endsection