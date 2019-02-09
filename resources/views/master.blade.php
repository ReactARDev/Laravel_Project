<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Exclusive free HD quality streams for cord cutters at Soccer Streams. We index stream links shared by hundreds of independent streamers.">
  <meta name="author" content="soccerstreams team">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @yield('metaSection')
  <link rel="icon" href="{{ cdn('favicon.ico') }}">

  <title>@yield('title')Soccer Streams</title>

  <!-- Material Design fonts -->
  <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800">
  <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:400,500,700,600,800">
  <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Oswald:400,700">
  <link rel="stylesheet" type="text/css" href="{{ cdn('css/RobotoSlab.css') }}">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" type="text/css" href="{{ cdn('fonts/font-awesome/css/font-awesome.min.css') }}">
  <!-- donation stuff -->
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <link href="//siolab.pw/donation/css/udb.css?ver=1.60" rel="stylesheet">
   <script src="//siolab.pw/donation/js/udb-jsonp.js?ver=1.60"></script>
  <!-- Bootstrap core CSS -->
  <link href="{{ cdn('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/soccerstreams.css').'?'.time() }}">
  <!-- <link rel="stylesheet" type="text/css" href="{{ cdn('css/soccerstreams.css').'?'.time() }}"> -->
  <!-- Bootstrap Country and File upload CSS -->
  <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/bootstrap-formhelpers.css').'?'.time() }}">
  <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/bootstrap-formhelpers.min.css').'?'.time() }}">
  <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/fileinput.min.css').'?'.time() }}">
  <!-- <link rel="stylesheet" type="text/css" href="{{ cdn('css/bootstrap-formhelpers.css').'?'.time() }}">
  <link rel="stylesheet" type="text/css" href="{{ cdn('css/bootstrap-formhelpers.min.css').'?'.time() }}">
  <link rel="stylesheet" type="text/css" href="{{ cdn('css/fileinput.min.css').'?'.time() }}"> -->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Bootstrap Country and File Upload JS -->
  <script src="{{ secure_asset('js/bootstrap-formhelpers.js') }}"></script>
  <script src="{{ secure_asset('js/bootstrap-formhelpers.min.js') }}"></script>
  <script src="{{ secure_asset('js/fileinput.min.js') }}"></script>
  <!-- <script src="{{ cdn('js/bootstrap-formhelpers.js') }}"></script>
  <script src="{{ cdn('js/bootstrap-formhelpers.min.js') }}"></script>
  <script src="{{ cdn('js/fileinput.min.js') }}"></script> -->

  <script src="{{ secure_asset('js/hammer.js').'?'.time() }}"></script>
  <script src="{{ secure_asset('js/custom.js').'?'.time() }}"></script>
  <!-- <script src="{{ cdn('js/custom.js').'?'.time() }}"></script> -->
  <script src="{{ cdn('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ cdn('js/moment.js') }}"></script>
  <script src="{{ cdn('js/moment-timezone.js') }}"></script>
  <script>
    var tmx;
    function UpdateTimezone() {
      var tzOptions = document.getElementById('offset');
      var tz = tzOptions.options[tzOptions.selectedIndex].value;
      var timezoneURL = "{{ secure_url('setTimezone') }}";
      $.get(timezoneURL + "/" + tz);
      tmx=tz;
      $('.event-time').each(function (i, e) {
        var oldTime = $(e).attr('data-eventtime');
        var utcStart = moment.utc(oldTime).utcOffset('UTC');
        var startDate = utcStart.utcOffset(tz * 60).format('HH:mm');
        $(e).html(startDate);
      });
    }
    function SelectElement(valueToSelect) {
      var element = document.getElementById('offset');
      element.value = valueToSelect;
    }
  </script>
  @if(!Session::has('visitorTZ'))
    <script>
      momentZone = moment.tz.guess();
      currentZoneOffset = moment.tz(momentZone).utcOffset() / 60;
      $(function ($) {
        var timezoneURL = "{{ secure_url('setTimezone') }}";
        $.get(timezoneURL + "/" + currentZoneOffset, function (data) {
          SelectElement(currentZoneOffset);
          UpdateTimezone();
        });
      });
    </script>
  @endif
  <link rel="stylesheet" href="{{ cdn('plugins/sweetalert/sweetalert.css') }}">
  <script src="{{ cdn('plugins/sweetalert/sweetalert.min.js') }}"></script>
  @yield('headScripts')
  @yield('style')
  <style>
    @media (max-width: 768px) {
      .navbar-brand {
        width: 100%;
        display: block;
        margin-bottom: 10px;
      }

      .navbar-brand > img {
        margin: auto;
        width: auto;
      }

      .live-menu .navbar-nav {
        float: none;
        width: 195px;
        margin: auto;
      }
    }

    #logo-ball {
      display: block;
      position: relative;
      top: 11px;
      left: 63px;
      transition: transform 0.8s ease-in-out;
    }

    .navbar-brand:hover #logo-ball {
      transform: rotate(360deg);
    }

    .navbar-brand {
      display: block;
      width: 242px;
      height: 97px !important;
      background: url("{{ cdn('images/logo.png') }}");
      padding: initial !important;
    }

    .navbar-brand > img {
      height: initial !important;
      margin-top: initial !important;
    }

    @media (max-width: 768px) {
      .navbar-brand > img {
        margin: initial !important;
      }
    }

    .full-logo {
      width: 100% !important;
      height: 100% !important;
      background: none !important;
    }

    .full-logo img {
      margin-top: 40px !important;
      width: 100% !important;
    }
    .live-menu .dropdown-menu{
      background: #001a28;
      min-width:30px;
    }
    #footer-links{ line-height:34px; }
    #footer_timer{ line-height:36px;text-align:right; color:#B3994C; }
    .footer #footer-links li a, .footer #footer-links li{ color:#B3994C; }
    @media (max-width: 767px) {
      #footer-links{ text-align:center; }
    }
  </style>
  <script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-91839096-1', 'auto');
