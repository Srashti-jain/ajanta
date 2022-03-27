@extends('admin.layouts.master-soyuz')
@section('title',__('Footer Customization | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

  @slot('heading')
  {{ __('Home') }}
  @endslot

  @slot('menu1')
  {{ __("Front Settings") }}
  @endslot

  @slot('menu2')
  {{ __("Footer Customization") }}
  @endslot

@endcomponent

<div class="contentbar">
  <div class="row">
    
    <div class="col-lg-12">

      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          @foreach($errors->all() as $error)
          <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button></p>
          @endforeach
        </div>
      @endif

      <div class="card m-b-30">
        <div class="card-header">
          <button data-toggle="modal" data-target="#helpModal" class="float-right btn btn-primary-rgba">
             <i class="feather icon-help-circle"></i> {{__("Help")}}
          </button>
          <h4 class="card-title">{{ __("Footer Customization") }}</h4>
          
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/footer/')}}">
            @csrf

            <div class="row">

              <div class="col-md-12">
                <h4>{{__("Footer Section 1 Label")}}:</h4>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>{{__('Enter Section 1 Label')}}:</label>
                    <input placeholder="{{ __('Enter Footer Section 1 title') }}" type="text" name="shiping"
                      value="{{$row->shiping ?? ''}}" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label>{{ __("Choose Icon:") }}</label>
                    <div class="input-group">
                      <input type="text" class="form-control iconvalue" name="icon_section1" id="icon_section1" value="{{ $row->icon_section1 }}">
                      <span class="input-group-append">
                        <button type="button" class="btnicon2 btn btn-secondary-rgba" role="iconpicker"></button>
                      </span>
                    </div>

                  </div>

                </div>
              </div>
              <div class="col-md-12">
                <h4>{{__('Footer Section 2 Label')}}:</h4>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>{{__("Enter Section 2 Label")}}:</label>
                    <input placeholder="{{ __("Enter Footer Section 2 title") }}" type="text" name="mobile"
                      value="{{$row->mobile ?? ''}}" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label>{{ __('Choose Icon:') }}</label>
                    <div class="input-group">
                      <input type="text" class="form-control iconvalue" id="icon_section2" name="icon_section2"
                        value="{{ $row->icon_section2 }}">
                      <span class="input-group-append">
                        <button type="button" class="btnicon2 btn btn-secondary-rgba" role="iconpicker"></button>
                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <h4>{{__('Footer Section 3 Label')}}:</h4>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>{{__('Enter Section 3 Label')}}:</label>
                    <input placeholder="{{__('Enter Footer Section 3 title') }}" type="text" name="return"
                      value="{{$row->return ?? ''}}" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label>{{__("Choose Icon")}}:</label>

                    <div class="input-group">
                      <input type="text" class="form-control iconvalue" id="icon_section3" name="icon_section3"
                        value="{{ $row->icon_section3 }}">
                      <span class="input-group-append">
                        <button type="button" class="btnicon2 btn btn-secondary-rgba" role="iconpicker"></button>
                      </span>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-md-12">
                <h4>{{__("Footer Section 4 Label")}}:</h4>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>{{__("Enter Section 4 Label")}}:</label>
                    <input placeholder="{{ __('Enter Footer Section 3 title') }}" id="icon_section4" type="text" name="money"
                      value="{{$row->money ?? ''}}" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label>{{__("Choose Icon")}}:</label>
                    <div class="input-group">
                      <input type="text" class="form-control iconvalue" name="icon_section4"
                        value="{{ $row->icon_section4 }}">
                      <span class="input-group-append">
                        <button type="button" class="btnicon2 btn btn-secondary-rgba" role="iconpicker"></button>
                      </span>
                    </div>

                  </div>

                </div>


              </div>
            </div>

            <div class="form-group">
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled=""
                title="{{ __("This operation is disabled in Demo !") }}" @endif class="btn btn-md btn-success-rgba">
                <i class="fa fa-save"></i> {{__("Save Settings")}}
              </button>
            </div>
          </form>

        </div>

      </div>
      <div class="card m-b-30">
        <div class="card-header">
          <h4 class="box-title">{{__("Footer Section Customize")}}:</h4>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/footer/')}}">
            @csrf

            <div class="row">
              <div class="col-md-12">


                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="">{{__("Enter Widget 1 Title")}}:</label>
                    <input placeholder="{{__("Enter Widget 1 Title")}}" type="text" name="footer2" value="{{$row->footer2 ?? ''}}"
                      class="form-control">

                  </div>
                  <div class="col-md-6 form-group">

                    <label for="">{{__("Enter Widget 2 Title")}}:</label>
                    <input placeholder="{{__("Enter Widget 2 Title")}}" type="text" name="footer3" value="{{$row->footer3 ?? ''}}"
                      class="form-control">


                  </div>
                </div>
                <div class="col-md-12">


                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="">{{__("Enter Widget 3 Title")}}:</label>
                      <input placeholder="{{__("Enter Widget 3 Title")}}" type="text" name="footer4"
                        value="{{$row->footer4 ?? ''}}" class="form-control">
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="form-group">
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled=""
                title="{{ __("This operation is disabled in Demo !") }}" @endif class="btn btn-md btn-success-rgba">
                <i class="fa fa-save"></i> {{__("Save Settings")}}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="width60 modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">{{ __('Example of Footer Widgets & Footer Sections') }}</h4>
          <button type="button" class="float-right close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          
        </div>

        <div class="modal-body">
          <img src="{{ url('images/footerhelp.png') }}" title="{{ __('Footer Help Example') }}" alt="help-footer"
            class="img-fluid">
        </div>

      </div>
    </div>
  </div>
@endsection
@section('custom-script')
  <script>

    $('.btnicon2').each(function() {

       var icon = $(this).closest('div.input-group').find('input.iconvalue').val();
       ip(this,icon);

    });

    function ip(btn,icon){

      
      $(btn).iconpicker()
        .iconpicker('setAlign', 'center')
        .iconpicker('setCols', 5)
        .iconpicker('setArrowPrevIconClass', 'fa fa-angle-left')
        .iconpicker('setArrowNextIconClass', 'fa fa-angle-right')
        .iconpicker('setIconset', {
          iconClass: 'fa',
          iconClassFix: 'fa-',
          icons: ["500px", "address-book", "address-book-o", "address-card", "address-card-o", "adjust", "adn", "align-center", "align-justify", "align-left", "align-right", "amazon", "ambulance", "american-sign-language-interpreting", "anchor", "android", "angellist", "angle-double-down", "angle-double-left", "angle-double-right", "angle-double-up", "angle-down", "angle-left", "angle-right", "angle-up", "apple", "archive", "area-chart", "arrow-circle-down", "arrow-circle-left", "arrow-circle-o-down", "arrow-circle-o-left", "arrow-circle-o-right", "arrow-circle-o-up", "arrow-circle-right", "arrow-circle-up", "arrow-down", "arrow-left", "arrow-right", "arrow-up", "arrows", "arrows-alt", "arrows-h", "arrows-v", "asl-interpreting", "assistive-listening-systems", "asterisk", "at", "audio-description", "automobile", "backward", "balance-scale", "ban", "bandcamp", "bank", "bar-chart", "bar-chart-o", "barcode", "bars", "bath", "bathtub", "battery", "battery-0", "battery-1", "battery-2", "battery-3", "battery-4", "battery-empty", "battery-full", "battery-half", "battery-quarter", "battery-three-quarters", "bed", "beer", "behance", "behance-square", "bell", "bell-o", "bell-slash", "bell-slash-o", "bicycle", "binoculars", "birthday-cake", "bitbucket", "bitbucket-square", "bitcoin", "black-tie", "blind", "bluetooth", "bluetooth-b", "bold", "bolt", "bomb", "book", "bookmark", "bookmark-o", "braille", "briefcase", "btc", "bug", "building", "building-o", "bullhorn", "bullseye", "bus", "buysellads", "cab", "calculator", "calendar", "calendar-check-o", "calendar-minus-o", "calendar-o", "calendar-plus-o", "calendar-times-o", "camera", "camera-retro", "car", "caret-down", "caret-left", "caret-right", "caret-square-o-down", "caret-square-o-left", "caret-square-o-right", "caret-square-o-up", "caret-up", "cart-arrow-down", "cart-plus", "cc", "cc-amex", "cc-diners-club", "cc-discover", "cc-jcb", "cc-mastercard", "cc-paypal", "cc-stripe", "cc-visa", "certificate", "chain", "chain-broken", "check", "check-circle", "check-circle-o", "check-square", "check-square-o", "chevron-circle-down", "chevron-circle-left", "chevron-circle-right", "chevron-circle-up", "chevron-down", "chevron-left", "chevron-right", "chevron-up", "child", "chrome", "circle", "circle-o", "circle-o-notch", "circle-thin", "clipboard", "clock-o", "clone", "close", "cloud", "cloud-download", "cloud-upload", "cny", "code", "code-fork", "codepen", "codiepie", "coffee", "cog", "cogs", "columns", "comment", "comment-o", "commenting", "commenting-o", "comments", "comments-o", "compass", "compress", "connectdevelop", "contao", "copy", "copyright", "creative-commons", "credit-card", "credit-card-alt", "crop", "crosshairs", "css3", "cube", "cubes", "cut", "cutlery", "dashboard", "dashcube", "database", "deaf", "deafness", "dedent", "delicious", "desktop", "deviantart", "diamond", "digg", "dollar", "dot-circle-o", "download", "dribbble", "drivers-license", "drivers-license-o", "dropbox", "drupal", "edge", "edit", "eercast", "eject", "ellipsis-h", "ellipsis-v", "empire", "envelope", "envelope-o", "envelope-open", "envelope-open-o", "envelope-square", "envira", "eraser", "etsy", "eur", "euro", "exchange", "exclamation", "exclamation-circle", "exclamation-triangle", "expand", "expeditedssl", "external-link", "external-link-square", "eye", "eye-slash", "eyedropper", "fa", "facebook", "facebook-f", "facebook-official", "facebook-square", "fast-backward", "fast-forward", "fax", "feed", "female", "fighter-jet", "file", "file-archive-o", "file-audio-o", "file-code-o", "file-excel-o", "file-image-o", "file-movie-o", "file-o", "file-pdf-o", "file-photo-o", "file-picture-o", "file-powerpoint-o", "file-sound-o", "file-text", "file-text-o", "file-video-o", "file-word-o", "file-zip-o", "files-o", "film", "filter", "fire", "fire-extinguisher", "firefox", "first-order", "flag", "flag-checkered", "flag-o", "flash", "flask", "flickr", "floppy-o", "folder", "folder-o", "folder-open", "folder-open-o", "font", "font-awesome", "fonticons", "fort-awesome", "forumbee", "forward", "foursquare", "free-code-camp", "frown-o", "futbol-o", "gamepad", "gavel", "gbp", "ge", "gear", "gears", "genderless", "get-pocket", "gg", "gg-circle", "gift", "git", "git-square", "github", "github-alt", "github-square", "gitlab", "gittip", "glass", "glide", "glide-g", "globe", "google", "google-plus", "google-plus-circle", "google-plus-official", "google-plus-square", "google-wallet", "graduation-cap", "gratipay", "grav", "group", "h-square", "hacker-news", "hand-grab-o", "hand-lizard-o", "hand-o-down", "hand-o-left", "hand-o-right", "hand-o-up", "hand-paper-o", "hand-peace-o", "hand-pointer-o", "hand-rock-o", "hand-scissors-o", "hand-spock-o", "hand-stop-o", "handshake-o", "hard-of-hearing", "hashtag", "hdd-o", "header", "headphones", "heart", "heart-o", "heartbeat", "history", "home", "hospital-o", "hotel", "hourglass", "hourglass-1", "hourglass-2", "hourglass-3", "hourglass-end", "hourglass-half", "hourglass-o", "hourglass-start", "houzz", "html5", "i-cursor", "id-badge", "id-card", "id-card-o", "ils", "image", "imdb", "inbox", "indent", "industry", "info", "info-circle", "inr", "instagram", "institution", "internet-explorer", "intersex", "ioxhost", "italic", "joomla", "jpy", "jsfiddle", "key", "keyboard-o", "krw", "language", "laptop", "lastfm", "lastfm-square", "leaf", "leanpub", "legal", "lemon-o", "level-down", "level-up", "life-bouy", "life-buoy", "life-ring", "life-saver", "lightbulb-o", "line-chart", "link", "linkedin", "linkedin-square", "linode", "linux", "list", "list-alt", "list-ol", "list-ul", "location-arrow", "lock", "long-arrow-down", "long-arrow-left", "long-arrow-right", "long-arrow-up", "low-vision", "magic", "magnet", "mail-forward", "mail-reply", "mail-reply-all", "male", "map", "map-marker", "map-o", "map-pin", "map-signs", "mars", "mars-double", "mars-stroke", "mars-stroke-h", "mars-stroke-v", "maxcdn", "meanpath", "medium", "medkit", "meetup", "meh-o", "mercury", "microchip", "microphone", "microphone-slash", "minus", "minus-circle", "minus-square", "minus-square-o", "mixcloud", "mobile", "mobile-phone", "modx", "money", "moon-o", "mortar-board", "motorcycle", "mouse-pointer", "music", "navicon", "neuter", "newspaper-o", "object-group", "object-ungroup", "odnoklassniki", "odnoklassniki-square", "opencart", "openid", "opera", "optin-monster", "outdent", "pagelines", "paint-brush", "paper-plane", "paper-plane-o", "paperclip", "paragraph", "paste", "pause", "pause-circle", "pause-circle-o", "paw", "paypal", "pencil", "pencil-square", "pencil-square-o", "percent", "phone", "phone-square", "photo", "picture-o", "pie-chart", "pied-piper", "pied-piper-alt", "pied-piper-pp", "pinterest", "pinterest-p", "pinterest-square", "plane", "play", "play-circle", "play-circle-o", "plug", "plus", "plus-circle", "plus-square", "plus-square-o", "podcast", "power-off", "print", "product-hunt", "puzzle-piece", "qq", "qrcode", "question", "question-circle", "question-circle-o", "quora", "quote-left", "quote-right", "ra", "random", "ravelry", "rebel", "recycle", "reddit", "reddit-alien", "reddit-square", "refresh", "registered", "remove", "renren", "reorder", "repeat", "reply", "reply-all", "resistance", "retweet", "rmb", "road", "rocket", "rotate-left", "rotate-right", "rouble", "rss", "rss-square", "rub", "ruble", "rupee", "s15", "safari", "save", "scissors", "scribd", "search", "search-minus", "search-plus", "sellsy", "send", "send-o", "server", "share", "share-alt", "share-alt-square", "share-square", "share-square-o", "shekel", "sheqel", "shield", "ship", "shirtsinbulk", "shopping-bag", "shopping-basket", "shopping-cart", "shower", "sign-in", "sign-language", "sign-out", "signal", "signing", "simplybuilt", "sitemap", "skyatlas", "skype", "slack", "sliders", "slideshare", "smile-o", "snapchat", "snapchat-ghost", "snapchat-square", "snowflake-o", "soccer-ball-o", "sort", "sort-alpha-asc", "sort-alpha-desc", "sort-amount-asc", "sort-amount-desc", "sort-asc", "sort-desc", "sort-down", "sort-numeric-asc", "sort-numeric-desc", "sort-up", "soundcloud", "space-shuttle", "spinner", "spoon", "spotify", "square", "square-o", "stack-exchange", "stack-overflow", "star", "star-half", "star-half-empty", "star-half-full", "star-half-o", "star-o", "steam", "steam-square", "step-backward", "step-forward", "stethoscope", "sticky-note", "sticky-note-o", "stop", "stop-circle", "stop-circle-o", "street-view", "strikethrough", "stumbleupon", "stumbleupon-circle", "subscript", "subway", "suitcase", "sun-o", "superpowers", "superscript", "support", "table", "tablet", "tachometer", "tag", "tags", "tasks", "taxi", "telegram", "television", "tencent-weibo", "terminal", "text-height", "text-width", "th", "th-large", "th-list", "themeisle", "thermometer", "thermometer-0", "thermometer-1", "thermometer-2", "thermometer-3", "thermometer-4", "thermometer-empty", "thermometer-full", "thermometer-half", "thermometer-quarter", "thermometer-three-quarters", "thumb-tack", "thumbs-down", "thumbs-o-down", "thumbs-o-up", "thumbs-up", "ticket", "times", "times-circle", "times-circle-o", "times-rectangle", "times-rectangle-o", "tint", "toggle-down", "toggle-left", "toggle-off", "toggle-on", "toggle-right", "toggle-up", "trademark", "train", "transgender", "transgender-alt", "trash", "trash-o", "tree", "trello", "tripadvisor", "trophy", "truck", "try", "tty", "tumblr", "tumblr-square", "turkish-lira", "tv", "twitch", "twitter", "twitter-square", "umbrella", "underline", "undo", "universal-access", "university", "unlink", "unlock", "unlock-alt", "unsorted", "upload", "usb", "usd", "user", "user-circle", "user-circle-o", "user-md", "user-o", "user-plus", "user-secret", "user-times", "users", "vcard", "vcard-o", "venus", "venus-double", "venus-mars", "viacoin", "viadeo", "viadeo-square", "video-camera", "vimeo", "vimeo-square", "vine", "vk", "volume-control-phone", "volume-down", "volume-off", "volume-up", "warning", "wechat", "weibo", "weixin", "whatsapp", "wheelchair", "wheelchair-alt", "wifi", "wikipedia-w", "window-close", "window-close-o", "window-maximize", "window-minimize", "window-restore", "windows", "won", "wordpress", "wpbeginner", "wpexplorer", "wpforms", "wrench", "xing", "xing-square", "y-combinator", "y-combinator-square", "yahoo", "yc", "yc-square", "yelp", "yen", "yoast", "youtube", "youtube-play", "youtube-square"]
        })
        .iconpicker('setIcon', icon.substr(3))
        .iconpicker('setSearch', true)
        .iconpicker('setFooter', true)
        .iconpicker('setHeader', true)
        .iconpicker('setSearchText', 'Type text')
        .iconpicker('setSelectedClass', 'btn-warning')
        .iconpicker('setUnselectedClass', 'btn-primary');



    }

    $('.btnicon2').on('change', function (e) {
      $(this).closest('div.input-group').find('input.iconvalue').val('fa ' + e.icon);
    });

  
  </script>
@endsection