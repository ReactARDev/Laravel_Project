@extends('master')
@section('headScripts')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.1/datatables.min.js"></script>
@endsection
@section('style')
  <style>
    .borderTop{
      border-top: 2px solid #f39c12 !important;
    }
    .matches_divider{ width:0 !important; }
    @media screen and (-webkit-min-device-pixel-ratio:0) {
      /*your rules for chrome*/
      .sorting_disabled{ width:0 !important; }
    }
    table#eventsTable>thead{
      display: none;
    }
    table#eventsTable>tbody>tr>td.text-center{
      padding-top: 0px;
      padding-bottom: 0px;
    }
    table.dataTable{
      margin-top: 0!important;
    }
    @media(max-width:500px) {
      div.alert.alert-warning{
        margin-bottom: -5px;
      }
    
    }
   
  </style>
@endsection
@section('content')
  @if(Auth::check())
    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->verified==0 && \Illuminate\Support\Facades\Auth::user()->verification_token !="1" && \Illuminate\Support\Facades\Auth::user()->email != "")
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="verifyAlert();">
          <span aria-hidden="true">&times;</span>
        </button>
        Your account has not been verified. Please click <a href="{{ secure_url('sendVerification') }}"><b>HERE</b></a> to re-send the verification email if you have not received one.
        You may find the email in spam folder
      </div>
    @endif

    @if(\Illuminate\Support\Facades\Auth::user()->email == "")
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          Your account has not been verified. Please click <a href="{{ secure_url('/profile') }}"><b>HERE</b></a> to update your email and verify your account if you wish to post streams.
        </div>
    @endif

    @if( count($notifications) )
      @php $unread_count = count( $notifications ); @endphp
      @foreach($notifications as $notification)
        @if( $notification->type == 2 || $notification->type == 3 )
          <div class="alert alert-info alert-dismissible" role="alert" style="word-break: break-all; word-wrap: break-word;{{$notification->color}}">
            @if( $notification->type == 2 )
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="notificationAction({{ $notification->id }});">
              <span aria-hidden="true">&times;</span>
            </button>
            @endif
            {!! $notification->title !!}
            @php $unread_count--; @endphp
          </div>
        @endif
      @endforeach
      @if( $unread_count > 0 )
        <div class="alert alert-info alert-dismissible" role="alert">
          <a href={{ secure_url('/profile/messages') }}>You have {{ $unread_count }} unread messages.</a>
        </div>
      @endif
    @endif
  @endif

  @if (session('error'))
    <div class="alert alert-danger" style="margin: 10px;">
      {{ session('error') }}
    </div>
  @endif
  <div class="row">
    <div class="mobile-ipad-view-for-7 col-md-7 filter">
      <form action="" class="form-inline">
        <div class="form-group">
          <label style="margin-top: 9px" for="competition_selector" class="mobile-view-competition-label">Competition:&nbsp;&nbsp;</label>
            <select class="form-control mobile-view-competition-selector" id="competition_selector" style="height:25px;padding-top:0;padding-bottom:0;">
              <option value="All">All</option>
              @foreach($competitions as $competition)
                <option value="{{ $competition }}">{{ $competition }}</option>
              @endforeach
            </select>
        </div>
      </form>
    </div>
    <?php
      $updateScore = "checked";
      if(session('updateScore') != null)
        $updateScore = session('updateScore') == "true" ? "checked" : "";
    ?>

    <div class="mobile-ipad-view-for-5 col-md-5 mobile-view-checkbox" style="text-align: right;">
      <div class="checkbox">
        <label style="margin-top:5px;">
          <input type="checkbox" id="updateScore" {{ $updateScore }}> Show scores
        </label>
      </div>
    </div>
  </div>

  <div id="manage_events">
    <div class="table-responsive" style="overflow-x:hidden">
      <table class="table table-striped table-hover" id="eventsTable" width="100%">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $lastDate = ''; $i = 0; $var = ''; ?>
        @foreach($events as $event_parent)
          @foreach($event_parent as $event)
            @if($lastDate != \Carbon\Carbon::parse($event->start_date)->addMinute(Session::get('visitorTZ')*60)->format('d M Y'))
              <tr>
                <td class="matches_divider" colspan="4">
                  <i class="fa fa-calendar fa-2x"></i>
                  <span>{{ \Carbon\Carbon::parse($event->start_date)->addMinute(Session::get('visitorTZ')*60)->format('d M Y') }}</span>
                </td>
                <td class="matches_divider"></td>
                <td class="matches_divider"></td>
                <td class="matches_divider"></td>
              </tr>
            @endif
            <?php
              $cur_time = \Carbon\Carbon::now();
              $start_time = \Carbon\Carbon::parse($event->start_date);
              $isRunning = "not-running";
              $i++; 
              if($cur_time >= $start_time)
                $isRunning = "running";

              $lastDate = \Carbon\Carbon::parse($event->start_date)->addMinute(Session::get('visitorTZ')*60)->format('d M Y');

              $borderTop = "";
              if(isset($event->isFav) && $event->isFav == false) $borderTop = "borderTop";
            ?>
            <tr @if(isset($event->isFav) && $event->isFav == true) style=" background-color: rgba(241, 196, 15, 0.3) " @endif 
            competition="{{ $event->competition_name }}">
              <td width="10%" class="{{ $borderTop }}">
                {{-- @if(empty(trim($event->game_minute))) --}}
                @if(\Carbon\Carbon::parse($event->start_date) > \Carbon\Carbon::now() ||
                    $updateScore == false ||
                    $event->event_minute == "")
               <a href="{{ secure_url('streams/'.$event->event_id.'/'.$event->home_team_slug.'_vs_'.$event->away_team_slug) }}" style="color:#333">
                  <span class="event-time mobile-view-eventtime_hide" data-eventtime="{{ $event->start_date }}">
                    {{ \Carbon\Carbon::parse($event->start_date)->addMinute(Session::get('visitorTZ')*60)->format('H:i') }}
                  </span>
                  <span class="event-time mobile-view-eventtime_show" style="display:none;" data-eventtime="{{ $event->start_date }}">
                    {{ \Carbon\Carbon::parse($event->start_date)->addMinute(Session::get('visitorTZ')*60)->format('H:i') }}
                  </span>
                </a>
                @else
                  <span class="@if($event->event_minute != "FT") game_minute @endif {{ $isRunning }}" id="{{ $isRunning }}_{{ $event->event_id }}_minute" data-id="{{ $event->event_id }}">'{{ $event->event_minute }}</span>
                @endif
              </td>
              
              <td width="10%" class="{{ $borderTop }}">
              <a href="{{ secure_url('streams/'.$event->event_id.'/'.$event->home_team_slug.'_vs_'.$event->away_team_slug) }}">
                <p class="hidden">{{ $event->competition_name }}</p>
                @if( $event->competition_logo && file_exists( 'images/competitions/small/'.$event->competition_logo ) )
                  <img src="{{ cdn('images/competitions/small/'.$event->competition_logo)}}" alt="{{ $event->competition_name }}" width="30 " height="30" title="{{ $event->competition_name }}">
                @else
                  <img src="{{ cdn('images/generic.png') }}" alt="{{ $event->competition_name }}" width="30 " height="30" title="{{ $event->competition_name }}">
                @endif
                 </a>
              </td>

              @if(is_null($event->event_title) || $event->event_title == 'NULL' || empty($event->event_title))
                <td class="text-center {{ $borderTop }}">
                  <a href="{{ secure_url('streams/'.$event->event_id.'/'.$event->home_team_slug.'_vs_'.$event->away_team_slug) }}" style="color:#444">
                  <div class="row">
                    <div class="col-md-12 mobile-view-main-table-hide">
                      <div class="col-md-5 text-right">
                        @if( file_exists( 'images/teams/small/'.$event->home_team_logo ) )
                          {{ $event->home_team }} &nbsp;<img src="{{ cdn('images/teams/small/'.$event->home_team_logo)}}" alt="{{ $event->home_team }}" width="30" height="30">
                        @else
                          {{ $event->home_team }} &nbsp;<img src="{{ cdn('images/generic.png')}}" alt="{{ $event->home_team }}" width="30" height="30">
                        @endif
                      </div>
                      <div class="col-md-2 text-center">
                        {{-- @if(empty(trim($event->event_status))) --}}
                        @if(\Carbon\Carbon::parse($event->start_date) > \Carbon\Carbon::now() || $updateScore == false || $event->event_minute == "" || $event->event_status == null)
                          vs
                        @else
                          <span id="{{ $isRunning }}_{{ $event->event_id }}_score">{{ $event->event_status }}</span>
                        @endif
                      </div>
                      <div class="col-md-5 text-left">
                        @if( file_exists( 'images/teams/small/'.$event->away_team_logo ) )
                          <img src="{{ cdn('images/teams/small/'.$event->away_team_logo )}}" alt="{{ $event->away_team }}" width="30" height="30">&nbsp;{{ $event->away_team }}
                        @else
                          <img src="{{ cdn('images/generic.png')}}" alt="{{ $event->away_team }}" width="30" height="30">&nbsp;{{ $event->away_team }}
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12 mobile-view-main-table-show" style="display:none;">
                      <div class="mobile-view-team-first">
                        @if( file_exists( 'images/teams/small/'.$event->home_team_logo ) )
                          <span>{{ $event->home_team }}</span>
                        @else
                          <span>{{ $event->home_team }}</span>
                        @endif
                      </div>
                      <div style="position:relative;">
                        @if( file_exists( 'images/teams/small/'.$event->home_team_logo ) )
                          <img style="position:absolute;top:-6px;left:0;" src="{{ cdn('images/teams/small/'.$event->home_team_logo)}}" alt="{{ $event->home_team }}" width="30" height="30">
                        @else
                          <img style="position:absolute;top:-6px;left:0;" src="{{ cdn('images/generic.png')}}" alt="{{ $event->home_team }}" width="30" height="30">
                        @endif
                        <div class="mobile-view-vs-set">
                          {{-- @if(empty(trim($event->event_status))) --}}
                          @if(\Carbon\Carbon::parse($event->start_date) > \Carbon\Carbon::now() || $updateScore == false || $event->event_minute == "" || $event->event_status == null)
                            <span>vs</span>
                          @else
                            <span id="{{ $isRunning }}_{{ $event->event_id }}_score">{{ $event->event_status }}</span>
                          @endif
                        </div>
                        @if( file_exists( 'images/teams/small/'.$event->away_team_logo ) )
                          <img style="position:absolute;top:-6px;right:0;" src="{{ cdn('images/teams/small/'.$event->away_team_logo )}}" alt="{{ $event->away_team }}" width="30" height="30">
                        @else
                          <img style="position:absolute;top:-6px;right:0;" src="{{ cdn('images/generic.png')}}" alt="{{ $event->away_team }}" width="30" height="30">
                        @endif
                      </div>
                      <div class="mobile-view-team-second">
                        @if( file_exists( 'images/teams/small/'.$event->away_team_logo ) )
                          <spqn style="overflow:hidden;width:130px;display:inline-block;text-overflow: ellipsis;">{{ $event->away_team }}</span>
                        @else
                          <span style="overflow:hidden;width:130px;display:inline-block;text-overflow: ellipsis;">{{ $event->away_team }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  </a>
                </td>
              @else
                <td class="text-center">{{ $event->event_title }}</td>
              @endif

               <!--tv schdule Button-->
               <td class="{{ $borderTop }}">
                <div class="row">
                  <div class="col-sm-6 text-center">
                    @if(is_null($event->event_title) || $event->event_title == 'NULL' || empty($event->event_title))
                     <?php
                          $flag = 0;
                         
                            if($event && $event->channels){
                              $var1 = json_decode($event->channels, true);
                              for ($n=0; $n < count($var1); $n++) {
                                $channelsArray = array();
                                try
                                {
                                    $channelsArray = $var1[$n]["channels"];
                                    $flag += 1;
                                                            
                                }
                                catch(Exception $e)
                                {
                                  continue;
                                }
                                $flag2= 0; 
                                for ($l=0; $l<count($channelsArray) ; $l++) { 
                                     
                                  if(strpos($channelsArray[$l]["name"], "."))
                                    {
                                      continue;
                                    } 
                                  $flag2 += 1; 
                                }
                              }
                              if( $flag != 0 ){ 
                                if ($flag2 != 0 ) {
                          ?>

                      <a href="#"  id="show_{{$i}}" class="btn btn-rss mobile-view-tv-button-down" style="width:60px">
                      TV                 
                      </a>
                    <?php }}}?>
                    @else
                     <?php
                          $flag = 0;
                         
                            if($event && $event->channels){
                              $var1 = json_decode($event->channels, true);
                              for ($n=0; $n < count($var1); $n++) {
                                $channelsArray = array();
                                try
                                {
                                    $channelsArray = $var1[$n]["channels"];
                                    $flag += 1;
                                                            
                                }
                                catch(Exception $e)
                                {
                                  continue;
                                }
                                $flag2= 0; 
                                for ($l=0; $l<count($channelsArray) ; $l++) { 
                                     
                                  if(strpos($channelsArray[$l]["name"], "."))
                                    {
                                      continue;
                                    } 
                                  $flag2 += 1; 
                                }
                              }
                              if( $flag != 0 ){ 
                                if ($flag2 != 0 ) {
                          ?>
                      <a href="#"  id="show_{{$i}}" class="btn btn-rss" >TV                
                      </a>
                    <?php }}}?>
                    @endif
                    <!-- Add star icon next to favourite team/com. event -->
                    @if(isset($event->isFav) && $event->isFav == true)
                      <i class="fa fa-1x" aria-hidden="true" style="color: #00222E; font-size: 130%; cursor: default; padding-left: 20px;" title="Favourites"></i>
                    @else
                      <i class="fa fa-fw"></i>
                      <i class="fa fa-fw"></i>
                    @endif
                  </div>
                   <!--Watch Button-->
                  <div class="col-sm-8 text-center">
                    @if(is_null($event->event_title) || $event->event_title == 'NULL' || empty($event->event_title))
                      <a href="{{ secure_url('streams/'.$event->event_id.'/'.$event->home_team_slug.'_vs_'.$event->away_team_slug) }}" class="btn btn-rss mobile-view-watch-button-down">
                      <span class="mobile-view-watch-hide">Watch</span>
                      <i class="fa fa-play mobile-view-watch-show" style="display:none;"></i>
                      @if($event->streams != 0)
                        <span class="count">{{ $event->streams }}</span>
                      @endif
                      </a>
                    @else
                      {{--<a href="{{ secure_url('eventStreams/'.$event->event_id) }}" class="btn btn-rss">--}}
                      <a href="{{ secure_url('streams/'.$event->event_id.'/'.$event->event_title) }}" class="btn btn-rss">
                      Watch
                      @if($event->streams != 0)
                        <span class="count">{{ $event->streams }}</span>
                      @endif
                      </a>
                    @endif
                    <!-- Add star icon next to favourite team/com. event -->
                    @if(isset($event->isFav) && $event->isFav == true)
                      <i class="fa fa-star fa-1x mobile-view-star" aria-hidden="true" style="color: #00222E; font-size: 130%; cursor: default; padding-left: 20px;" title="Favourites"></i>
                    @else
                      <i class="fa fa-fw"></i>
                      <i class="fa fa-fw"></i>
                    @endif
                  </div>
                </div>
              </td>
            </tr>

            <?php
            $flag = 0;
           
              if($event && $event->channels){
                $var1 = json_decode($event->channels, true);
                for ($n=0; $n < count($var1); $n++) {
                  $channelsArray = array();
                  try
                  {
                      $channelsArray = $var1[$n]["channels"];
                      $flag += 1;
                                              
                  }
                  catch(Exception $e)
                  {
                    continue;
                  }
                  $flag2= 0; 
                  for ($l=0; $l<count($channelsArray) ; $l++) { 
                       
                    if(strpos($channelsArray[$l]["name"], "."))
                      {
                        continue;
                      } 
                    $flag2 += 1; 
                  }
                }
                if( $flag != 0 ){ 
                  if ($flag2 == 0 ) {
                    continue;
                  }

            ?>
            <tr style= "background-color:white" competition="{{ $event->competition_name }}">
              <td colspan="6" style="padding:0px; border:0px ">
                <p class="hidden">{{ $event->competition_name }}</p>
                <div id="extra_{{$i}}" style=" display: none;"> 
                  <div class="row tv_row mobile-tv_row">
                    <div class="col-xs-6 tvSchedule_header header_text">
                       Country 
                    </div>
                    <div class="col-xs-5 tvSchedule_header header_text" >
                       Channel 
                    </div>
                    <div class="col-xs-1 tvSchedule_header" style="padding-top:5px">
                      <a href="{{ secure_url('channles/'.$event->event_id.'/'.$event->home_team_slug.'_vs_'.$event->away_team_slug.'/all') }} " style="color:#00222E">
                          All
                      </a>
                    </div>
                  </div>             
            <?php }
                for ($j=0; $j < count($var1); $j++) {
                  $channelsArray = array();
                  try
                  {
                      $channelsArray = $var1[$j]["channels"];                        
                  }
                  catch(Exception $e)
                  {
                    continue;
                  }

                  $flag2= 0; 
                  for ($m=0; $m<count($channelsArray) ; $m++) { 
                       
                    if(strpos($channelsArray[$m]["name"], "."))
                      {
                        continue;
                      } 
                    $flag2 += 1; 
                  }
                  if($flag2 != 0) {
                  
                  ?>
                    <div class="row tv_row mobile-tv_row" id="tv-hover">
                      <div class="col-xs-6 " >
                          <p class="channel_country mobile-view-country"><img src="{{$var1[$j]['flag']}}"></img>&nbsp&nbsp&nbsp <?php echo $var1[$j]["country"]; ?></p> 
                      </div>
                      <div class="col-xs-5 "><p class="channel_name">
                        <?php

                          for ($k=0; $k < count($channelsArray); $k++){
                            if(strpos($channelsArray[$k]["name"], "."))
                            {
                              continue;
                            }
                        ?>
                        <a href="{{ secure_url('channels/'.$var1[$j]['country'].'/'.$channelsArray[$k]['slug'])}}">  
                          <?php echo $channelsArray[$k]["name"]; ?>
                        </a>
                        <?php 
                            if ($k<count($channelsArray)-1) {
                              echo (",  ");
                            }
                          } 
                        ?>
                        </p>
                      </div>
                    </div>
                  
                    <?php
                    } 
                    } ?>          
                </div>
              </td>              
            </tr> 
             <?php 
                  } ?>   
          @endforeach

        @endforeach
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    $(function ($) {
      if (typeof currentZoneOffset !== 'undefined') {
        momentZone = moment.tz.guess();
        currentZoneOffset = moment.tz(momentZone).utcOffset() / 60;
        tz = currentZoneOffset;
      } else {
        var tzOptions = document.getElementById('offset');
        var tz = tzOptions.options[tzOptions.selectedIndex].value;
      }

      $('#competition_selector').on('change', function (e) {

        $("tbody tr").hide();
        if(this.value == "All")
        {
          $("tbody tr").show();  
        }
        else
        {
          $("tbody tr[competition='"+this.value+"']").show();
        }
        
        // table.columns(0).search(this.value).draw();
      });


      // $('#eventsTable').DataTable({
      //   "responsive": true,
      //   "scrollCollapse": true,
      //   "paging": false

      // });

      $('#eventsTable tbody tr').on('click', function () {
        if ($("#eventsTable").find('td').hasClass('matches_divider')) {
          return;
        }
        window.location.href = $("#eventsTable").find('.btn-rss').attr('href');
      });


      // table.search( $('#competition_selector').val() ).draw();
    });

    function notificationAction(el) {
      $.post(
        '{{ secure_url('profile/notificationAction') }}',
        {"_token": "{{ csrf_token() }}", "id": el, "action": 1},
        function (data, status) {
          console.log(data)
        });
    }

    function verifyAlert()
    {
      $.post(
        '{{ secure_url('profile/closeAlert') }}',
        {"_token": "{{ csrf_token() }}"},
        function (data, status) {
          console.log(data)
        });
    }

    function updateScore(updateCheck){
      if(document.getElementById('updateScore').checked){
        var data = [];
        $('.running').each(function(i, obj){
          data.push($(obj).data('id'));
        })

        $.ajax({
          url: document.location.origin + '/updatehomepagescores',
          dataType: 'json',
          data: {
            data: data
          },
          success: function (result) {
            if( !(result['result'] == 0) )
              for (var i = result['result'].length - 1; i >= 0; i--) {
                if(result['result'][i]["event_minute"] != null)
                  $("#running_"+result['result'][i]["event_id"]+"_minute").text("'"+result['result'][i]["event_minute"]);
                if(result['result'][i]["event_status"] != null)
                  $("#running_"+result['result'][i]["event_id"]+"_score").text(result['result'][i]["event_status"]);
              }
          },
          error: function(result) {
          }
        });
      }
    }

    updateScore();

    setInterval(function(){
      updateScore();
    }, 60000)

    $("#updateScore").change(function(){
      var check = document.getElementById('updateScore').checked;
      var url = document.location.origin + '/updatehomepagescores';
      window.location = url + "?check=" + check;
    })

     $("a[id^=show_]").click(function(event) {
      $opened = $(".open");
      $opened.slideToggle("slow");
      $opened.removeClass("open");
      if ($opened.attr('id') != "extra_" + $(this).attr('id').substr(5)){
        $d = $("#"+"extra_" + $(this).attr('id').substr(5));
        $("#extra_" + $(this).attr('id').substr(5)).slideToggle("slow");
        $d.addClass("open");
      }      
      event.preventDefault();
    })
  </script>
@endsection
