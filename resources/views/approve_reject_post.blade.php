@extends('layouts.app')

@section('content')


<body>
    <style>
        .btn-wrapper .btn-secondary{
  line-height:1;
}
    </style>


<div class="container">

@if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
         
@endif

         <h1>Image Stock</h1>
        @foreach($posts as $post)
        <div class="row blog-post" id="post_{{$post->id}}">
                <div class="col-sm-12 title">
                <h3 class="mt-4">{{$post->title}}</h3>
                    <p class="mt-4 lead">by {{$post->user->name}}</p>
                    <p class="lead">Created at {{$post->created_at}}</p>
                </div>

                <div class="row card w-100">
                    <div id="carouselExampleControls_{{$post->id}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <!-- <div class="card"> -->
                                @foreach($post->images as $indexKey => $image)
                                    @if($indexKey == 0)
                                        <div class="carousel-item active img-fluid">
                                        
                                            <figure class="figure">
                                                <img class="d-block w-100" src="{{ asset('post-images/' . $image->name )}}" alt="First slide">
                                                <figcaption class="figure-caption">Posted by {{$post->user->name}}</figcaption>
                                            </figure>
                                    
                                        </div>
                                        @else
                                
                                        <div class="carousel-item img-fluid">
                                            <figure class="figure">
                                                <img class="d-block w-100" src="{{ asset('post-images/' . $image->name )}}" alt="Second slide">
                                                <figcaption class="figure-caption">Posted by {{$post->user->name}}</figcaption>
                                            </figure>
                                        
                                        </div>
                                        @endif
                                
                                
                                    
                                @endforeach
                            <!-- </div> -->
                        </div> 
                        <a class="carousel-control-prev" href="#carouselExampleControls_{{$post->id}}" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls_{{$post->id}}" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                        </a>
                    </div>  
                    <div class="btn-wrapper text-center d-flex justify-content-between">
                        <a href="javascript:void(0)"
                        class="btn btn-primary  btn-lg text-white d-flex align-items-center"
                        id = "approve_{{$post->id}}"
                        onclick="approve_update('{{$post->id}}')"
                        >
                        Approve
                        </a>
                        <a href="javascript:void(0)"
                        class="btn btn-danger btn-lg"
                        id = "reject_{{$post->id}}"
                        onclick="reject_update('{{$post->id}}')"
                        >
                        Reject
                        </a>
                    </div>
                </div> 

              

            </div>
            <hr>
            @endforeach
    </div>

    
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    ></script>

    <script>
        function approve_update(id){
            $("#approve_"+id).attr("disabled", true);
            $("#approve_"+id).css(
                'pointer-events', 'none'
            );

            $.ajaxSetup(
                {
                    headers : { 'X-CSRF-Token' : '{{csrf_token()}}' }
                }
            )
            var url = '{{url ('post/approved') }}';
            var data = {
                'post_id' : id,
                };
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                success : function(response){
                    console.log('Success');
                    $("#post_"+id).remove();
                },
                error:function(error){
                    console.log(error);
                }
            })

        }

        function reject_update(id){
            $("#reject_"+id).attr("disabled", true);
            $("#reject_"+id).css(
                'pointer-events', 'none'
            );
            $.ajaxSetup(
                {
                    headers : { 'X-CSRF-Token' : '{{csrf_token()}}' }
                }
            )
            var url = '{{url ('post/rejected') }}';
            var data = {
                'post_id' : id,
                };
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                success : function(response){
                    $("#post_"+id).remove();
                    // console.log('Success');
                    // console.log(response);
                },
                error:function(error){
                    // console.log(error);
                }
            })


        }
    </script>

@endsection