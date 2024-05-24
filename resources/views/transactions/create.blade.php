<!DOCTYPE html>
<html>
<head>
    <title>Create Transaksi</title>
</head>
<body>
    <form action="{{ route('transaksis.store') }}" method="POST">
        @csrf
        <div>
            <label for="booking_id">Booking ID:</label>
            <select name="booking_id" required>
                @foreach($bookings as $booking)
                    <option value="{{ $booking->id }}">{{ $booking->id }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="total_harga">Total Harga:</label>
            <input type="number" step="0.01" name="total_harga" required>
        </div>
        <button type="submit">Create Transaksi</button>
    </form>
</body>
</html>
