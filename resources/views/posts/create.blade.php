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
        <form action="{{ isset($post) ? route('posts.update',$post->id):route('posts.store') }}" method="post" enctype="multipart/form-data">
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
                <textarea type="text" id="description" name="description" placeholder="Post Description" class="form-control">{{ isset($post) ? $post->description:'' }}</textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <input id="content" type="hidden" name="content">
                <trix-editor input="content">{{ isset($post) ? $post->content:'' }}</trix-editor>
                <!-- <textarea type="text" id="content" name="content" placeholder="Post Content" class="form-control">{{ isset($post) ? $post->content:'' }}</textarea> -->
            </div>
            <div class="form-group">
                <label for="published_at">Published At</label>
                <input type="text" id="published_at" name="published_at" class="form-control" value="{{ isset($post) ? $post->published_at:'' }}">
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

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr('#published_at',{
    enableTime: true
});
</script>
@endsection

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
