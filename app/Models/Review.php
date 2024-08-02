<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;



    //  This method will give the usre details 
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // This method will give the book details :
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
