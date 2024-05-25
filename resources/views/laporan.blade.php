<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php use Carbon\Carbon; ?>
</head>
<body>
    <div class="container mt-5">
        <h2>Laporan Transaksi</h2>
        @if(count($transactions) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Total</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jam Transaksi</th>
                        <th>Item Dibeli</th> <!-- Kolom untuk menampilkan item-item yang dibeli -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->user_id }}</td>
                            <td>{{ $transaction->total }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toDateString() }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Jakarta')->toTimeString() }}</td>
                            <td>
                                <ul>
                                    @foreach($transaction->items as $item)
                                        <li>{{ $item->nama_barang }} ({{ $item->quantity }})</li> <!-- Menampilkan nama barang dan jumlahnya -->
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada transaksi yang tersedia.</p>
        @endif
    </div>
</body>
</html>
