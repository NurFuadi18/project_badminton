<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
     .container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
     .table {
            width: 100%;
            border-collapse: collapse;
        }
     .table th,.table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
     .table th {
            background-color: #f0f0f0;
        }
     .btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
     .btn:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Badminton Jaya</h2>
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
                        <td>{{ $item->harga * $item->quantity}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</body>
</html>