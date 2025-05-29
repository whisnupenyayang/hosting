<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    // Method for displaying all stores
    public function index()
    {
        $title = 'Data Toko';  // Set the title
        $toko = Toko::all();
        return view('admin.toko.toko', compact('toko', 'title'));  // Pass $title and $toko to the view
    }

    // Method to show form for creating new store
    public function create()
    {
        $title = 'Tambah Toko';  // Set the title
        return view('admin.toko.tambah_toko', compact('title'));  // Pass $title to the view
    }

    // Method for storing a new store
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jam_operasional' => 'required|string|max:255',
            'foto_toko' => 'required|image|mimes:jpeg,png,jpg,gif,svg', // Validasi file
        ]);

        // Menyimpan data toko
        $toko = new Toko;
        $toko->nama_toko = $request->nama_toko;
        $toko->lokasi = $request->lokasi;
        $toko->jam_operasional = $request->jam_operasional;

        // Menyimpan foto toko jika ada
        if ($request->hasFile('foto_toko')) {
            $file = $request->file('foto_toko');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $toko->foto_toko = $filename;
        }

        // Menyimpan ke database
        $toko->save();

        return redirect()->route('admin.toko')->with('success', 'Toko berhasil ditambahkan!');
    }

    // Method to show the details of a store
    public function detailToko($id)
    {
        $title = 'Detail Toko';  // Set the title
        $toko = Toko::findOrFail($id);  // Fetch the store by id
        return view('admin.toko.detail_toko', compact('toko', 'title'));  // Pass $title and $toko to the view
    }

    // Method to show the edit form
    public function edit($id)
    {
        $toko = Toko::findOrFail($id);
        return view('admin.toko.edit', compact('toko'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'lokasi' => 'required|url',
            'jam_operasional' => 'required|string|max:255',
            'foto_toko' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $toko = Toko::findOrFail($id);

        $toko->nama_toko = $request->nama_toko;
        $toko->lokasi = $request->lokasi;
        $toko->jam_operasional = $request->jam_operasional;

        if ($request->hasFile('foto_toko')) {
            // Simpan gambar baru dan hapus yang lama jika ada
            if ($toko->foto_toko && file_exists(public_path('images/' . $toko->foto_toko))) {
                unlink(public_path('images/' . $toko->foto_toko));
            }

            $file = $request->file('foto_toko');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $toko->foto_toko = $filename;
        }

        $toko->save();

        return redirect()->route('toko.detail', $toko->id)->with('success', 'Data toko berhasil diperbarui.');
    }


    // Method to delete a store
    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);

        // Delete image if exists
        if ($toko->foto_toko && file_exists(public_path('images/' . $toko->foto_toko))) {
            unlink(public_path('images/' . $toko->foto_toko));
        }

        $toko->delete();

        return redirect()->route('admin.toko')->with('success', 'Toko berhasil dihapus');
    }
}
