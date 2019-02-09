<div class="media{{ (!$comment->parent)?' parent_comment':'' }}"  id="comment_{{ $comment->id }}" data-votes="{{ $comment->votes }}">

    <!-- first comment -->
    <div class="avatar-image">
        @if (file_exists('images/avatar' . '/' . Auth::User()->id . '.jpg'))
            <img src="{{ secure_url('images/avatar') . '/' . Auth::User()->id . '.jpg' }}">
        @else
            <img src="{{ secure_url('images/noimage/no-image.png') }}">
        @endif
    </div>

    <div class="comment-content">
        <div class="media-heading">
            <div class="left">
                <!-- <button class="btn btn-default btn-xs collapse_button" type="button" data-parent="#comment_{{ $comment->id }}" data-toggle="collapse" data-target="#commentId_{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">
                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                </button> -->
                <span class="label label-gold-rss user_name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                        <small>(Moderator)</small>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->role==2)
                        <small>(Admin)</small>
                    @endif
                @endif
                &nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans() }}
            </div>
            <div class="right">
                <b><span class="votes_count">{{ ($comment->votes)?$comment->votes:'0' }}</span>votes</b>
                <span class="done" style="display: {{ ($comment->is_voted) ? 'inline':'none' }}" onclick="CommentVoteDown(this,'{{ $comment->id }}')">
                    <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                </span>
                <span class="vot" style="display: {{ ($comment->is_voted) ? 'none':'inline' }}" onclick="CommentVoteUp(this,'{{ $comment->id }}')">
                    <i class="fa fa-thumbs-up fa-2x" style="color: #a4a4a4;" aria-hidden="true"></i>
                </span>
                <span class="vot" style="display: {{ ($comment->is_voted) ? 'none':'inline' }}" onclick="CommentVoteDown(this,'{{ $comment->id }}')">
                    <i class="fa fa-thumbs-down fa-2x" style="color: #a4a4a4;" aria-hidden="true"></i>
                </span>

                 @if(\Illuminate\Support\Facades\Auth::id() == $comment->user_id)
                    <a href="javascript:void(0)" onclick="editComment(event,'{{ $comment->id }}')">
                        <i class="glyphicon glyphicon-pencil" style="color: #a4a4a4; font-size: 20px;"></i>
                    </a>
                @endif
                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role>=1)
                    <span>
                        <a class="delete_button" href="javascript:void(0)" onclick="deleteComment({{ $comment->id }})">
                            <i class="glyphicon glyphicon-remove fa-2x" style="color: #a4a4a4;"></i>
                        </a>
                    </span>
                @endif
                @if(\Illuminate\Support\Facades\Auth::check())
                    <span><a class="reply_button" role="button" data-toggle="collapse" href="#replyComment_{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-reply fa-2x" style="color: #a4a4a4;" aria-hidden="true"></i></a></span>
                @else
                    <span><a class="reply_button" href="" onclick="event.preventDefault();sweetAlert('Oops...', 'Only registered user have the ability to reply on comments!', 'error');"><i class="fa fa-reply fa-2x" style="color: #a4a4a4;" aria-hidden="true"></i></a></span>
                @endif
            </div>
            <div class="collapse" id="replyComment_{{ $comment->id }}">
                <form class="comment-reply-form" method="post" action="{{ secure_url('replyComment') }}" novalidate>
                    {{ csrf_field() }}
                    <input type="hidden" name="event_id" value="{{ $comment->event_id }}">
                    <input type="hidden" name="parent" value="{{ $comment->id }}">
                    @if(isset($stream))
                    <input type="hidden" name="stream_id" value="{{ $stream->stream_id }}">
                    @endif
                    <div class="form-group">
                        <label for="comment">Your Reply</label>
                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Send</button>
                </form>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="panel-collapse collapse in" id="commentId_{{ $comment->id }}">
            <!-- media-left -->
            <div class="media-body">
                <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                <div id="commentContent_{{ $comment->id }}" data-validate="validateEdit(value)" class="comment_content editable" data-pk="{{ $comment->id }}" data-type="textarea" data-url="{{ secure_url('updateComment') }}"
                    data-toggle="manual" data-title="Enter comment" data-placement="top" data-inputclass="form-control">
                    {!! nl2br($comment->comment) !!}
                </div>
            </div>
        </div>
    </div>
    <!-- comments -->
</div>