@extends('layouts.app')
@section('title', 'Home')
@section('content')


<div class="container">

    <div>
        <h1>HOME</h1>


    </div>


    @if (session()->has('success'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @endif
    @if (session()->has('error'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-primary"> Back</a>


    <div class="card">

        <div class="card-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" disabled value="{{ $book->title}}">
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" class="form-control" disabled value="{{ $book->author}}">
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" class="form-control" disabled value="{{ $book->bookCategory->name_category}}">
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="text" class="form-control" disabled value="{{ $book->stock}}">
            </div>
        </div>
    </div>


</div>


@endsection