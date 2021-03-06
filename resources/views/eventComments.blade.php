<div class="panel-group panel-comments" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseComments" aria-expanded="true" aria-controls="collapseOne" role="tab" id="panel-comment" style="cursor:pointer">
        <span class="color-gold"><small style="font-size: 17px;">{{ $comment_count }}</small> COMMENTS</span>
        <i class="fa fa-compress pull-right" aria-hidden="true" style="font-size: 1.5em;"></i>
        <div class="clear-both"></div>
    </div>
    <div id="collapseComments" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="panel-comment">
      <div class="panel-body">
        <div class="event-comments">
          @if(\Illuminate\Support\Facades\Auth::check())
            {{-- registered user comment box --}}
            <form id="postComment" action="{{ secure_url('storeComment') }}" method="post" novalidate>
              <input type="hidden" name="event_id" value="{{ $event_id }}">
              <input type="hidden" name="parent" value="0">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="comment">Your Comment</label>
                <textarea name="comment" class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-default">Send</button>
            </form>
          @else
            <p>Please <a href="{{ secure_url('register') }}">register</a> to add your comment or <a href="{{ secure_url('redditLogin') }}">login with Reddit.</a></p>
          @endif
          {{-- end of registered user comment box --}}
          
          {{-- nested comments --}}
          <div class="row" id="comments-div">
            @if($comments->count()>0)
                @if(count($treeComments)>0)
                  @foreach($treeComments as $comment)
                    @include('partials.comment', ['comment'=>$comment, 'user_comment_count'=>$user_comment_count])
                  @endforeach
                @endif
            @endif
          </div>
          {{-- end of nested comments --}}
        </div>
      </div>
    </div>

    <div class="comment-sort">
      <select class="select" id="commentSort" onchange="getEventComments();">
        <option value="VOTE_DESC" <?php echo $order_type == 'VOTE_DESC' ? 'selected' : ''; ?>>Sort by newest voteup</option>
        <option value="DATE_DESC" <?php echo $order_type == 'DATE_DESC' ? 'selected' : ''; ?>>Sort by newest first</option>
        <option value="DATE_ASC" <?php echo $order_type == 'DATE_ASC' ? 'selected' : ''; ?>>Sort by oldest first</option>
      </select>
    </div>
  </div>
</div>
<style>
  .editable-pre-wrapped {
    white-space: initial !important;
  }
  
  .event-comments {
    padding-bottom: 9px;
    margin: 5px 0 5px;
  }
  
  .event-comments .comment-meta {
    /*border-bottom: 1px solid #eee;*/
    margin-bottom: 5px;
  }
  
 /* .event-comments .media {
    margin-bottom: 5px;
    padding-left: 10px;
  }*/
  
  .event-comments .media-heading {
    font-size: 12px;
    color: grey;
  }

  .event-comments .media-heading .left {
    float: left;
  }

  .event-comments .media-heading .right {
    float: right;
  }

  .event-comments .media-heading .right span {
    margin-left: 2px;
  }
  
  .event-comments .comment-meta a {
    font-size: 12px;
    color: grey;
    font-weight: bolder;
    margin-right: 5px;
  }
  
  #comments-div {
    padding: 15px;
  }
  
  .label-gold-rss {
    background-color: #B3994C;
  }
  
  a.btn-delete {
    color: #FFF !important;
    padding: 1px;
    background-color: red;
    text-decoration: none;
  }
</style>
<br>
