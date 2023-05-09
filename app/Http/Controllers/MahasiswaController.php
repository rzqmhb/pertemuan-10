<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        // return view('mahasiswas.index', compact('posts', 'mahasiswas'))
        // ->with('i', (request()->input('page', 1) - 1) * 5);

        $mahasiswas = Mahasiswa::paginate(5);
        $mahasiswas = Mahasiswa::where([
            ['nama', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('nama', 'LIKE', '%' . $search . '%')
                    ->get();
                }
            }]
        ])->paginate(5);
        $posts = Mahasiswa::orderBy('nim', 'desc');
        return view('mahasiswas.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $kelas = Kelas::all();
        return view('mahasiswas.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valisadi data
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
        ]);

        if ($request->file('image')) {
            $image_name = $request->file('foto')->store('images','public');
        }

        //fungsi eloquent untuk menambah data
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim=$request->get('nim');
        $mahasiswa->nama=$request->get('nama');
        $mahasiswa->tgl_lahir=$request->get('tgl_lahir');
        $mahasiswa->jurusan=$request->get('jurusan');
        $mahasiswa->email=$request->get('email');
        $mahasiswa->no_hp=$request->get('no_hp');
        $mahasiswa->foto=$request->image_name;
        //$mahasiswa->save();
        

        $kelas = new Kelas();
        $kelas->id = $request->get('kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //
        $Mahasiswa = Mahasiswa::find($nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //
        $Mahasiswa = Mahasiswa::find($nim);
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
        $request->validate([
        'nim' => 'required',
        'nama' => 'required',
        'kelas' => 'required',
        'jurusan' => 'required',
        'no_hp' => 'required',
        ]);
        //fungsi eloquent untuk mengupdate data inputan kita
        //Mahasiswa::find($nim)->update($request->all());
        

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim=$request->get('nim');
        $mahasiswa->nama=$request->get('nama');
        $mahasiswa->tgl_lahir=$request->get('tgl_lahir');
        $mahasiswa->jurusan=$request->get('jurusan');
        $mahasiswa->email=$request->get('email');
        $mahasiswa->no_hp=$request->get('no_hp');

        if($mahasiswa->foto && file_exists(storage_path('app/public/' . $mahasiswa->foto))) {
            Storage::delete('public/' . $mahasiswa->foto);
        }

        $image_name = $request->file('foto')->store('images', 'public');
        $mahasiswa->foto = $image_name;
        //$mahasiswa->save();

        $kelas = new Kelas();
        $kelas->id = $request->get('kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswas.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function khs($nim){
        $Mahasiswa=Mahasiswa::find($nim);
        return view('mahasiswas.khs', compact('Mahasiswa'));
    }
}
