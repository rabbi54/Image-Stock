@extends('layouts.app')

@section('content')

<h1 class="mx-auto text-center">Image Stock</h1>

@if (Session::has('msg'))
<div class="alert alert-warning" role="alert">
{{Session::get('msg')}}
</div>

@endif 

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
        <div class="col d-flex justify-content-center">
            <div class="card mx-auto text-center">
                    <div class="card-header">
                        <h3>Create Your Post: </h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                            <label for="postTitle">Post Title</label>
                            <input type="text" class="form-control" required name="title" id="postTitle" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                            <input type="file" multiple = 'multiple' name="images[]" id="image">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>   
                    </div>
            </div>
        </div>
</div>


@endsection