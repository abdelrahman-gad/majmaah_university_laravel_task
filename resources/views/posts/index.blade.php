@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-8 offset-1 margin-tb">
        <div class="pull-left">
            <h2>Laravel 8 Post CRUD Tutorial</h2>
        </div>
        <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('posts.create') }}"> Create New Post</a>
        </div>
    </div>
</div>

@include('layouts.alerts.success')

<div class="row">
    <div class="col-9 offset-1">
        <table class="table table-bordered">
            <tr>
                <th>S.No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>
                     @if($post->images)
                      @foreach ($post->images as $image)
                        @if($image)
                         <img src="{{ Storage::url($image->path) }}" height="75" width="75" alt="" />
                        @endif   
                      @endforeach
                    @endif
                </td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->description }}</td>
                <td>
                    <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
        
                        <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
        
                        @csrf
                        @method('DELETE')
          
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table> 
        <div class="d-felx justify-content-center">

            {{ $posts->links('pagination::bootstrap-4') }}

        </div>
    </div>
</div>




@endsection