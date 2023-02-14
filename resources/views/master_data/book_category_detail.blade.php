@extends('layouts.app')
@section('title', 'Data Book Category')
@section('content')


<div class="container">
    <h1>Data Book Category</h1>


    <a href="{{url()->previous()}}" class="btn btn-primary"> Back</a>


    <div class="card mt-2">
        <div class="card-body">
            
        <label>Name Category</label>
            <input type="text" class="form-control" disabled value="{{$category->name_category}}" id="name_category">
        </div>
    </div>


</div>



@endsection

@section('jsCustom')

<script>


</script>
@endsection