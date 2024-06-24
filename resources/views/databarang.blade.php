@extends('layouts.app')

@section('title', 'Data Barang dan Keranjang')

@section('content')
<style>
    .inventaris-table-container, .cart-table-container {
        margin: 20px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .inventaris-table-header, .cart-table-header {
        margin-bottom: 20px;
        text-align: center;
        background-color: #24292e;
        padding: 10px;
        border-radius: 10px;
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
    }
    .inventaris-table-title, .cart-table-title {
        font-size: 32px;
        color: #ffffff;
        margin-bottom: 10px;
    }
    .inventaris-table, .cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    .inventaris-table th, .inventaris-table td, .cart-table th, .cart-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }
    .inventaris-table th, .cart-table th {
        background-color: #f4f4f4;
    }
    .inventaris-table tr:nth-child(even), .cart-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .action-button {
        padding: 8px 12px;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .edit-button {
        background-color: #007bff;
    }
    .add-to-cart-button {
        background-color: #28a745;
    }
    .modal-content .form-group {
        margin-bottom: 15px;
    }
</style>

<div class="inventaris-table-container">
    <div class="inventaris-table-header">
        <h1 class="inventaris-table-title">Data Barang</h1>
    </div>
    <div id="message"></div>
    <table class="inventaris-table">
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
                        <a href="barang/{{ $barang->id_barang }}/edit" class="btn action-button edit-button">Edit</a>
                    </td>
                    <td>
                        <form class="add-to-cart-form" data-id="{{ $barang->id_barang }}">
                            @csrf
                            <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $barang->jumlah }}" style="width: 50px;">
                            <button type="submit" class="btn action-button add-to-cart-button">Add to Cart</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="cart-table-container">
    <div class="cart-table-header">
        <h1 class="cart-table-title">Your Cart</h1>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cartItems) > 0)
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->harga * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <h4>Total: {{ $total }}</h4>
        </div>
        <form action="{{ route('cart.checkout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary">Checkout</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>

<button type="button" id="tambahBarangBtn" class="btn btn-primary" data-toggle="modal" data-target="#tambahBarangModal">Tambah Barang</button>

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

<script>
    $(document).ready(function() {
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
@endsection
