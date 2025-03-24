@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tambah Review</h2>
        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Rating -->
            <div class="mb-3">
                <label class="form-label fw-bold">Rating</label>
                <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star rating-star text-secondary" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="1">
            </div>

            <!-- Komentar -->
            <div class="mb-3">
                <label for="comment" class="form-label fw-bold">Komentar</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Foto Review -->
            <div class="mb-3">
                <label class="form-label fw-bold">Foto Review</label>
                <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                <div class="mt-2">
                    <img id="photoPreview" src="#" alt="Review Photo" class="img-fluid rounded d-none" style="max-height: 200px; object-fit: cover;">
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

<!-- Script untuk bintang rating dan preview gambar -->
<script>
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('click', function () {
            let value = this.getAttribute('data-value');
            document.getElementById('ratingInput').value = value;
            document.querySelectorAll('.rating-star').forEach(s => {
                s.classList.remove('text-warning');
                s.classList.add('text-secondary');
            });
            for (let i = 0; i < value; i++) {
                document.querySelectorAll('.rating-star')[i].classList.remove('text-secondary');
                document.querySelectorAll('.rating-star')[i].classList.add('text-warning');
            }
        });
    });

    function previewImage(event) {
        let reader = new FileReader();
        reader.onload = function () {
            let output = document.getElementById('photoPreview');
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
