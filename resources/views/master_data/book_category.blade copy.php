@extends('layouts.app')
@section('title', 'Master Data Book Category')
@section('content')


<div class="container">
    <h1>Master Data Book Category</h1>


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


    
      <form action="/book-categories" method="GET"
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

    <table class="table mt-2">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="list_categories">

        <div ></div>


        

        </tbody>
    </table>


    <div id="link"></div>
 
</div>
<!-- Add Data Modal-->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title" id="addModal">Add Book Category</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for=""> Name Category</label>
                    <input type="text" class="form-control @error('name_category') is-invalid @enderror " name="name_category" id="name_category" required placeholder="Input Name Cateogry...">
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                <button id="btnsend" class="btn btn-primary">Simpan</button>

            </div>

        </div>
    </div>
</div>
<!-- Edit Data Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title" id="titleModalEdit">Update Book Category</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama_posisi"> Name Category</label>
                    <input type="hidden" name="id" id="edit-id">
                    <input type="text" data-nama="" class="form-control @error('name_category') is-invalid @enderror " name="name_category" id="edit-name-category" required placeholder="Masukkan nama posisi...">
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                <button id="btnEdit" class="btn btn-primary">Simpan</button>

            </div>

        </div>
    </div>
</div>







@endsection


@section('jsCustom')

<script>

$.ajax({
            url: '{{ route("get-book-categories") }} ',
            type: 'get',
            dataType: 'json',
            success: function (response) {

                var i = 1;

                console.log(response);

                let output = '';
                
                var data_message = response['data'];

                var links = response['links'];
                data_message.forEach(element => {


                    output += `
                    <tr>
                    <td> `+i+`</td>
                     <td><a href="/detail/${element.id_category}"> ${element.name_category} </a> </td>
                    <td>

                        <button type="button" class="btn btn-warning btn-sm" data-target="#editModal" data-toggle="modal" data-mycategory="${element.nama_category}" data-idcategory="${element.id}">

                            Update
                        </button>

                        

                        <a href="javascript:void(0)" id="delete" data-idcategorydelete="${element.id}" class="btn btn-danger btn-sm">Delete</a>

                    </td>
                </tr>
               
                    `; 

                    i++;
                    
                });

                document.getElementById("list_categories").innerHTML=output;
                document.getElementById("link").innerHTML=links;
            }
        })

    $('#btnsend').click(function(e) {
        e.preventDefault();
        var name_category = $("#name_category").val();
        if (name_category == '' || name_category == null) {
            alert("Data is empty");
            return false;
        }
        console.log(name_category);

        let token = $("meta[name='csrf-token']").attr("content");

        var params = {
            'name_category': name_category,
            "_token": token
        }


        $.ajax({
            type: 'POST',
            url: '{{ route("add-book-category") }}',
            data: params,
            success: function(success) {
                console.log(success);
                window.location.href = "{{ route('book-categories') }}";

                console.log(params);
                console.log("success");

            },

        });

    });

    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);

        var nama_category = button.data('mycategory');
        var id_category = button.data('idcategory');

        var modal = $(this);

        modal.find('.modal-body #edit-name-category').val(nama_category);
        modal.find('.modal-body #edit-id').val(id_category);

    });

    $('#btnEdit').click(function(e) {

        e.preventDefault();
        var name_category = $("#edit-name-category").val();
        var id_category = $("#edit-id").val();
        if (name_category == '' || name_category == null) {
            alert("Data is empty");
            return false;
        }
        let token = $("meta[name='csrf-token']").attr("content");
        var params = {
            'name_category': name_category,
            "_token": token
        }

       


        $.ajax({
            url: "{{ url('update-book-category') }}" + "/" + id_category,
            type: "PUT",
            cache: false,
            data: params,

            success: function(success) {
                console.log(success);
                window.location.href = "{{ route('book-categories') }}";

                console.log(params);
                console.log("success");

            },

        });


    });

    $('body').on('click', '#delete', function () {
        var result = confirm("Want to delete?");

        
        let token = $("meta[name='csrf-token']").attr("content");
        if (result) {
            let id_category = $(this).data('idcategorydelete');
            console.log(id_category);
            console.log(result);

            $.ajax({
                url: "{{ url('delete-book-category') }}"+"/"+id_category,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
                    },

            success: function(success) {
          
                window.location.href = "{{ route('book-categories') }}";

         

            },

        });

        }
    });
</script>
@endsection