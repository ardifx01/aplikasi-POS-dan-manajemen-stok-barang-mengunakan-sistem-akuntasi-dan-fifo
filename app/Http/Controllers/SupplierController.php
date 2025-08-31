<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('supplier.view', ['supplier' => $supplier]);
    }

    public function create()
    {
        $supplierModel = new Supplier();
        $kodeSupplier = $supplierModel->getKodeSupplier();

        return view('supplier.create', [
            'kode_supplier' => $kodeSupplier
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_supplier' => 'required',
            'nama_supplier' => 'required', // ← Sudah tidak dibatasi hanya huruf
            'alamat'        => 'required',
            'no_telpon'     => ['required', 'regex:/^[0-9]+$/'],
            'email'         => 'nullable|email',
        ], [
            'no_telpon.regex' => 'Nomor telepon hanya boleh angka.',
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Data Berhasil di Input');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'kode_supplier' => 'required',
            'nama_supplier' => 'required', // ← Bebas, tanpa regex
            'alamat'        => 'required',
            'no_telpon'     => ['required', 'regex:/^[0-9]+$/'],
            'email'         => 'nullable|email',
        ], [
            'no_telpon.regex' => 'Nomor telepon hanya boleh angka.',
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Data Berhasil di Ubah');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Data Berhasil di Hapus');
    }
}
