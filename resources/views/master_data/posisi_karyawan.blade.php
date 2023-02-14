@extends('layouts.app')
@section('title', 'Master Data Posisi Karyawan')
@section('content')


<div class="container">
    <h1>Master Data Posisi Karyawan</h1>


    @if (session()->has('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>
                                        
    @endif
    @if (session()->has('danger'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>
    @endif


    <button class="btn btn-primary" href="#" data-toggle="modal" data-target="#addData" > Tambah Data </button>
    
    <table class="table mt-2">
  <thead class="thead-dark">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama Posisi</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

  @foreach ($posisi as $data )
      
  <tr>
      <td>{{ ++$i }}</td>
      <td>{{ $data->nama_posisi }}</td>
      <td>{{ $data->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
      <td>
        
      <button type="button" class="btn btn-warning" data-target="#editModal" data-toggle="modal"  data-myposisi="{{$data->nama_posisi}}" data-idposisi="{{$data->id}}" >

          <i class="bi bi-tools"  > Edit </i>  
      </button>
      |
              <a href="/change-posisi-karyawan/{{$data->id}}" class="bi bi-pencil-square">
                  Ganti Status
                </a>
              
        
    
    </td>
    </tr>
    @endforeach
  
  </tbody>
</table>
</div>
<!-- Add Data Modal-->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="/add-posisi-karyawan" > 
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="addModal">Tambah Data</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_posisi"> Nama Posisi</label>
                            <input type="text" class="form-control @error('nama_posisi') is-invalid @enderror " name="nama_posisi"  required placeholder="Masukkan nama posisi...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary"  data-dismiss="modal">Cancel</a>
                        
                        <button type="submit" class="btn btn-primary" >Simpan</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Edit Data Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" 
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="/edit-posisi-karyawan" > 
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="titleModalEdit">Edit Data</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_posisi"> Nama Posisi</label>
                            <input type="hidden"  name="id_posisi" id="edit-id-posisi" >
                            <input type="text" data-nama="" class="form-control @error('nama_posisi') is-invalid @enderror " name="nama_posisi" id="edit-nama-posisi" required placeholder="Masukkan nama posisi...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary"  data-dismiss="modal">Cancel</a>
                        
                        <button type="submit" class="btn btn-primary" >Simpan</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

 



@endsection

