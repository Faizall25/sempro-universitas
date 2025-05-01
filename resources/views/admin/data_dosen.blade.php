@extends('admin.layout.main')

@section('content')
    <div class="p-6">
        <div class="bg-white shadow-md rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Data Dosen</h2>

                <!-- Dropdown filter bidang keahlian -->
                <div>
                    <label for="filter-bidang" class="mr-2 font-semibold">Filter Bidang Keahlian:</label>
                    <select id="filter-bidang" class="border border-gray-300 rounded p-2">
                        <option value="">Semua</option>
                        @foreach($bidangKeahlians as $bidang)
                            <option value="{{ $bidang->nama }}">{{ $bidang->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="dosenTable" class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bidang Keahlian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dosen as $index => $dsn)
                            <tr class="border-b">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $dsn->nip }}</td>
                                <td class="px-6 py-4">{{ $dsn->nama }}</td>
                                <td class="px-6 py-4">{{ $dsn->email }}</td>
                                <td class="px-6 py-4">{{ $dsn->bidangKeahlian->bidang_keahlian ?? '-' }}</td>

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
            var table = $('#dosenTable').DataTable();

            // Filter by bidang keahlian
            $('#filter-bidang').on('change', function () {
                var selected = $(this).val();
                if (selected) {
                    table.column(4).search('^' + selected + '$', true, false).draw();
                } else {
                    table.column(4).search('').draw();
                }
            });
        });
    </script>
@endsection