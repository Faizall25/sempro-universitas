@extends('admin.layout.main')

@section('content')
<div class="p-6">
    <div class="bg-white shadow-md rounded-2xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Data Bidang Keahlian</h2>
            <button id="btnTambah" class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-teal-700">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="bidangTable" class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bidang Keahlian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bidangKeahlian as $index => $bk)
                    <tr class="border-b">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $bk->kode }}</td>
                        <td class="px-6 py-4">{{ $bk->bidang_keahlian }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <button class="btnEdit bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600"
                                data-id="{{ $bk->id }}" data-kode="{{ $bk->kode }}" data-bidang="{{ $bk->bidang_keahlian }}">
                                Edit
                            </button>
                            <form action="{{ route('bidangkeahlian.destroy', $bk->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus data ini?')"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalForm" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-md">
        <h3 id="modalTitle" class="text-xl font-bold mb-4">Tambah Bidang Keahlian</h3>

        <form id="formBidang" method="POST">
            @csrf
            <input type="hidden" name="_method" id="method" value="POST">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Kode</label>
                <input type="text" name="kode" id="kode" required
                    class="w-full border-gray-300 rounded-lg mt-1 focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" id="bidang_keahlian" required
                    class="w-full border-gray-300 rounded-lg mt-1 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" id="btnCancel" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-teal-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#bidangTable').DataTable();

        $('#btnTambah').click(function () {
            $('#modalTitle').text('Tambah Bidang Keahlian');
            $('#formBidang').attr('action', "{{ route('bidangkeahlian.store') }}");
            $('#method').val('POST');
            $('#kode').val('');
            $('#bidang_keahlian').val('');
            $('#modalForm').removeClass('hidden');
        });

        $('.btnEdit').click(function () {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            const bidang = $(this).data('bidang');

            $('#modalTitle').text('Edit Bidang Keahlian');
            $('#formBidang').attr('action', '/admin/bidang-keahlian/' + id);
            $('#method').val('PUT');
            $('#kode').val(kode);
            $('#bidang_keahlian').val(bidang);
            $('#modalForm').removeClass('hidden');
        });

        $('#btnCancel').click(function () {
            $('#modalForm').addClass('hidden');
        });
    });
</script>
@endpush
