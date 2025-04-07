<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->get();
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('photo')->getRealPath(),
                ['folder' => 'rating-photo']
            );
            $photoUrl = $uploadedFile['secure_url'];
        }

        Review::create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photo' => $photoUrl,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan!');
    }

    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            return redirect()->route('reviews.index')->with('error', 'Anda tidak memiliki izin.');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            return redirect()->route('reviews.index')->with('error', 'Anda tidak memiliki izin.');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('photo')) {
            if ($review->photo) {
                $publicId = pathinfo(parse_url($review->photo, PHP_URL_PATH), PATHINFO_FILENAME);
        
                Cloudinary::uploadApi()->destroy($publicId);
            }
        
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('photo')->getRealPath(),
                ['folder' => 'rating-photo']
            );
            $updateData['photo'] = $uploadedFile['secure_url'];
        }
        

        $review->update($updateData);
        return redirect()->route('reviews.index')->with('success', 'Review berhasil diperbarui!');
    }

    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            return redirect()->route('reviews.index')->with('error', 'Anda tidak memiliki izin.');
        }

        if ($review->photo) {
            $publicId = pathinfo(parse_url($review->photo, PHP_URL_PATH), PATHINFO_FILENAME);
            Cloudinary::uploadApi()->destroy($publicId, ['invalidate' => true]);
        }

        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}