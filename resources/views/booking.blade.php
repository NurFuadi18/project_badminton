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
                    <th>Jam Dimulai</th>
                    <th>Jam Diakhiri</th>
                    <th>Equipment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->nama_pengirim }}</td>
                        <td>{{ $booking->lapangan_dipilih }}</td>
                        <td>{{ $booking->tanggal_bermain }}</td>
                        <td>{{ $booking->jam_dimulai }}</td>
                        <td>{{ $booking->jam_diakhiri }}</td>
                        <td>{{ $booking->equipment }}</td>
                        <td>{{ $booking->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
