@extends('admin.layouts.main')

@section('title', 'Ganti Dosen Penguji')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ganti Dosen Penguji {{ $penguji }}</h2>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.jadwal.sempro.approval.update.penguji', ['jadwal' => $jadwal->id, 'penguji' => $penguji]) }}"
            method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="dosen_id" class="block text-gray-700 font-medium mb-2">Dosen Baru</label>
                    <select id="dosen_id" name="dosen_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="" {{ old('dosen_id') == '' ? 'selected' : '' }}>-- Pilih Dosen --</option>
                        @foreach ($dosen as $d)
                            <option value="{{ $d->id }}"
                                {{ old('dosen_id', $currentDosenId) == $d->id ? 'selected' : '' }}>
                                {{ $d->user->name }} ({{ $d->bidangKeilmuan->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status Approval</label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="pending" {{ old('status', $currentStatus) == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="setuju" {{ old('status', $currentStatus) == 'setuju' ? 'selected' : '' }}>
                            Setuju</option>
                        <option value="tolak" {{ old('status', $currentStatus) == 'tolak' ? 'selected' : '' }}>Tolak
                        </option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