ga('send', 'pageview');

</script>
</head>
<body>
  <div class="background-overlay" style="display:none;"></div>
  <input id="floating-button-toggle" type="checkbox" class="plus">
  <label for="floating-button-toggle" class="floating-button-toggle" style="margin:0!important;"><i style="border-radius:100%;background-color:#b3994c;" class="fa fa-soccer-ball-o"></i></label>
  <div class="floating-button" id="master-floating-button">
    @if (Auth::guest())
      <a href="{{ secure_url('rules') }}" class="beforelogin" data-title="Rules"><i class="fa fa-soccer-ball-o"></i></a>
      <a href="{{ secure_url('donate') }}" class="beforelogin" data-title="Donate"><i class="fa fa-credit-card"></i></a>
      <a href="{{ secure_url('submit') }}" class="beforelogin" data-title="Submit streams"><i class="fa fa-sticky-note"></i></a>
      <a href="{{ secure_url('redditLogin') }}" class="beforelogin" data-title="Reddit Login"><i class="fa fa-reddit-alien" aria-hidden="true"></i></a>
      <a href="https://www.facebook.com/rSoccerStreams/" class="beforelogin" target="_blank" data-title="Facebook"><i class="fa fa-facebook"></i></a>
      <a href="https://twitter.com/rsoccerstreams" class="beforelogin" target="_blank" data-title="Twitter"><i class="fa fa-twitter"></i></a>
      <a href="http://www.reddit.com/r/soccerstreams" class="beforelogin" target="_blank" data-title="Reddit"><i class="fa fa-reddit"></i></a>
      <a href="{{ secure_url('login') }}" class="beforelogin" data-title="Login"><i class="fa fa-sign-in"></i></a>
      <a href="{{ secure_url('register') }}" class="beforelogin" data-title="Signup"><i class="fa fa-tv"></i></a>
      <a href="https://siolab.pw/forums/" class="beforelogin" target="_blank" data-title="Forum"><i class="fa fa-credit-card"></i></a>
    @else
      <a href="{{ secure_url('rules') }}" class="afterlogin" data-title="Rules"><i class="fa fa-soccer-ball-o"></i></a>
      <a href="https://siolab.pw/forums/" class="afterlogin" target="_blank" data-title="Forum"><i class="fa fa-credit-card"></i></a>
      <a href="{{ secure_url('donate') }}" class="afterlogin" data-title="Donate"><i class="fa fa-credit-card"></i></a>
      <a href="{{ secure_url('submit') }}" class="afterlogin" data-title="Submit streams"><i class="fa fa-sticky-note"></i></a>
      @if(!isset(Auth::user()->id))
        <a href="{{ secure_url('redditLogin') }}" class="afterlogin" data-title="Reddit Login"><i class="fa fa-reddit-alien" aria-hidden="true"></i></a>
      @endif
      <a href="https://www.facebook.com/rSoccerStreams/" class="afterlogin" target="_blank" data-title="Facebook"><i class="fa fa-facebook"></i></a>
      <a href="https://twitter.com/rsoccerstreams" class="afterlogin" target="_blank" data-title="Twitter"><i class="fa fa-twitter"></i></a>
      <a href="http://www.reddit.com/r/soccerstreams" class="afterlogin" target="_blank" data-title="Reddit"><i class="fa fa-reddit"></i></a>
      <a href="{{ secure_url('profile') }}" class="afterlogin" data-title="Profile"><i class="fa fa-user"></i></a>
      <a href="{{ secure_url('profile/messages') }}" class="afterlogin" data-title="Messages"><i class="fa fa-envelope"></i></a>
      <a href="{{ secure_url('profile/favourite') }}" class="afterlogin" data-title="Favorites"><i class="fa fa-bookmark"></i></a>
      <a href="{{ secure_url('moderator/dashboard') }}"  class="afterlogin" data-title="Moderator"><i class="fa fa-group"></i></a>
      <a href="{{ secure_url('logout') }}" class="afterlogin" data-title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i></a>
      <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
    @endif
  </div>
