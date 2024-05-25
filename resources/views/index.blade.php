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

<div class="content">
        <div>
            <h2>KALENDER</h2>
            <p>nanti isinya kalender jadwal pesan lapangan per minggu</p>
        </div>
        <div>
        <table class="table">
        
        <thead>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>   
            </tr>
        </thead>
        <tbody>
        @foreach($data as $barang)
            <tr>
                 <td>{{ $barang->id_barang }}</td>
                 <td>{{ $barang->nama_barang }}</td>
                 <td>{{ $barang->jenis }}</td>
                 <td>{{ $barang->jumlah }}</td>              
            </tr>
        @endforeach
        </tbody>
    </table>
        </div>
        <div>
            <h2>Lapangan 1</h2>
            <p>Menampilkan siapa yang main di lap 1</p>
        </div>
        <div>
            <h2>Lapangan 2</h2>
            <p>menampilkan siapa yang main di lap 2</p>
        </div>
    </div>
</body>
</html>