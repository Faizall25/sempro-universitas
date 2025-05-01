@extends('admin.layout.main') <!-- Ini sesuaikan layout kamu -->

@section('content')
    <div class="p-6">
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-2xl font-semibold mb-6">Data Mahasiswa</h2>
            <div class="overflow-x-auto">
                <table id="mahasiswaTable" class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswa as $index => $mhs)
                            <tr class="border-b">
                                <td class="px-6 py-4">{{ $index + 1 }}</td> <!-- Ini nomor urut -->
                                <td class="px-6 py-4">{{ $mhs->nim }}</td>
                                <td class="px-6 py-4">{{ $mhs->nama }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($mhs->tgl_lahir)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">{{ $mhs->alamat }}</td>
                                <td class="px-6 py-4">{{ $mhs->email }}</td>
                                <td class="px-6 py-4">{{ $mhs->tahun_masuk }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#mahasiswaTable').DataTable();
        });
    </script>
@endsection