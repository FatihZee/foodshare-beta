@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $article->title }}</h5>
                </div>
                <div class="card-body">
                    @if($article->image)
                        <div class="text-center mb-3">
                            <img src="{{ $article->image }}" alt="Image" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                    <p class="text-muted">{{ $article->content }}</p>
                    
                    @if($article->video_url)
                        <div class="mt-4 ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($article->video_url, 'v=') }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
