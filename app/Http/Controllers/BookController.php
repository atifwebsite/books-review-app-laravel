<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Validator;
use App\Models\Book;
use Illuminate\Http\Request;


class BookController extends Controller
{
    // This method will show book list page.    
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at', 'DESC');
        // $books = Book::orderBy('created_at', 'DESC')->where('status',1);
        if ($request->keyword) {
            $books->where('title', 'like', '%' . $request->keyword . '%');
            $books->orWhere('author', 'like', '%' . $request->keyword . '%');
        }
        $user = User::find(Auth::user()->id);
        $books = $books->paginate(10);
        return view('books.list', [
            'user' => $user,
            'books' => $books
        ]);
    }

    // This method will create book page.    
    public function create()
    {
        $user = User::find(Auth::user()->id);
        return view('books.create', [
            'user' => $user
        ]);
    }

    // This method will save book details.    
    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();
        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
            $book->save();
        }
        return redirect()->route('books.index')->with('success', 'Books Added Successfully..');
    }
    // This method will edit book details.    
    public function edit($id)
    {
        $user = User::find(Auth::user()->id);
        $book = Book::find($id);
        return view('books.edit', [
            'user' => $user,
            'book' => $book
        ]);

    }

    public function update($id, Request $request)
    {
        $book = Book::find($id);
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('books.edit/', $id)->withInput()->withErrors($validator);
        }
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();
        if (!empty($request->image)) {
            File::delete(public_path('uploads/books/' . $book->image));
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
            $book->save();
        }
        return redirect()->route('books.index')->with('success', 'Books Updated Successfully..');
    }


    // This method will delete book details.    
    public function delete(Request $request)
    {
        $book = Book::find($request->id);
        if ($book == null) {
            session()->flash('eror', 'Book Not Found');
            return response()->json([
                'status' => false,
                'message' => 'Book not found',

            ]);
        } else {
            session()->flash('success', 'Book Deleted successfully');
            File::delete(public_path('uploads/books/' . $book->image)); //delete old image.
            $book->delete();
            return response()->json([
                'status' => true,
                'message' => 'Book Deleted Successfully',
            ]);

        }

    }

    //  books status active deactive:
    public function book_status_active_deactive($id)
    {
        $book_details = Book::find($id);
        if ($book_details) {
            if ($book_details->status) {
                $book_details->status = 0;
            } else {
                $book_details->status = 1;
            }
            $book_details->save();
        }
        return redirect()->route('books.index')->with('success', 'Book Status Updated Successfully..');
    }
}