<nav class="logo-header main-hide" role="navigation" style="position: fixed; top: 0; left: 0; right: 0; z-index: 111; margin-top: -5px;">
  <div class="container" id="headerContainer">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="“logo-confiner”">
{{--      <a href="{{ secure_url('/') }}" class="navbar-brand hidden-sm hidden-xs">
            <img id="logo-ball" alt="Soccer Streams logo" src="{{ cdn('images/ball.png') }}">
          </a>
          <a href="{{ secure_url('/') }}" class="navbar-brand full-logo visible-sm visible-xs">
            <img id="logo-ball-full" alt="Soccer Streams logo" src="{{ cdn('images/small_logo.png') }}">
          </a>
--}}
          <a href="{{ secure_url('/') }}" class="navbar-brand full-logo">
            <img id="logo-ball-full" alt="Soccer Streams logo" src="{{cdn('images/new_logo.png') }}">
          </a>
        </div>
      </div>
        <div class="live-menu social-icons">
          <ul>
            <li>
              <a href="https://www.facebook.com/rSoccerStreams/" target="_blank"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
            </li>
            <li>
            <a href="https://twitter.com/rsoccerstreams" target="_blank"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
            </li>
            <li>
            <a href="http://www.reddit.com/r/soccerstreams" target="_blank"><i class="fa fa-reddit fa-2x" aria-hidden="true"></i></a>
            </li>
          </ul>
        </div>
      <div class="col-md-7 col-sm-7 col-xs-7 no-padding" style="float:right;">
        <div class="live-menu collapse navbar-collapse no-padding-left" style="padding-bottom:15px;padding-top:32px;">
          <ul class="nav navbar-nav">
            <li>
              <a href="https://siolab.pw/forums/" target="_blank"><i class="fa fa-credit-card"></i><span class="hidden-sm hidden-xs"> &nbsp;Forums</span></a>
            </li>
            <li class='spliter'><span>/</span></li>
            <li>
              <a href="{{ secure_url('donate') }}"><i class="fa fa-credit-card"></i><span class="hidden-sm hidden-xs"> &nbsp;Donate</span></a>
            </li>
            <li class='spliter'><span>/</span></li>
            <li>
              <a href="{{ secure_url('rules') }}"><i class="fa fa-soccer-ball-o"></i><span class="hidden-sm hidden-xs"> Rules</span></a>
            </li>
            <li class='spliter'><span>/</span></li>
            <li>
              <a href="{{ secure_url('submit') }}"><i class="fa fa-sticky-note"></i><span class="hidden-sm hidden-xs"> &nbsp;Submit streams</span></a>
            </li>
            <!--<li class='spliter'><span>/</span></li>
            <li>
              <a href="{{ secure_url('faq') }}"><i class="fa fa-question-circle-o"></i><span class="hidden-sm hidden-xs"> &nbsp;FAQ</span></a>
            </li>-->
            @if(!isset(Auth::user()->id))
            <li class='spliter'><span>/</span></li>
            <li>
              <a href="{{ secure_url('redditLogin') }}"><i class="fa fa-reddit-alien" aria-hidden="true"></i><span class="hidden-sm hidden-xs"> Reddit Login</span></a>
            </li>
            @endif
            <li class='spliter'><span>/</span></li>
            @if (Auth::guest())
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><span class="hidden-sm hidden-xs">&nbsp;Account</span></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="{{ secure_url('login') }}"><i class="fa fa-sign-in"></i><span class="hidden-sm hidden-xs"> &nbsp;Login</span></a>
                  </li>
                  <li>
                    <a href="{{ secure_url('register') }}"><i class="fa fa-tv"></i><span class="hidden-sm hidden-xs"> &nbsp;Signup</span></a>
                  </li>
                </ul>
              </li>
            @else
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><span class="hidden-sm hidden-xs">
                &nbsp;{{Auth::user()->name}} @if(Auth::user()->role==1) ( Mod ) @elseif( Auth::user()->role==2 ) ( Admin ) @endif</span></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="{{ secure_url('profile') }}">
                      <i class="fa fa-user"></i><span class="hidden-sm hidden-xs"> &nbsp;Profile </span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ secure_url('profile/messages') }}">
                      <i class="fa fa-envelope"></i><span class="hidden-sm hidden-xs"> &nbsp;Messages </span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ secure_url('profile/favourite') }}">
                      <i class="fa fa-bookmark"></i><span class="hidden-sm hidden-xs"> &nbsp;Favorites </span>
                    </a>
                  </li>
                  @if( Auth::user()->role )
                  <li>
                    <a href="{{ secure_url('moderator/dashboard') }}">
                      <i class="fa fa-group"></i><span class="hidden-sm hidden-xs"> &nbsp;Moderator </span>
                    </a>
                  </li>
                  @endif
                  <li>
                    <a href="{{ secure_url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out"></i><span class="hidden-sm hidden-xs"> &nbsp;Logout</span>
                    </a>
                    <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </li>
                </ul>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>   <!-- /.container -->
