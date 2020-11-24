@extends('layouts.app')

@section('content')

<style>
 /* .tales {
  width: 100%;
}*/

</style>
    <div class="container">
         <h1>Image Stock</h1>

         @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
         
         @endif

        @foreach($posts as $post)
            <div class="row blog-post">
                <div class="col-sm-12 title">
                    <h3 class="mt-4">{{$post->title}}</h3>
                    <p class="mt-4 lead">by {{$post->user->name}}</p>
                </div>

                <div class="row card w-100">
                    <div id="carouselExampleControls_{{$post->id}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <!-- <div class="card"> -->
                                @foreach($post->images as $indexKey => $image)
                                    @if($indexKey == 0)
                                        <div class="carousel-item active img-fluid">
                                        
                                            <figure class="figure">
                                                <img class="d-block w-100" src="{{ asset('post-images/' . $image->name )}}" alt="{{$image->name}}">
                                                <figcaption class="figure-caption">Posted by {{$post->user->name}}</figcaption>
                                            </figure>
                                    
                                        </div>
                                    
                                    @else
                                        <div class="carousel-item img-fluid">
                                            <figure class="figure">
                                                <img class="d-block w-100" src="{{ asset('post-images/' . $image->name )}}" alt="{{$image->name}}">
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

                </div>

                @guest


                @else
                <div class="row interaction card">
                     
                    <div class="col-sm-6">
                        <a href="javascript:void(0)"
                        class="btn btn-info btn-lg"
                        id = "like_{{$post->id}}"
                        onclick="like_update('{{$post->id}}')"
                        >
                        <span class="glyphicon glyphicon-thumbs-up text-white" >  <span id="loop_like_{{$post->id}}">
                        {{$post->like}}  
                        </span></span> 
                        </a>
                    </div>

                  
                </div>
                 @endguest

              

            </div>
            <hr>
            @endforeach
    </div>

    

    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        ></script>
    <script>
        function like_update(id){
            $("#like_"+id).attr("disabled", true);
            $("#like_"+id).css(
                'pointer-events', 'none'
            );
            var cur_count = jQuery('#loop_like_'+id).html();
            cur_count++;
            jQuery('#loop_like_'+id).html(cur_count);
            
            $.ajaxSetup(
                {
                    headers : { 'X-CSRF-Token' : '{{csrf_token()}}' }
                }
            )
            var url = '{{url ('like') }}';
            var data = {
                'like_count' : cur_count,
                'post_id' : id,
                };
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                success : function(response){
                    console.log('Success');
                    // $("#like_"+id).attr("disabled", false);
                },
                error:function(error){
                    console.log(error);
                }
            })

        }

        
    </script>
@endsection