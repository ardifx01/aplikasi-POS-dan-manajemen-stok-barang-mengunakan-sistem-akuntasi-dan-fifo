<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\JurnalUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JurnalUmumController;

class CoaController extends Controller
{
    public function index()
    {
        $coa = Coa::all();
        return view('coa.view', ['coa' => $coa]);
    }

    public function create()
    {
        return view('coa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_coa' => 'required',
            'nama_coa' => ['required', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'header'   => ['required', 'regex:/^[0-9]+$/'],
            'saldo'    => ['required', 'numeric'],
        ], [
            'nama_coa.regex' => 'Nama COA hanya boleh mengandung huruf dan spasi.',
            'header.regex'   => 'Kolom header hanya boleh diisi dengan angka.',
            'saldo.numeric'  => 'Saldo harus berupa angka.',
        ]);

        DB::beginTransaction();

        try {
            // Simpan COA dulu
            $coa = Coa::create($validated);

            // Panggil JurnalUmumController untuk buat jurnal otomatis jika Modal Sendiri
            JurnalUmumController::simpanModalSendiri($coa);

            DB::commit();
            return redirect()->route('coa.index')->with('success', 'Data COA Berhasil di Input');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal menyimpan COA: ' . $e->getMessage());
        }
    }

    public function show(Coa $coa)
    {
        return response()->json($coa);
    }

    public function edit(Coa $coa)
    {
        return view('coa.edit', compact('coa'));
    }

    public function update(Request $request, Coa $coa)
    {
        $validated = $request->validate([
            'kode_coa' => 'required',
            'nama_coa' => ['required', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'header'   => ['required', 'regex:/^[0-9]+$/'],
            'saldo'    => ['required', 'numeric'],
        ], [
            'nama_coa.regex' => 'Nama COA hanya boleh mengandung huruf dan spasi.',
            'header.regex'   => 'Kolom header hanya boleh diisi dengan angka.',
            'saldo.numeric'  => 'Saldo harus berupa angka.',
        ]);

        $coa->update($validated);

        return redirect()->route('coa.index')->with('success', 'Data COA Berhasil di Ubah');
    }

    public function destroy($id)
    {
        $coa = Coa::findOrFail($id);
        $coa->delete();

        return redirect()->route('coa.index')->with('success', 'Data COA Berhasil di Hapus');
    }
}
