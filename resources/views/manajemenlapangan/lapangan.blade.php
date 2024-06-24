@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        /* CSS untuk modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Konten Modal */
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header Modal */
        .modal-header {
            background-color: #24292e;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        /* Tombol tutup (x) */
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

        .action-buttons {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .action-buttons .btn {
            margin: 5px;
        }

        .btn-edit {
            margin-left: auto;
        }

        .form-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

    </style>

    <div class="booking-table-container">
        <!-- Button untuk memunculkan modal -->
        <button id="addButton" class="btn btn-primary">Add New</button>
        <div class="booking-table-container">
            <div class="booking-table-header bg-dark text-white">
                <h1 class="booking-table-title">Field List</h1>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lapangan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lapangans as $lapangan)
                        <tr>
                            <td>{{ $lapangan->id }}</td>
                            <td>{{ $lapangan->nama }}</td>
                            <td>{{ $lapangan->harga }}</td>
                            <td class="action-buttons">
                                <button class="view-image-button btn btn-primary" data-image="{{ url('images/' . $lapangan->gambar) }}">Gambar</button>
                                <a href="{{ route('lapangan.edit', $lapangan->id) }}" class="btn btn-info btn-edit">Edit</a>
                                <form action="{{ route('lapangan.destroy', $lapangan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Form untuk menambahkan data lapangan -->
        <div class="form-container" id="formContainer" style="display: none;">
            <h2>Add New Field</h2>
            <form action="{{ route('lapangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Lapangan:</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="text" id="harga" name="harga" class="form-control">
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar:</label>
                    <input type="file" id="gambar" name="gambar" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <!-- Modal -->
        <div id="imageModal" class="modal">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Gambar Lapangan</h5>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Gambar Lapangan" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>

    <script>
        var viewImageButtons = document.getElementsByClassName("view-image-button");
        var modalImage = document.getElementById("modalImage");
        var imageModal = document.getElementById("imageModal");
        var closeImageModal = document.getElementsByClassName("close")[0];
        var addButton = document.getElementById("addButton");
        var formContainer = document.getElementById("formContainer");

        for (var i = 0; i < viewImageButtons.length; i++) {
            viewImageButtons[i].onclick = function() {
                var imageSrc = this.getAttribute("data-image");
                modalImage.src = imageSrc;
                imageModal.style.display = "block";
            }
        }

        closeImageModal.onclick = function() {
            imageModal.style.display = "none";
        }

        addButton.onclick = function() {
            formContainer.style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == imageModal) {
                imageModal.style.display = "none";
            }
        }
    </script>
@endsection
r