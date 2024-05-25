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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
</head>
<body>
<div class="top-bar">
    <div class="leftside">
        <p>Badminton Jaya</p>
    </div>

    <div class="menu">
            <ul>
            <a href="index">Home</a>
            <a href="jadwal">Jadwal</a>
            <a href="databarang">Data</a>
            <a href="cart">Cart</a>
            </ul>
        </div>

        <div class="admin">
            @if (Auth::check())
                <p>Selamat Datang, {{ Auth::user()->name }}!</p>
            @else
                <p>Selamat Datang, Tamu!</p>
            @endif
        </div>

    <div class="dropdown">
        <span class="material-symbols-outlined">menu</span>
        <div class="dropdown-content">
            <a href="register">Tambah Akun</a>
            <a href="gantipassword">Data Akun</a>
            <a href="login">Log Out</a>
        </div>
    </div>
</div>

<!-- Tempat untuk menampilkan pesan -->
<div id="message" class="alert" style="display: none;"></div>

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
            <td class="jumlah-barang">{{ $barang->jumlah }}</td>
            <td>
                <a href="barang/{{ $barang->id_barang }}/edit" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form class="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Tombol untuk memunculkan modal -->
<button type="button" id="tambahBarangBtn" class="btn btn-primary" data-toggle="modal" data-target="#tambahBarangModal">Tambah Barang</button>

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
                <label for="id">Id Barang:</label>
                <input type="text" class="form-control" id="id" name="id_barang" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama Barang:</label>
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
    $(document).ready(function(){
        $('#tambahBarangBtn').click(function(){
            $('#tambahBarangModal').modal('show');
        });

        $('.add-to-cart-form').on('submit', function(event){
            event.preventDefault(); // Cegah pengiriman formulir secara normal
            var form = $(this);
            var idBarang = form.find('input[name="id_barang"]').val();
            var quantity = parseInt(form.find('input[name="quantity"]').val());
            var jumlahElement = $('#barang-' + idBarang + ' .jumlah-barang');
            var jumlahSekarang = parseInt(jumlahElement.text());

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response){
                    // Update jumlah barang di tabel
                    var jumlahBaru = jumlahSekarang - quantity;
                    jumlahElement.text(jumlahBaru);

                    // Tampilkan pesan sukses
                    $('#message').removeClass('alert-danger').addClass('alert-success').text('Item added to cart successfully!').show();
                    setTimeout(function() {
                        $('#message').fadeOut('slow');
                    }, 3000); // Pesan akan hilang setelah 3 detik
                },
                error: function(error){
                    // Tampilkan pesan error
                    $('#message').removeClass('alert-success').addClass('alert-danger').text('Failed to add item to cart. Please try again.').show();
                    setTimeout(function() {
                        $('#message').fadeOut('slow');
                    }, 3000); // Pesan akan hilang setelah 3 detik
                }
            });
        });
    });
</script>

</body>
</html>
