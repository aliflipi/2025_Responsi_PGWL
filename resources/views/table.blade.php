@extends('layout/template')

@section('content')
    <div class="container-mt-4 content-wrapper">
        <div class="card">
            <div class="card-header bg-brown text-white">
                <h4>Points Data</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover text-center" id="pointstable">
                    <thead class="table-brown text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Description</th>
                            <th>Tipe</th>
                            <th>Image</th>
                            <th>Create At</th>
                            <th>Update At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($points as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->description }}</td>
                                <td>{{ $p->tipe }}</td>
                                <td>
                                    <img src="{{ asset('storage/images/' . $p->image) }}" alt="" width="200"
                                        title="{{ $p->image }}">
                                </td>
                                <td>{{ $p->created_at }}</td>
                                <td>{{ $p->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">

    <style>
        /* === Background Halaman dengan malbor.jpg === */
        body {
            background-image: url('{{ asset('storage/icon/malbor.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Bungkus konten dengan lapisan transparan */
        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.9); /* lapisan putih transparan */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        /* Tema warna coklat cerah */
        .bg-brown {
            background-color: #A0522D !important; /* Sienna */
        }

        .table-brown {
            background-color: #D2B48C; /* Tan */
        }

        #pointstable {
            background-color: ;
            border: 1px solid #ccc;
        }

        #pointstable th,
        #pointstable td {
            vertical-align: middle;
        }

        #pointstable tbody tr:hover {
            background-color: #f5e6d3;
        }

        .table th {
            font-weight: bold;
        }

        .card {
            box-shadow: 0 0 10px rgba(160, 82, 45, 0.2);
        }

        img.img-thumbnail {
            max-height: 120px;
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
        let tablepoints = new DataTable('#pointstable');
    </script>
@endsection
