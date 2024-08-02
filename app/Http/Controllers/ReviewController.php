<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $all_reviews = Review::with('book','user')->orderBy('created_at','DESC');
        if($request->keyword)
        {
            $all_reviews->where('reviews','like','%'.$request->keyword.'%');
        }
        $all_reviews = $all_reviews->paginate(10);
        // dd($all_reviews);
        $user = User::find(Auth::user()->id);
        return view('account.review.list',[
            'all_reviews' => $all_reviews,
            'user' => $user,
        ]);
        
    }
}
