<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Barang</h2>
        <form action="/barang/{{$barang->id_barang}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            </div>
            <div class="form-group">
                <label for="jenis">Jenis</label>
                <input type="text" name="jenis" id="jenis" class="form-control" value="{{ old('jenis', $barang->jenis) }}" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah', $barang->jumlah) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
