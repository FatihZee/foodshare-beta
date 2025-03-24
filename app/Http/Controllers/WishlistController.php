<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('donation')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        Wishlist::create([
            'user_id' => Auth::id(),
            'donation_id' => $request->donation_id
        ]);

        return back()->with('success', 'Makanan ditambahkan ke wishlist!');
    }

    public function destroy($id)
    {
        Wishlist::where('user_id', Auth::id())->where('donation_id', $id)->delete();
        return back()->with('success', 'Makanan dihapus dari wishlist!');
    }
}