@extends('layouts.app')

@section('content')
 
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Post</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('posts.index') }}" enctype="multipart/form-data"> Back</a>
        </div>
    </div>
</div>

@if(session('status'))
<div class="alert alert-success mb-1 mt-1">
    {{ session('status') }}
</div>
@endif

<form action="{{ route('posts.update',$post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Post Title:</strong>
                <input type="text" name="title" value="{{ $post->title }}" class="form-control" placeholder="Post Title">
                @error('title')
                 <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Post Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Post Description">{{ $post->description }}</textarea>
                @error('description')
                 <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Post Image:</strong>
                <input type="file" name="image[]" class="form-control" placeholder="Post Title" multiple="multiple">
                @error('image')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            @if($post->images)
                @foreach ($post->images as $image)
                    @if($image)
                        <img src="{{ Storage::url($image->path) }}" height="75" width="75" alt="" />
                    @endif   
                @endforeach
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary ml-3 mt-3">Update Post</button>
      
    </div>

</form>

@endsection