@extends('kerangka.master')
@section('title', 'RFID Status')
@section('content')

<div class="page-content">
    <section class="row justify-content-center">
        <div class="col-8 mt-4">
            <div class="card shadow-sm h-100" style="min-height: calc(80vh - 80px);"> <!-- Menyesuaikan tinggi ke viewport -->
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>RFID Status Detail</h4>
                </div>
                <div class="card-body">
                    <p>RFID Reader Status: <strong>Connected</strong></p>

                    <!-- Tabel RFID Status -->
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>RFID Tag</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>54849947</td>
                                    <td>Tag A</td>
                                    <td>POS 3</td>
                                </tr>
                                <tr>
                                    <td>64899374</td>
                                    <td>Tag B</td>
                                    <td>POS 1</td>
                                </tr>
                                <tr>
                                    <td>74927410</td>
                                    <td>Tag C</td>
                                    <td>POS 7</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
