@extends('mahasiswas.layout')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
                Edit Mahasiswa
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="post" action="{{ route('mahasiswas.update', $Mahasiswa->nim) }}" enctype="multipart/form-data" id="myForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nim">Nim</label><br>
                        <input type="text" name="nim" class="form-control" id="nim" value="{{ $Mahasiswa->nim }}" ariadescribedby="nim" >
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label><br>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ $Mahasiswa->nama }}" ariadescribedby="nama" >
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label><br>
                        <input type="text" name="tgl_lahir" class="form-control" id="tgl_lahir" value="{{ $Mahasiswa->tgl_lahir }}" ariadescribedby="tgl_lahir" >
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label><br>
                        <select name="kelas" class="form-control">
                            @foreach ($kelas as $Kelas)
                                <option value="{{$Kelas->id}}">{{$Kelas->nama_kelas}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label><br>
                        <input type="jurusan" name="jurusan" class="form-control" id="jurusan" value="{{ $Mahasiswa->jurusan }}" ariadescribedby="jurusan" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label><br>
                        <input type="text" name="email" class="form-control" id="email" value="{{ $Mahasiswa->email }}" ariadescribedby="email" >
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Handphone</label><br>
                        <input type="no_hp" name="no_hp" class="form-control" id="no_hp" value="{{ $Mahasiswa->no_hp }}" ariadescribedby="no_hp" >
                    </div>
                    <div class="form-group">
                        <label for="foto">Pas Foto</label><br>
                        <input type="file" name="foto" class="form-control" id="foto" aria-describedby="foto" >
                    </div>
                    <img width="150px" src="{{asset('storage/'.$Mahasiswa->foto)}}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection