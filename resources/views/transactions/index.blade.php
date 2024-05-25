<div class="container">
    <h1>Daftar Makanan</h1>
    <div class="row">
        @foreach($foods as $food)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $food->name }}</h5>
                        <p class="card-text">{{ $food->price }}</p>
                        <a href="{{ route('cart.add', $food->id) }}" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h1>Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                    <tr>
                        <td>{{ $details['nama'] }}</td>
                        <td>{{ $details['jumlah'] }}</td>
                        <td>{{ $details['harga'] }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <a href="{{ route('cart.checkout') }}" class="btn btn-success">Checkout</a>
</div>