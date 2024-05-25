
<div class="container">
    <h2>Transaction Details</h2>
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

