@extends('admin.layouts.master-soyuz')
@section('title',__('Chat with :user',['user' => $reciever->name]))
@section('stylesheet')
    <link rel="stylesheet" href="{{ url("/css/lightbox.min.css") }}">
@endsection
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])

  @slot('heading')
    {{ __('Chat') }}
  @endslot

  @slot('menu2')
    {{ __("Chat for order") }}
  @endslot

@endcomponent

<div class="contentbar">
	<div class="row">
		<div class="col-md-12 m-b-30">
			<div class="card">
				<div class="card-header">
					<a title="Back" href="{{ url()->previous() }}" class="ml-2 float-right btn btn-md btn-primary-rgba">
						<i class="feather icon-arrow-left" aria-hidden="true"></i> {{ __("Back") }}
					</a>
                    <div class="card-title">
                        <span class="text-dark">{{ __('Chat with :user',['user' => $reciever->name]) }}</b> </span>
                    </div>
				</div>

				<div class="card-body">
                    <div class="row">
                        
                        <!-- Start col -->                       
                        <div class="col-lg-12 col-xl-12">       
                            <div class="chat-detail">
                                <div class="chat-head">
                                    <ul class="list-unstyled mb-0">
                                        <li class="media">

                                            @if($reciever->image != '' &&
                                            file_exists(public_path().'/images/user/'.$reciever->image))
                                            <img width="50px" src="{{url('images/user/'.$reciever->image)}}" alt="profilephoto" class="img-fluid align-self-center mr-3 rounded-circle">
                                            @else
                                            <img width="50px" src="{{ Avatar::create($reciever->name)->toBase64() }}" alt="profilephoto" class="img-fluid align-self-center mr-3 rounded-circle">
                                            @endif
                                            <div class="media-body">
                                                <h5 class="font-18">
                                                    {{ $reciever->name }}
                                                </h5>
                                                <p class="indicators_status"></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div style="max-height: 300px;overflow-y : scroll;" id="chat-body" class="chat-body">
                                    @forelse($conversation->chat as $chat)
                                        
                                       
                                            <div class="chat-message {{ $chat->user_id == auth()->id() ? "chat-message-right" : "chat-message-left" }}">
                                                <div class="chat-message-text">
                                                    @if($chat->type == 'media')
                                                        <a href="{{ url('images/conversations/'.$chat->media) }}"
                                                        data-lightbox="image-1" data-title="{{ $chat->media }}">    
                                                            <img src="{{ url('images/conversations/'.$chat->media)  }}" alt="{{ $chat->media }}" width="300px" class="img-fluid img-thumbnail">
                                                        </a>
                                                    @else 
                                                        <span>
                                                            {{$chat->message}}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="chat-message-meta">
                                                    <small>{{ $chat->created_at->format('d-m-Y - h:i A') }}<i class="feather icon-check ml-2"></i></small>
                                                </div>
                                            </div>
                                       

                                    @empty 

                                        <h4 class="no_conv text-center text-muted">
                                            <i class="feather icon-message-circle"></i> {{__("Start a conversation with ")}} {{ $reciever->name }}
                                        </h4>

                                    @endforelse
                                    <div class="chatscreen">
                                    </div>
                                </div>
                                <div class="chat-bottom">
                                    <div class="chat-messagebar">
                                        <form class="chatform" id="chatform" action="javascript:void(0)" enctype="multipart/form-data">

                                            <div class="input-group">
                                                <input required autofocus type="text" name="message" class="typemessage form-control" placeholder="Type a message..." aria-label="Text">
                                                <div class="input-group-append">
                                                    <input accept="image/*" type="file" name="media" class="d-none file_choose form-control">
                                                    <button class="btn btn-round btn-secondary-rgba" type="button" id="button-addonlink"><i class="feather icon-image"></i></button>
                                                    <button class="sendMessage btn btn-round btn-primary-rgba" type="button" id="button-addonsend"><i class="feather icon-send"></i></button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
@section('custom-script')
<script>
	var baseUrl = @json(url('/'));
</script>
<script src="{{ url('js/order.js') }}"></script>
<script src='{{ url('js/lightbox.min.js') }}'></script>
<script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    setTimeout(() => {
        scrolldown();
    }, 1000);

    function scrolldown(){
        $('body').css('overflow','auto');
        var objDiv = document.getElementById("chat-body");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    var rec_msg_sound = new Audio(@json(url('admin_new/assets/sounds/note.mp3')));
    var typing_sound = new Audio(@json(url('admin_new/assets/sounds/typingsound.mp3')));
    var rec = @json($conversation->sender_id == auth()->id() ? $conversation->receiver_id : $conversation->sender_id);
    console.log(rec);
    var conv_id = @json($conversation->id);
    var id = @json(auth()->id());

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

    function message(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData =  new FormData($('#chatform')[0]);

        formData.append('rec_id',rec);

        $.ajax({
            method : 'POST',
            url  : @json(route('send.message',$conversation->id)),
            dataType : 'json',
            data : formData,
            cache : false,
            contentType: false,
            processData: false,
            success : function(response){

                if(response.status == 'success'){


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


    /** if you recieve some message */

    var channel = pusher.subscribe('chat-message');

    

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
                    
                }else{
                    console.log('Failed to sent indication: '+response.message);
                    return false;
                }
            }
        });

    }, 500));

    //sent event that user is stopped typing

    $('.typemessage').on('keypress',function (){
         
         $.ajax({
            method : 'POST',
            url  : @json(route('typing.message',$conversation->id)),
            dataType : 'json',
            data : {typing : 1, receiver_id : rec },
            success : function(response){
                if(response.status == 'success'){
                  
                }else{
                    console.log('Failed to sent indication: '+response.message);
                    return false;
                }
            }
        });

    });

    channel.bind('conversation_'+conv_id+'_user_'+id, function (data) {

        var rec_message = data.data.message;
        var time = data.data.time;

        $('.no_conv').html('');

        if(data.data.type != 'media'){
            $(".chatscreen").append('<div class="chat-message chat-message-left"><div class="chat-message-text"><span>'+rec_message+'</span></div><div class="chat-message-meta"><small>'+time+'<i class="feather icon-check ml-2"></i></small></div></div>');
        }else{
            $(".chatscreen").append('<div class="chat-message chat-message-left"><div class="chat-message-text"> <a href="'+data.data.media+'" data-lightbox="image-1" data-title="image"><img src="'+data.data.media+'" width="300px" class="img-fluid img-thumbnail"></a></div><div class="chat-message-meta"><small>'+time+'<i class="feather icon-check ml-2"></i></small></div></div>');
        }
       
        scrolldown();
        rec_msg_sound.play();

    });

    var channel2 = pusher.subscribe('chat-msg-own');

    channel2.bind('conversation_own_'+conv_id+'_user_'+id, function (data) {

        var rec_message = data.data.message;
        var time = data.data.time;

        $('.no_conv').html('');

        if(data.data.type != 'media'){
            $(".chatscreen").append('<div class="chat-message chat-message-right"><div class="chat-message-text"><span>'+rec_message+'</span></div><div class="chat-message-meta"><small>'+time+'<i class="feather icon-check ml-2"></i></small></div></div>');
        }else{
            $(".chatscreen").append('<div class="chat-message chat-message-right"><div class="chat-message-text"> <a href="'+data.data.media+'" data-lightbox="image-1" data-title="image"><img src="'+data.data.media+'" width="300px" class="img-fluid img-thumbnail"></a></div><div class="chat-message-meta"><small>'+time+'<i class="feather icon-check ml-2"></i></small></div></div>');
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