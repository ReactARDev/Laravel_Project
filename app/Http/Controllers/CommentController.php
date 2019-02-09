<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Cvotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\Event;
use App\Notification;

class CommentController extends BaseController
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function storeComment(Request $request)
  {
    try {
      $comment = new Comment;
      $comment->event_id = $request->event_id;
      $comment->comment = $request->comment;
      $comment->parent = $request->parent;
      $comment->user_id = Auth::id();
      $comment->save();
      if ($comment) {
        $userArr = Array();
        preg_match_all('/(@\w+)/', $comment->comment, $userArr);

        $me = User::find(Auth::id());
        $event = Event::find($comment->event_id);

        $subject = $me->name . "&nbsp;has mentioned about you in the comment";
        $permalink = secure_url('streams/'.$event->event_id.'/'.$event->homeTeam->team_slug.'_vs_'.$event->awayTeam->team_slug);
        $body = $me->name . " has mentioned you from the following comment.";
        $body .= "\n" . $comment->comment;
        // $body .= "\n" . $commentId;


        foreach($userArr[1] as $username) {
          $targetUsers = User::where('name', substr($username, 1))->get();
          
          foreach ($targetUsers as $t) {
            $message = new Notification;
            $message->actor_id  = Auth::id();
            $message->target_id   = $t->id;
            $message->message   = $body;
            $message->action    = 0;
            $message->type    = 1;
            $message->title     = $subject;  
            $message->link = $permalink;
            $message->id = $comment->id;
            $message->save();
          }
        }

        $comments = \App\Comment::all();
        $userCommentCount = Array();
        foreach($comments as $comment) {
          $userCommentCount[$comment->id] = Comment::where(['user_id' => $comment->user_id ])->count();
        }

        Cache::flush();
        return view('eventCommentTemplate', ['comment' => Comment::find($comment->id), 'userCommentCount' => $userCommentCount]);
      } else {
        return response()->json(['status', 0]);
      }
    } catch (\Exception $exception) {
        return response()->json($exception->getMessage());
      }
  }

  public function storeStreamComment(Request $request)
  {
    try {
      $comment = new Comment;
      $comment->event_id = $request->event_id;
      $comment->comment = $request->comment;
      $comment->parent = $request->parent;
      $comment->user_id = Auth::id();
      $comment->save();
      if ($comment) {
        $userArr = Array();
        preg_match_all('/(@\w+)/', $comment->comment, $userArr);

        $me = User::find(Auth::id());
        $event = Event::find($comment->event_id);

        $subject = $me->name . "&nbsp;has mentioned about you in the comment";
        $permalink = secure_url('streams/'.$event->event_id.'/'.$event->homeTeam->team_slug.'_vs_'.$event->awayTeam->team_slug);
        $body = $me->name . " has mentioned you from the following comment.";
        $body .= "\n" . $comment->comment;
        // $body .= "\n" . $commentId;


        foreach($userArr[1] as $username) {
          $targetUsers = User::where('name', substr($username, 1))->get();
          
          foreach ($targetUsers as $t) {
            $message = new Notification;
            $message->actor_id  = Auth::id();
            $message->target_id   = $t->id;
            $message->message   = $body;
            $message->action    = 0;
            $message->type    = 1;
            $message->title     = $subject;  
            $message->link = $permalink;
            $message->id = $comment->id;
            $message->save();
          }
        }

        $comments = \App\Comment::all();
        $userCommentCount = Array();
        foreach($comments as $comment) {
          $userCommentCount[$comment->id] = Comment::where(['user_id' => $comment->user_id ])->count();
        }

        Cache::flush();
        return view('streamComments', ['comment' => Comment::find($comment->id), 'userCommentCount' => $userCommentCount]);
      } else {
        return response()->json(['status', 0]);
      }
    } catch (\Exception $exception) {
        return response()->json($exception->getMessage());
      }
  }


 
  public function deleteComment(Request $request)
  {
    $comment_id = $request->id;
    Comment::where('id', $request->id)->orWhere('parent', $request->id)->delete();
    Cvotes::where('comment_id', $comment_id)->delete();
    Cache::flush();
  }
  public function replyComment(Request $request){
    $comment = new Comment;
    $comment->event_id = $request->event_id;
    $comment->comment = $request->comment;
    $comment->parent = $request->parent;
    if ($request->stream_id) {
      $comment->stream_id = $request->stream_id;
    }
    $comment->user_id = Auth::id();
    $comment->save();

    $comments = \App\Comment::all();
    $userCommentCount = Array();
    foreach($comments as $comment) {
      $userCommentCount[$comment->id] = Comment::where(['user_id' => $comment->user_id ])->count();
    }

    if ($comment) {
      Cache::flush();
      return view('eventCommentReplyTemplate', ['reply' => Comment::find($comment->id), 'userCommentCount' => $userCommentCount]);
    } else {
      return response()->json(['status', true]);
    }
  }
  
  public function updateComment(Request $request)
  {
    $comment = Comment::find($request->pk);
    $comment->comment = $request->value;
    $comment->save();
    Cache::flush();
  }
  
  public function voteComment(Request $request){
    $commentId = $request->comment_id;
    if (Cvotes::where(['comment_id' => $commentId, 'user_id' => Auth::id()])->count() > 0 ||  Cvotes::where(['comment_id' => $commentId, 'ip' => $this->get_client_ip()])->count() > 0) {
      return response()->json(['msg' => 'you already voted!']);
    }
    elseif (Comment::where(['id' => $commentId])->first()->user_id == Auth::id()) {
      return response()->json(['msg' => 'You can\'t vote on your own comment!']);
    }else{
      $vote = new Cvotes;
      $vote->user_id = Auth::id();
      $vote->ip = $this->get_client_ip();
      $vote->comment_id = $commentId;
      $vote->save();
      Cache::flush();
    }
    
  }
  
  public function voteCommentDown(Request $request)
  {
    $commentId = $request->comment_id;
    if (Cvotes::where(['comment_id' => $commentId, 'user_id' => Auth::id()])->count() == 0) {
      return response()->json(['msg' => 'you didn\'t vote yet!']);
    } elseif (Comment::where(['id' => $commentId])->first()->user_id == Auth::id()) {
      return response()->json(['msg' => 'You can\'t vote on your own comment!']);
    } else {
      Cvotes::where(['comment_id' => $commentId, 'user_id' => Auth::id()])->delete();
      Cache::flush();
    }
  }

  public function getPostCount(Request $request)
  {
    $userCommentCount = Comment::where(['user_id' => $request->user_id ])->count();
    return response()->json(['status' => true, 'count' => $userCommentCount]);
  }

  public function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
}
