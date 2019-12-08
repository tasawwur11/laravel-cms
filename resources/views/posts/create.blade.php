@extends('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
        Post
    </div>
    <div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Post Title" class="form-control" value="{{ isset($post) ? $post->title:'' }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" id="description" name="description" placeholder="Post Description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea type="text" id="content" name="content" placeholder="Post Content" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" placeholder="Post image" class="form-control">
            </div>
            <div class="from-group">
                <button class="btn btn-success float-right" type="submit"> {{ isset($post) ? "Update Post":"Add Post"}} </button>
            </div>
        </form>
    </div>
</div>
@endsection