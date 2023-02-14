@extends('layouts.app')
@section('title', 'Home')
@section('content')


<div class="container">

    <div> <h1>Books Data</h1>


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
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (auth()->user()->hasRole('member'))


    <form action="/loans" method="GET"
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="s" class="form-control bg-light border-0 small" placeholder="Search for..."
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
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Category</th>
                <th scope="col">Stock</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>


            @if ( count($books) < 1) <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>

                @endif


                @foreach ($books as $data )

                <tr>
                    <td>{{ ++$i }}</td>
                    <td> <a href="/show/{{ $data->id_book }}"> {{  $data->title   }} </a></td>
                    <td>{{ $data->author }}</td>
                    <td>{{ $data->bookCategory->name_category }}</td>
                    <td>{{ $data->stock }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-target="#addData" data-toggle="modal"  data-mytitle="{{ $data->title  }}" data-myauthor="{{$data->author }}"  data-mycategory="{{ $data->bookCategory->name_category   }}" data-idcategory="{{ $data->bookCategory->id }}" data-myidbook="{{ $data->id_book }}" >

                            Borrow
                        </button>


                    </td>
                </tr>
                @endforeach

        </tbody>
    </table>
    {{ $books->links() }}

        
    @endif

</div>

<!-- Borrow Books-->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="/loans" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal"> Books Data</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""> Title</label>
                        <input type="hidden"  class="form-control @error('title') is-invalid @enderror " name="id_book" id="edit-id-book" required >
                        <input type="text" disabled class="form-control @error('title') is-invalid @enderror " name="title" id="title" required placeholder="Input Book Title ...">
                    </div>
                    <div class="form-group">
                        <label for=""> Author</label>
                        <input type="text" disabled class="form-control @error('author') is-invalid @enderror " name="author" id="author" required placeholder="Input Book author ...">
                    </div>
               
                  
                    <div class="form-group">
                        <label for=""> Category</label>

                        <input type="text" disabled class="form-control " name="category" id="category" required placeholder="Input Book Stock ...">
                   

                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                    <button type="submit" class="btn btn-primary">Take it</button>

                </div>
            </form>

        </div>
    </div>
</div>


@endsection


@section('jsCustom')

<script>

    
    $('#addData').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        
        var title = button.data('mytitle');
        var author = button.data('myauthor');
        var id_book = button.data('myidbook');
        var id_category = button.data('idcategory');
        var name_category = button.data('mycategory');
        var stock = button.data('mystock');

        console.log(name_category);
        console.log(id_book);
        
        var modal = $(this);
        
        modal.find('.modal-body #title').val(title);
        modal.find('.modal-body #author').val(author);
        modal.find('.modal-body #stock').val(stock);
        modal.find('.modal-body #edit-id-book').val(id_book);
        modal.find('.modal-body #category').val(name_category);
        
    });
    
    </script>
@endsection()