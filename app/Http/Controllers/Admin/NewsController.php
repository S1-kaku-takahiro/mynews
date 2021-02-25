<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

use App\History;

use Carbon\Carbon;

use Storage;

class NewsController extends Controller
{
    public function add()
    {
        return view('admin.news.create');
    }
    
    public function create(Request $request)
    {
        $this->validate($request, News::$rules);
        
        $news = new News;
        $form = $request->all();
        
        if (isset($form['image'])) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $news->image_path = Storage::disk('s3')->url($path);
        } else {
            $news->image_path = null;
        }
        
        unset($form['_token']);
        unset($form['image']);
        
        $news->fill($form);
        $news->save();
        
        return redirect('admin/news/create');
    }
    
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果取得
            $posts = News::where('title', $cond_title)->get();
        } else {
            // 全てのニュースを取得する
            $posts = News::all();
        }
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function edit(Request $request)
    {
        // News Modelからデータ取得
        $news = News::find($request->id);
        If (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit', ['news_form' => $news]);
    }
    
    public function update(Request $request)
    {
        // Validation
        $this->validate($request, News::$rules);
        // News Modelからデータ取得
        $news = News::find($request->id);
        // 送信されてきたフォームデータを格納する
        
        $news_form = $request->all();
        
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $news->image_path = Storage::disk('s3')->url($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }
        
        unset($news_form['image']);
        unset($news_form['remove']);
        unset($news_form['_token']);
        
        // 該当データを上書き保存
        $news->fill($news_form)->save();
        
        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();
        
        return redirect('admin/news');
    }
    
    public function delete(Request $request)
    {
        $news = News::find($request->id);
        
        $news->delete();
        return redirect('admin/news/');
    }
}