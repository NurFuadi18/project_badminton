<!DOCTYPE html>
<html>
<head>
    <title>Laporan Makanan dan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Makanan</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Makanan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($makanan as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Laporan Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Makanan</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $trans)
                <tr>
                    <td>{{ $trans->id }}</td>
                    <td>{{ $trans->makanan_id }}</td>
                    <td>{{ $trans->jumlah }}</td>
                    <td>{{ $trans->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
