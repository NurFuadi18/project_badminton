@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        .dashboard-header {
            margin-bottom: 20px;
            text-align: center;
            background-color: #24292e;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
        }

        .dashboard-title {
            font-size: 32px;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .dashboard-divider {
            border: none;
            height: 2px;
            background-color: #303030;
            margin: 10px 0 20px 0;
        }

        .stat-card {
            background-color: #e0ffe0;
            padding: 20px;
            border-radius: 8px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .stat-card .number {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
        }

        .stat-card .label {
            font-size: 14px;
            color: #666;
        }

        .stat-card-wrapper {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-box">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Dashboard</h1>
                </div>
                <hr class="dashboard-divider">
                <div class="stat-card-wrapper">
                    <div class="stat-card">
                        <div class="number">{{ $jumlahPelanggan }}</div>
                        <div class="label">Jumlah Pelanggan</div>
                    </div>
                    <div class="stat-card">
                        <div class="number">{{ $jumlahAdmin }}</div>
                        <div class="label">Jumlah Admin</div>
                    </div>
                    <div class="stat-card">
                        <div class="number">{{ $pendapatanPerMinggu }}</div>
                        <div class="label">Pendapatan Per Minggu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