</nav>

<div class="main-content" id="main-content" style="margin-top: 27px;overflow-x:hidden;position:relative;left:0;transition:left 0.5s;">
  <nav class="logo-header mobile-show" role="navigation" style="display:none;position: fixed; top: 0; left: 0; right: 0; z-index: 2001; margin-top: -5px;">
    <div class="background-overlay-sidebar"></div>
    <div class="container" id="headerContainer" >
      <div class="row">
          <a id="side-menubar"><span></span></a>
          <!-- <a class="close-side-menubar" id="side-menubar" style="display:none;"><span></span></a> -->
          <div class="“logo-confiner” mobile-view-logo">
  {{--      <a href="{{ secure_url('/') }}" class="navbar-brand hidden-sm hidden-xs">
              <img id="logo-ball" alt="Soccer Streams logo" src="{{ cdn('images/ball.png') }}">
            </a>
            <a href="{{ secure_url('/') }}" class="navbar-brand full-logo visible-sm visible-xs">
              <img id="logo-ball-full" alt="Soccer Streams logo" src="{{ cdn('images/small_logo.png') }}">
            </a>
  --}}
            <a href="{{ secure_url('/') }}" class="navbar-brand full-logo">
              <img id="logo-ball-full" alt="Soccer Streams logo" src="{{cdn('images/new_logo.png') }}">
            </a>
        </div>
      </div>
    </div>   <!-- /.container -->
    <ul class="nav nav-mobile-view">
      <li>
        <a href="{{ secure_url('rules') }}"><i class="fa fa-soccer-ball-o"></i><span class=""> Rules</span></a>
      </li>
      <li>
        <a href="https://siolab.pw/forums/" target="_blank"><i class="fa fa-credit-card"></i><span class=""> &nbsp;Forums</span></a>
      </li>
      <li>
        <a href="{{ secure_url('donate') }}"><i class="fa fa-credit-card"></i><span class=""> &nbsp;Donate</span></a>
      </li>
      <li>
        <a href="{{ secure_url('submit') }}"><i class="fa fa-sticky-note"></i><span class=""> &nbsp;Submit streams</span></a>
      </li>
      <!--<li class='spliter'><span>/</span></li>
      <li>
        <a href="{{ secure_url('faq') }}"><i class="fa fa-question-circle-o"></i><span class="hidden-sm hidden-xs"> &nbsp;FAQ</span></a>
      </li>-->
      @if(!isset(Auth::user()->id))
      <li>
        <a href="{{ secure_url('redditLogin') }}"><i class="fa fa-reddit-alien" aria-hidden="true"></i><span class=""> Reddit Login</span></a>
      </li>
      @endif
      <li class="dropdown2">
        <a href="#" class="mobile-show-acound-dropdown2" ><i class="fa fa-twitter"></i><span class="">&nbsp;Social</span></a>
        <ul class="dropdown-menu-mobile">
          <li class="drop-item-small">
            <a href="https://www.facebook.com/rSoccerStreams/" target="_blank"><i class="fa fa-facebook"></i><span class="">&nbsp;Facebook</span></a>
          </li>
          <li class="drop-item-small">
          <a href="https://twitter.com/rsoccerstreams" target="_blank"><i class="fa fa-twitter"></i><span class="">&nbsp;Twitter</span></a>
          </li>
          <li class="drop-item-small">
          <a href="http://www.reddit.com/r/soccerstreams" target="_blank"><i class="fa fa-reddit"></i><span class="">&nbsp;Reddit</span></a>
          </li>
        </ul>
      </li>
      @if (Auth::guest())
        <li class="dropdown1">
          <a href="#" class="mobile-show-acound-dropdown1" ><i class="fa fa-user"></i><span class="">&nbsp;Account</span></a>
          <ul class="dropdown-menu-mobile">
            <li class="drop-item-small">
              <a href="{{ secure_url('login') }}"><i class="fa fa-sign-in"></i><span class=""> &nbsp;Login</span></a>
            </li>
            <li class="drop-item-small">
              <a href="{{ secure_url('register') }}"><i class="fa fa-tv"></i><span class=""> &nbsp;Signup</span></a>
            </li>
          </ul>
        </li>
      @else
        <li class="dropdown1">
          <a href="#" class="mobile-show-acound-dropdown1">
            <span class="hidden-sm" style="display: block;width: 130px;overflow: hidden;white-space:nowrap;text-overflow: ellipsis;">
              <i class="fa fa-user"></i>
              &nbsp;{{Auth::user()->name}} @if(Auth::user()->role==1) ( Mod ) @elseif( Auth::user()->role==2 ) ( Admin ) @endif
            </span></a>
          <ul class="dropdown-menu-mobile">
            <li class="drop-item-small">
              <a href="{{ secure_url('profile') }}">
                <i class="fa fa-user"></i><span class="hidden-sm"> &nbsp;Profile </span>
              </a>
            </li>
            <li class="drop-item-small">
              <a href="{{ secure_url('profile/messages') }}">
                <i class="fa fa-envelope"></i><span class="hidden-sm"> &nbsp;Messages </span>
              </a>
            </li>
            <li class="drop-item-small">
              <a href="{{ secure_url('profile/favourite') }}">
                <i class="fa fa-bookmark"></i><span class="hidden-sm"> &nbsp;Favorites </span>
              </a>
            </li>
            @if( Auth::user()->role )
            <li class="drop-item-small">
              <a href="{{ secure_url('moderator/dashboard') }}">
                <i class="fa fa-group"></i><span class="hidden-sm"> &nbsp;Moderator </span>
              </a>
            </li>
            @endif
            <li class="drop-item-small">
              <a href="{{ secure_url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i><span class="hidden-sm"> &nbsp;Logout</span>
              </a>
              <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      @endif
    </ul>
  </nav>
  <div class="container" id="mobile-view-content" style="position: relative">
    <div class="alert alert-warning">
      <span class="mobile-view-alert-hide">Soccer Streams is still in a beta phase.If you face any bugs, please report them<a style="color:#337ab7 !important;" href="{{ secure_url('contact-us') }}">HERE</a>.</span>
      <span class="mobile-view-alert-show" style="display:none;">Soccer Streams is still in a beta phase.<br />If you face any bugs, please report them<a style="color:#337ab7 !important;" href="{{ secure_url('contact-us') }}">&nbsp;HERE</a>.</span>
    </div>
    @yield('content')
  </div><!-- /.container -->
