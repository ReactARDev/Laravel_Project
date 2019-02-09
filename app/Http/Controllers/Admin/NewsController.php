<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use App\Nation;
use App\Sport;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\News;
use Carbon\Carbon;
use Datatables;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
  
  public function index()
  {
    $news = new News;
    $allNews = $news->getAllNews();
    return view('admin.news')->withNews($allNews);
  }
  
  public function delete($newsId)
  {
    $news = News::find($newsId);
    $news->delete();
    Cache::flush();
    echo true;
  }
  
  public function createNews()
  {
     return view('admin.createNews');
    
  }
  
  public function storeNews(Request $request)
  {
    
  }
  
  public function createMatch()
  {
    
  }
  
  public function storeMatch(Request $request)
  {
  }


  public function updateEventDate(Request $request, $eventId)
  {
    
  }
}