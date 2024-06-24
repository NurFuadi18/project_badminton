@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .booking-table-container {
        margin: 20px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .booking-table-header {
        margin-bottom: 20px;
        text-align: center;
        background-color: #24292e;
        padding: 10px;
        border-radius: 10px;
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
    }

    .booking-table-title {
        font-size: 32px;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .booking-table {
        width: 100%;
        border-collapse: collapse;
    }

    .booking-table th,
    .booking-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .booking-table th {
        background-color: #f4f4f4;
    }

    .booking-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .action-button {
        padding: 8px 12px;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .accept-button {
        background-color: #28a745;
    }

    .reject-button {
        background-color: #dc3545;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .submit-button {
        background-color: #007bff; /* warna biru */
    }
</style>

<div class="booking-table-container">
    <div class="booking-table-header">
        <h1 class="booking-table-title">Booking List</h1>
    </div>
    <table class="booking-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengirim</th>
                <th>Lapangan Dipilih</th>
                <th>Tanggal Bermain</th>
                <th>harga lapangan</th>
                <th>Jam Dimulai</th>
                <th>Jam Diakhiri</th>
                <th>Equipment</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->nama_pengirim }}</td>
                    <td>{{ $booking->lapangan_dipilih }}</td>
                    <td>{{ $booking->harga}}</td>
                    <td>{{ $booking->tanggal_bermain }}</td>
                    <td>{{ $booking->jam_dimulai }}</td>
                    <td>{{ $booking->jam_diakhiri }}</td>
                    <td>{{ $booling->total}}</td>
                    <td>{{ $booking->equipment }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>
                        @if($booking->status == 'pending')
                            <button class="action-button accept-button" onclick="openModal({{ $booking->id }})">Terima</button>
                            <form method="POST" action="{{ route('bookings.reject', $booking->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button reject-button">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="booking-table-container">
    <div class="booking-table-header">
        <h1 class="booking-table-title">Approved Bookings</h1>
    </div>
    <table class="booking-table" id="approvedBookingsTable">
        <thead>
            <!-- Kolom-kolom tabel -->
            <tr>
                <th>ID</th>
                <th>Nama Pengirim</th>
                <th>Lapangan Dipilih</th>
                <th>Tanggal Bermain</th>
                <th>Jam Dimulai</th>
                <th>Jam Diakhiri</th>
                <th>Equipment</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Baris-baris data -->
            @foreach($approvedBookings as $approvedBooking)
                <tr>
                    <td>{{ $approvedBooking->id }}</td>
                    <td>{{ $approvedBooking->nama_pengirim }}</td>
                    <td>{{ $approvedBooking->lapangan_dipilih }}</td>
                    <td>{{ $approvedBooking->tanggal_bermain }}</td>
                    <td>{{ $approvedBooking->jam_dimulai }}</td>
                    <td>{{ $approvedBooking->jam_diakhiri }}</td>
                    <td>{{ $approvedBooking->equipment }}</td>
                    <td>{{ $approvedBooking->total }}</td>
                    <td>{{ $approvedBooking->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="acceptModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Terima Booking</h2>
        <form method="POST" action="{{ route('bookings.accept', ['id' => 0]) }}" id="acceptForm">
            @csrf
            <div>
                <label for="pendapatan">Pendapatan:</label>
                <input type="number" id="pendapatan" name="pendapatan" required>
            </div>
            <div>
                <label for="bayar">Bayar:</label>
                <input type="number" id="bayar" name="bayar" required>
            </div>
            <div>
                <label for="kembalian">Kembalian:</label>
                <input type="number" id="kembalian" name="kembalian" readonly>
            </div>
            <button type="submit" class="action-button accept-button submit-button">Konfirmasi</button>
        </form>
    </div>
</div>

<script>
    function openModal(bookingId) {
        document.getElementById('acceptForm').action = '{{ route('bookings.accept', ['id' => ':id']) }}'.replace(':id', bookingId);
        document.getElementById('acceptModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('acceptModal').style.display = 'none';
    }

    document.getElementById('bayar').addEventListener('input', function () {
        const pendapatan = document.getElementById('pendapatan').value;
        const bayar = document.getElementById('bayar').value;
        document.getElementById('kembalian').value = bayar - pendapatan;
    });

    document.getElementById('pendapatan').addEventListener('input', function () {
        const pendapatan = document.getElementById('pendapatan').value;
        const bayar = document.getElementById('bayar').value;
        document.getElementById('kembalian').value = bayar - pendapatan;
    });
</script>
@endsection