@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ isset($article) ? 'Edit' : 'Buat' }} Artikel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($article)) @method('PUT') @endif
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Konten</label>
                            <textarea name="content" class="form-control" rows="5" required>{{ old('content', $article->content ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar</label>
                            <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                            @if(isset($article) && $article->image)
                                <div class="mt-2">
                                    <img id="imagePreview" src="{{ $article->image }}" alt="Image" class="img-thumbnail" width="150">
                                </div>
                            @else
                                <div class="mt-2">
                                    <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail d-none" width="150">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">URL Video YouTube</label>
                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $article->video_url ?? '') }}">
                            @if(isset($article) && $article->video_url)
                                <div class="mt-2 ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($article->video_url, 'v=') }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('articles.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
