@extends('layouts.app')

@section('main')
<div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header  text-white">
                        Welcome, John Doe                        
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('uploads/profile') . '/' . $user->image }}" class="img-fluid rounded-circle" alt="Luna John">                            
                        </div>
                        <div class="h5 text-center">
                            <strong>John Doe</strong>
                            <p class="h6 mt-2 text-muted">5 Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-lg mt-3">
                    <div class="card-header  text-white">
                        Navigation
                    </div>
                    <div class="card-body sidebar">
                         @include('layouts.sidebar')
                    </div>
                </div>                
            </div>
            <div class="col-md-9">                
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0">  
                    <div class="d-flex justify-content-end">
                         
                            <form action="" method="get">
                                <div class="d-flex">
                                    <input type="text" name="keyword" value="{{ Request::get('keyword') }}"
                                        class="form-control" placeholder="keywords">
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    <a href="{{ route('account.reviews') }}" class="btn btn-danger ms-2">Reset</a>
                                </div>
                            </form>
                        </div>          
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Review</th>
                                    <th>Book</th>                                   
                                    <th>Rating</th>
                                    <th>Status</th>  
                                    <th>Created At</th>                                
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if ($all_reviews)   
                                    @foreach ($all_reviews as  $key => $review)                                   
                                    <tr>                                        
                                        <td>{{$review->reviews}} <br> <strong>{{$review->user->name}}</strong>  </td> 
                                        <td>{{$review->book->title}}</td>                                       
                                        <td>{{$review->rating}}.0</td>
                                        @if ($review->status == '1')
                                        <td class="text-success">Active</td>
                                        @else
                                        <td class="text-danger">DeActive</td>                                        
                                        @endif 
                                        <td>{{Carbon\Carbon::parse($review->created)->format('d-M-y')}}</td>                                      
                                        <td>
                                            <a href="edit-review.html" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>  
                                    @endforeach                    
                                    @endif                                                                                               
                                </tbody>
                            </thead>
                        </table> 
                        
                        {{$all_reviews->links()}} 
                    </div>                    
                </div>                
            </div>
        </div>       
    </div>
@endsection
