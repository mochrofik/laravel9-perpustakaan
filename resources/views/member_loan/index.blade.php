@extends('layouts.app')
@section('title', 'Loans')
@section('content')


<div class="container">

    <div> <h1>Member Loans Data</h1>


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

    @if (auth()->user()->hasRole('admin'))


    <form action="/member-loans" method="GET"
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
                <th scope="col">Member Name</th>
                <th scope="col">Title</th>
                <th scope="col">Date Loan</th>
                <th scope="col">Date Return</th>
                <th scope="col">Penalty</th>
            </tr>
        </thead>
        <tbody>


            @if ( count($loans) < 1) <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>

                @endif


                @foreach ($loans as $data )

                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $data->memberLoan->name }}</td>
                    <td>{{ $data->haveBook->title }}</td>
                    <td>{{ $data->date_loan }}</td>
                    <td>{{ $data->date_return }}</td>
                    <td>@currency($data->penalty) </td>
                    <td>

                    </td>
                </tr>
                @endforeach

        </tbody>
    </table>


        
    @endif

</div>



@endsection


@section('jsCustom')

<script>

    
    </script>
@endsection()