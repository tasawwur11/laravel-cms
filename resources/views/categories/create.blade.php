@extends('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
        {{ isset($category) ? "Edit":"Create"}} Category
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
        <form action="{{ isset($category) ? route('category.update',$category->id) : route('category.store') }}" method="post">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Category Name" class="form-control" value="{{ isset($category) ? $category->name:'' }}">
            </div>
            <div class="from-group">
                <button class="btn btn-success" type="submit"> {{ isset($category) ? "Update Category":"Add Category"}} </button>
            </div>
        </form>
    </div>
</div>
@endsection