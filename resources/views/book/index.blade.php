@extends('layouts.app')
@section('title', 'Books')
@section('content')


<div class="container">
    <h1> Books Data</h1>


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

    
    
    <form action="/books" method="GET"
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

    <button class="btn btn-primary" href="#" data-toggle="modal" data-target="#addData"> Tambah Data </button>
    <a href="/get-template-excel" class="btn btn-success" > Template Excel </a>
    <button class="btn btn-warning" href="#" data-toggle="modal" data-target="#addDataImport"> Import Data </button>
    <a class="btn btn-danger" href="/export-pdf" > Export PDF </a>
    <a class="btn btn-dark" href="/export-excel" > Export Excel </a>

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
                    <td>{{ $data->bookCategory != null ? $data->bookCategory->name_category : ''   }}</td>
                    <td>{{ $data->stock }}</td>
                    <td>

                        <button type="button" class="btn btn-warning btn-sm" data-target="#editModal" data-toggle="modal"  data-mytitle="{{ $data->title  }}" data-myauthor="{{$data->author }}"  data-mystock="{{$data->stock }}"   data-mycategory="{{ $data->bookCategory->name_category   }}" data-idcategory="{{ $data->bookCategory->id }}" data-idbook="{{ $data->id_book }}" >
                        <i class="bi bi-pencil-square"></i>
                        </button>



                        <a href="/books/{{ $data->id_book }}"  onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>

                    </td>
                </tr>
                @endforeach

        </tbody>
    </table>
    {{ $books->links() }}
</div>
<!-- Add Data Modal-->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="/books" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Add Book</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""> Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror " name="title" id="title" required placeholder="Input Book Title ...">
                    </div>
                    <div class="form-group">
                        <label for=""> Author</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror " name="author" id="author" required placeholder="Input Book author ...">
                    </div>
               
                    <div class="form-group">
                        <label for=""> Category</label>

                        <select class="form-control" name="id_category" id="exampleFormControlSelect1">

                        @foreach ($categories as $data )
                            
                        <option value="{{ $data->id }}" > {{ $data->name_category   }}</option>
                        @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label for=""> Stock</label>

                        <input type="text" class="form-control " name="stock" id="stock" required placeholder="Input Book Stock ...">
                   

                    </div>
                  `
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                    <button id="btnsend" class="btn btn-primary">Simpan</button>

                </div>
            </form>

        </div>
    </div>
</div>
<!-- Add Data Import-->
<div class="modal fade" id="addDataImport" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="/import-excel" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Add Book</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""> File</label>
                        <input type="file" class="form-control @error('title') is-invalid @enderror " name="file_name" placeholder="Input File ...">
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                    <button type="submit" class="btn btn-primary">Simpan</button>

                </div>
            </form>

        </div>
    </div>
</div>
<!-- Edit Data Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title" id="titleModalEdit">Update Book Data </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="/update-book" method="POST" >
    @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_posisi"> Title</label>
                        <input type="hidden" name="id_book" id="edit-id">
                        <input type="text" data-nama="" class="form-control @error('title') is-invalid @enderror " name="title" id="edit-title" required placeholder="Input Title...">
                    </div>
                    <div class="form-group">
                        <label for="nama_posisi"> Author</label>
                    <input type="text" data-nama="" class="form-control @error('author') is-invalid @enderror " name="author" id="edit-author" required placeholder="Input Author...">
                </div>
                <div class="form-group">
                        <label for=""> Category</label>

                        <select class="form-control" name="id_category" id="select-id">
                            
                            @foreach ($categories as $data )
                            
                            <option value="{{ $data->id }}" > {{ $data->name_category   }}</option>
                            @endforeach
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label for=""> Stock</label>

                        <input type="text" class="form-control " name="stock" id="edit-stock" required placeholder="Input Book Stock ...">
                   

                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    
                </div>
            </form>
                
        </div>
    </div>
</div>







@endsection


@section('jsCustom')

<script>

    
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        
        var title = button.data('mytitle');
        var author = button.data('myauthor');
        var id_book = button.data('idbook');
        var id_category = button.data('idcategory');
        var name_category = button.data('mycategory');
        var stock = button.data('mystock');

        console.log(name_category);
        
        var modal = $(this);
        
        modal.find('.modal-body #edit-title').val(title);
        modal.find('.modal-body #edit-author').val(author);
        modal.find('.modal-body #edit-stock').val(stock);
        modal.find('.modal-body #edit-id').val(id_book);
        modal.find('.modal-body #select-id').val(id_category);
        modal.find('.modal-body #select-category').val(name_category);
        
    });
    
    </script>
@endsection()