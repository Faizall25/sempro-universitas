@extends('mahasiswa.layouts.main')

@section('content')
<div class="container mx-auto p-6">
    @if (!$canEdit)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <p class="text-sm">Pengajuan hanya dapat diedit jika status masih pending dan belum terjadwal.</p>
        </div>
    @else
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <p class="text-sm">Pengajuan dapat diedit karena status masih pending dan belum terjadwal.</p>
        </div>
    @endif
</div>
@endsection