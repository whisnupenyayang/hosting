@extends('admin.layouts.admin')

@section('content')
<h2></h2>

<form action="{{ route('kegiatan.panen.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="jenis_kopi">Jenis Kopi<span style="color:red;">*</span></label>
        <select name="jenis_kopi" class="form-control" required>
            <option value="Arabika">Arabika</option>
            <option value="Robusta">Robusta</option>
        </select>
    </div>

    <div class="form-group">
        <label for="nama_tahapan_existing">Pilih Tahapan yang Ada</label>
        <select name="nama_tahapan_existing" class="form-control">
            <option value="">-- Pilih Jika Ingin Menggunakan Tahapan yang Sudah Ada --</option>
            @foreach ($existingTahapan as $tahapan)
                <option value="{{ $tahapan }}">{{ $tahapan }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="nama_tahapan_baru">Atau Buat Tahapan Baru</label>
        <input type="text" name="nama_tahapan_baru" class="form-control" placeholder="Contoh: Pemetikan Buah">
    </div>

    <div class="form-group">
        <label for="judul">Judul Informasi<span style="color:red;">*</span></label>
        <input type="text" name="judul" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi<span style="color:red;">*</span></label>
        <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
    </div>

    <div class="form-group">
        <label for="url_gambar">Upload Gambar<span style="color:red;">*</span></label>
        <input type="file" name="url_gambar" accept="image/*" class="form-control-file">
    </div>

    <div class="form-group">
        <label for="nama_file">Upload File<span style="color:red;">*</span></label>
        <input type="file" name="nama_file" class="form-control-file @error('nama_file') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" required>
    </div>

    <button type="submit" class="btn btn-success">Simpan Informasi</button>
    <a href="{{ route('kegiatan.panen') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
