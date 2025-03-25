<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ArticleController extends Controller {
    public function index() {
        $articles = Article::latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create() {
        return view('articles.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => [
                'nullable',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([\w-]{11})(\?.*)?$/'
            ]

        ]);
    
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'articles']
            );
            $imageUrl = $uploadedFile['secure_url'];
        }

        $videoId = null;
        if ($request->video_url) {
            preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/)([\w-]{11})#', $request->video_url, $matches);
            $videoId = $matches[1] ?? null;
        }
    
        Article::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imageUrl,
            'video_url' => $videoId,
        ]);
    
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function show(Article $article) {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article) {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article) {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => [
                'nullable',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([\w-]{11})(\?.*)?$/'
            ]

        ]);
    
        $imageUrl = $article->image;
        if ($request->hasFile('image')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'articles']
            );
            $imageUrl = $uploadedFile['secure_url'];
        }

        $videoId = $article->video_url;
        if ($request->video_url) {
            preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/)([\w-]{11})#', $request->video_url, $matches);
            $videoId = $matches[1] ?? null;
        }
    
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imageUrl,
            'video_url' => $videoId,
        ]);
    
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article) {
        if ($article->image) {
            Cloudinary::uploadApi()->destroy($article->image);
        }
        
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}