<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $wishlistCategoryIds = Wishlist::where('user_id', Auth::id())->pluck('category_id')->toArray();

        return view('categories.index', compact('categories', 'wishlistCategoryIds'));
    }

    public function store(Request $request)
    {
        Wishlist::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id // Ganti ke category_id
        ]);

        return back()->with('success', 'Kategori ditambahkan ke wishlist!');
    }

    public function destroy($id)
    {
        Wishlist::where('user_id', Auth::id())->where('category_id', $id)->delete(); // Ganti donation_id ke category_id
        return back()->with('success', 'Kategori dihapus dari wishlist!');
    }
    
    public function toggle(Request $request)
    {
        $userId = Auth::id();
        $categoryId = $request->category_id;

        $wishlist = Wishlist::where('user_id', $userId)
                            ->where('category_id', $categoryId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'category_id' => $categoryId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

}