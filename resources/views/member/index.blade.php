@extends('layouts.app')
@section('title', 'Member')
@section('content')


<div class="container">

    <div> <h1>Data Members</h1>


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


    <form action="/member" method="GET"
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    <table class="table mt-2">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>


            @if ( count($users) < 1) <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>

                @endif


                @foreach ($users as $data )

                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                </tr>
                @endforeach

        </tbody>
    </table>
</div>


@endsection