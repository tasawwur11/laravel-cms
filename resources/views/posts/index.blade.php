@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">Add Post</a>
</div>
<div class="card card-default">
    <div class="card-header">
        Posts
    </div>
    <div class="card-body">
        @if($posts->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                <tr>
                    <td><img src="{{ asset('storage/'.$post->image) }}" height="40" width="40" alt=""></td>
                    <td>{{ $post->title }}</td>
                    <td>
                    @if(!$post->trashed())
                    <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-info btn-sm">Edit</a>
                    @endif
                    </td>
                    <td>
                    <form action="{{ route('posts.destroy',$post->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                    {{ $post->trashed() ? 'Delete' : 'Trash' }}
                    </button>
                    </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-center">No Posts Yet</h3>
        @endif
    </div>
</div>
@endsection