</div>

<footer class="footer color-bg">
  <div class="container">
    <div class="row">
      <div class="col-sm-5 col-xs-12 pull-right">
        <div class="col-sm-7 col-xs-6 hidden-xs" id="footer_timer">
          {{ \Carbon\Carbon::now()->addHours(Session::get('visitorTZ'))->format('jS F H:i:s') }}
        </div>
        <div class="mobile-view-select-time-cont col-sm-5 col-xs-6 col-xs-offset-3 col-sm-offset-0">
          <select id="offset" class="form-control select-style" name="offset" onchange="UpdateTimezone();">
            @foreach($timeZoneOffsets as $key => $offset)
              @if(Session::has('visitorTZ') && Session::get('visitorTZ')==$key)
                {{ $selected = 'selected' }}
              @else
                {{ $selected = '' }}
              @endif
              <option value="{{ $key }}" {{ $selected }}> {{$offset}}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-sm-5 col-xs-12 pull-left">
          <ul id="footer-links">
            <li><a href="{{ secure_url('contact-us') }}">Contact us</a></li>
            <li>Coded with <span style="color: red;">❤</span>{{--<i class="em em-heart"></i>--}}</li>
            <li><a href="{{ secure_url('faq') }}">FAQ</a></li>
            <li class="last_child"><a href="{{ secure_url('dmca') }}">DMCA</a></li>
          </ul>
      </div>

      <div class="col-sm-2 col-xs-12">
        <div class="social-icons" style="padding-top: 5px;">
          <ul>
            <li>
              <a href="https://www.facebook.com/rSoccerStreams/" target="_blank"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
            </li>
            <li>
            <a href="https://twitter.com/rsoccerstreams" target="_blank"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
            </li>
            <li>
            <a href="http://www.reddit.com/r/soccerstreams" target="_blank"><i class="fa fa-reddit fa-2x" aria-hidden="true"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="{{ secure_asset('js/date.format.js') }}"></script>
