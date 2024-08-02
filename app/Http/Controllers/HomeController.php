<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
// use Nette\Utils\Validators;
 use Illuminate\Support\Facades\Validator;
 


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('CREATED_AT', 'DESC');
        if (!empty($request->keyword)) {
            $books->Where('title', 'like', '%' . $request->keyword . '%');
            $books->orWhere('author', 'like', '%' . $request->keyword . '%');
        }
        $books = $books->where('status', 1)->paginate(8);
        return view('home', [
            'books' => $books
        ]);
    }

    public function details($id)
    {
        $book_details = Book::with(['reviews.user','reviews' => function($query) {
            $query->Where('status',1);
        }])->findOrFail($id);
        
        // dd($book_details);die;
        $relatedBooks = Book::where('status',1)->take(3)->where('id', '!=', $id)->inRandomOrder()->get();
     
        return view('book-details', [
            'book_details' => $book_details,
            'related_books' => $relatedBooks,
        ]);
    }
    //  save review logic :
    public function saveReview(Request $request)
    {
        $validators = Validator::make($request->all(),[
            'reviews' => 'required|min:10',
            'rating' => 'required',
        ]);
        if($validators->fails())
        {
            return response()->json([
                'status' =>false,
                'errors' => $validators->errors(),

            ]);
        } else
        {
            $countReview= Review::where('user_id',Auth::user()->id)->where('book_id',$request->book_id)->count();
            if($countReview > 0)
            {
                session()->flash('error','You already a review this book..');
                return response()->json([
                    'status' =>true,
                    
                ]);
            }
            $data = new Review();
            $data->reviews = $request->reviews;
            $data->rating = $request->rating;
            $data->user_id = Auth::user()->id;
            $data->book_id = $request->book_id;
            $data->save();
            session()->flash('success','Review Added Successfully');
            return response()->json([
                'status' =>true,
                'errors' => 'data submit successfully',
            ]);
        }
    }
}
