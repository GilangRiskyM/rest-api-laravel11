<?php

namespace App\Http\Controllers;

use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    function index()
    {
        $siswa = Siswa::get();

        if ($siswa->count() > 0) {
            return response()->json([
                'message' => 'Data Berhasil Didapatkan',
                'data' => SiswaResource::collection($siswa)
            ]);
        } else {
            return response()->json([
                'message' => 'Data Kosong'
            ], 204);
        }
    }

    function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ], [
            'nama.required' => 'Nama Siswa Wajib Diisi',
            'nis.required' => 'NIS Wajib Diisi',
            'kelas.required' => 'Kelas Wajib Diisi',
            'jurusan.required' => 'Jurusan Wajib Diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'message' => 'Data Tidak Lengkap',
                'error' => $validasi->messages()
            ], 422);
        }

        $siswa = Siswa::create($request->all());

        return response()->json([
            'message' => 'Data Berhasil Ditambahkan',
            'data' => new SiswaResource($siswa)
        ], 201);
    }

    function show(Siswa $siswa)
    {
        return new SiswaResource($siswa);
    }

    function update(Request $request, Siswa $siswa)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ], [
            'nama.required' => 'Nama Siswa Wajib Diisi',
            'nis.required' => 'NIS Wajib Diisi',
            'kelas.required' => 'Kelas Wajib Diisi',
            'jurusan.required' => 'Jurusan Wajib Diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'message' => 'Data Tidak Lengkap',
                'error' => $validasi->messages()
            ], 422);
        }

        $siswa->update($request->all());

        return response()->json([
            'message' => 'Data Berhasil Diubah',
            'data' => new SiswaResource($siswa)
        ], 200);
    }

    function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return response()->json([
            'message' => 'Data Berhasil Dihapus'
        ], 200);
    }
}