<!-- <script src="{{ cdn('js/date.format.js') }}"></script> -->
<script type="text/javascript">

  $(document).ready(function () {


    tmx="{{Session::get('visitorTZ')}}";
    var now = new Date("{{ \Carbon\Carbon::now()->addHours(Session::get('visitorTZ')) }}");
    var second = 0;

    function getdate(){
      date = new Date( now ).getTime() + parseInt(second) * 1000 ;
      converted = new Date( date );
      var h = converted.getHours();
      var m = converted.getMinutes();
      var s = converted.getSeconds();

      $("#footer_timer").html( moment.utc(new Date()).zone( -60*tmx).format('Do MMMM HH:mm:ss'));
      second++;
      setTimeout(function( ){getdate()}, 1000);
    }
    getdate();
  });

</script>
@yield('scripts')

<!-- including notice modal -->
@include('partials.notice_modal')

</body>
</html>

<style type="text/css">
select#offset.form-control.select-style {
    padding: 0;
    margin: 0;
    color: #B3994C !important;
    border: 0px solid #ccc;
    border-radius: 3px;
    overflow: hidden;
    background: transparent !important;
    text-align: center!important;
    text-align: -moz-center;
    text-align: -webkit-center;
    -ms-text-align-last: center;
    -moz-text-align-last: center;
    text-align-last: center;
}

.select-style select {
    padding: 5px 8px;
    border: none;
    box-shadow: none;
    width:130%;
    background-color: transparent;
    background-image: none;
    -webkit-appearance: none;
       -moz-appearance: none;
            appearance: none;
}
.select-style:active, .select-style:hover {
  outline: none
}
.select-style:hover {
    color: white;
    background: #7d7d7d;
    opacity: 1;
}
</style>
