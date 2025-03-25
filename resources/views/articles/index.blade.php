@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Artikel</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Artikel
        </a>
    </div>
    
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    @if($article->image)
                        <img src="{{ $article->image }}" class="card-img-top" alt="Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $article->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($article->content, 100) }}</p>
                        
                        @if($article->video_url)
                            <div class="ratio ratio-16x9 mb-3">
                                <iframe src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($article->video_url, 'v=') }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                        
                        <div class="d-flex">
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm text-white me-1">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection