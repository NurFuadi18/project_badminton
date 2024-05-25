<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="top-bar">
        <div class="leftside">
            <p>Badminton Jaya<p>
        </div>
        <div class="menu">
            <ul>
                <a href="index">Home</a>
                <a href="jadwal">Jadwal</a>
                <a href="databarang">Data</a>
                <a href="cart">Cart</a> <!-- Tombol menuju halaman Cart -->
            </ul>
        </div>
        <div class="admin">
            <p>Selamat Datang Admin!!</p>
        </div>
        <div class="dropdown">
            <span class="material-symbols-outlined">menu</span>
            <div class="dropdown-content">
                <a href="register">Tambah Akun</a>
                <a href="laporan">Laporan</a>
                <a href="gantipassword">Data Akun</a>
                <a href="login">Log Out</a>
            </div>
        </div>
    </div>

    <!-- Pesan Sukses dan Error -->
    <div id="message"></div>

    <table class="table">
        <thead>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Edit</th>
                <th>Add to Cart</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $barang)
                <tr id="barang-{{ $barang->id_barang }}">
                    <td>{{ $barang->id_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->jenis }}</td>
                    <td>{{ $barang->harga }}</td>
                    <td class="jumlah">{{ $barang->jumlah }}</td>
                    <td>
                        <a href="barang/{{ $barang->id_barang }}/edit" class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                        <form class="add-to-cart-form" data-id="{{ $barang->id_barang }}">
                            @csrf
                            <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $barang->jumlah }}" style="width: 50px;">
                            <button type="submit" class="btn btn-success">Add to Cart</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol untuk memunculkan modal -->
    <button type="button" id="tambahBarangBtn" data-toggle="modal" data-target="#tambahBarangModal">Tambah Barang</button>

    <!-- Modal untuk tambah barang -->
    <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk tambah barang -->
                    <form action="barang/tambah" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="id_barang">Id Barang:</label>
                            <input type="text" class="form-control" id="id" name="id_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang:</label>
                            <input type="text" class="form-control" id="nama" name="nama_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Barang:</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Barang:</label>
                            <input type="text" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Barang:</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk menangani modal dan AJAX -->
    <script>
        $(document).ready(function() {
            // Tampilkan modal tambah barang
            $('#tambahBarangBtn').click(function() {
                $('#tambahBarangModal').modal('show');
            });

            // Tangani pengiriman form Add to Cart menggunakan AJAX
            $('.add-to-cart-form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var id_barang = form.data('id');
                var quantity = form.find('input[name="quantity"]').val();

                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#barang-' + id_barang + ' .jumlah').text(response.new_quantity);
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(response) {
                        if (response.status === 401) {
                            window.location.href = '{{ route("login") }}';
                        } else {
                            $('#message').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
