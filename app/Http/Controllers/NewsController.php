<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    
    public function index()
    {
		$news = \App\Models\News::latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    
    public function create()
    {
        return view('news.create');
    }

    
    public function store(Request $request)
    {
        News::create($request->all());
        return redirect()->route('news.index');
    }

    
    public function show($id)
    {// Lấy bài viết
    $news = News::findOrFail($id);
    // Lấy comment mới nhất, phân trang 5 bình luận/trang
    $comments = $news->comments()->latest()->paginate(5);
    return view('news.show', compact('news', 'comments'));
    }

    
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));

    }

   
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());
        return redirect()->route('news.index');

    }

    
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('news.index');
    }
}
