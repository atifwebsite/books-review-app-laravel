@extends('layouts.app')

@section('main')
    <div class="container mt-3 ">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <a href="index.html" class="text-decoration-none text-dark ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
                </a>
                <div class="row mt-4">
                    <div class="col-md-4">
                        @if ($book_details->image)
                            <a href="{{ route('book.details', $book_details->id) }}"><img
                                    src="{{ asset('uploads/books/' . $book_details->image) }}" alt=""
                                    class="card-img-top"></a>
                        @else
                            <a href="detail.html"><img src="  https://placehold.co/600x920?text=No Image" alt=""
                                    class="card-img-top"></a>
                        @endif
                    </div>
                    <div class="col-md-8">
                        @include('layouts.message')
                        <h3 class="h2 mb-3">{{ $book_details->title }}</h3>
                        <div class="h4 text-muted">{{ $book_details->author }}</div>
                        <div class="star-rating d-inline-flex ml-2" title="">
                            <span class="rating-text theme-font theme-yellow">5.0</span>
                            <div class="star-rating d-inline-flex mx-2" title="">
                                <div class="back-stars ">
                                    <i class="fa fa-star " aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <div class="front-stars" style="width: 100%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="theme-font text-muted">(0 Review)</span>
                        </div>
                        <div class="content mt-3">
                            {{ $book_details->description }}
                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h2 class="h3 mb-4">Readers also enjoyed</h2>
                            </div>
                            @if ($related_books)
                            @foreach ($related_books as $row )
                            <div class="col-md-4 col-lg-4 mb-4">
                                <div class="card border-0 shadow-lg">
                                <a href="{{route('book.details',$row->id)}}">
            <img src="{{asset('uploads/books/'.$row->image)}}" alt="" class="card-img-top">
</a>
                                    <div class="card-body">
                                
                                          <h3 class="h4 heading">  <a href="{{route('book.details',$row->id)}}"> </a>  </a>   {{$row->title}}</h3>

                                        <p>by {{$row->author}}</p>
                                        <div class="star-rating d-inline-flex ml-2" title="">
                                            <span class="rating-text theme-font theme-yellow">0.0</span>
                                            <div class="star-rating d-inline-flex mx-2" title="">
                                                <div class="back-stars ">
                                                    <i class="fa fa-star " aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <div class="front-stars" style="width: 70%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="theme-font text-muted">(0)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            @endforeach                            
                            @endif
                            
                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12  mt-4">
                                <div class="d-flex justify-content-between">
                                    <h3>Reviews</h3>
                                    <div>
                                    <!-- Button trigger modal -->
                                        @if (Auth::check())
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Add Review
                                    </button>
                                @else
                                <a  class="btn btn-primary" href="{{route('account.login')}}"> Add Review</a>
                                        
                                        @endif                       

                                    <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header bg-primary text-light">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Review</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" id="NewRegistration" name="bookReviewForm">
                                    <input type="hidden" name="book_id" value="{{$book_details->id}}">
                                    <div class="modal-body"><div class="mb-3"><label for="reviews" class="form-label">Review</label><textarea name="reviews" id="reviews" class="form-control" cols="5" rows="5" placeholder="Add Your Review"></textarea>
                                    <p class="invalid-feedback" id="review-error"></p>
                                </div><div class="mb-3"><label for="rating" class="form-label">Rating</label><select name="rating" id="rating" class="form-control">                              
                                    <option value="1">1</option>
                                    <option value="2">2</option
                                    ><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
                                <p class="invalid-feedback" id="rating-error"></p>
                            </div></div><div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Add Review</button></div></div></div>
                            </form>   
                            </div>                                     

                                    </div>
                                </div>
                                    @if ($book_details->reviews->isNotEmpty())
                                    @foreach ($book_details->reviews as $review )   
                                   
                                <div class="card border-0 shadow-lg my-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-3">{{$review->user->name}}</h4>
                                            <!-- FOR DATE PRINT USING CARBON LIBRARY -->
                                                <span class="text-muted">{{\Carbon\Carbon::parse($review->created_at)->format('d-M-Y')}}</span>
                                        </div>
                                        @php
                                        $rating_percent = (($review->rating / 5) * 100);
                                        @endphp
                                        <div class="mb-3">
                                            <div class="star-rating d-inline-flex" title="">
                                                <div class="star-rating d-inline-flex " title="">
                                                    <div class="back-stars ">
                                                        <i class="fa fa-star " aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{ $rating_percent }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="content">
                                            <p>
                                                {{$review->reviews}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div>
                                    Reviews Not Found.
                                </div>
                                @endif  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @section('script')
    <script>
    $(document).ready(function() {
        $(document).on('submit', '#NewRegistration', function(e) {
            e.preventDefault();
            var form_data = $('#NewRegistration').serialize();
            // alert('hello ');
            $.ajax({
                url: '{{route("book.saveReview")}}',
                type: 'POST',
                dataType: 'json',
                data: form_data,
                headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                success: function(response) {
                    console.log(response);
                    if(response.status == false)
                {
                    var errors = response.errors;
                    if(errors.review)
                {
                    $('#reviews').addClass('is-invalid');
                    $('#review-error').html(errors.review);

                }else{
                    $('#reviews').removeClass('is-invalid');
                    $('#review-error').html('');

                }
                } else{
                    window.location.href = '{{route("book.details",$book_details->id)}}';

                }
                     
                }
            });
        });

    });
    </script>
    
    @endsection
