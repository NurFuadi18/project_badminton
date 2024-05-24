<!DOCTYPE html>
<html lang="en">

<div class="container">
<table class="table">
            <thead>
            <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <h2>Rincian transaksi</h2>
    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
    <p><strong>Total:</strong> {{ $transaction->total }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
                <tr>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->harga * $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('transaction.print', $transaction->id) }}" class="btn btn-primary">Print Nota</a>
</div>

