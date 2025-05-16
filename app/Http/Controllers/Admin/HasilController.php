<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSempro;
use App\Models\JadwalSempro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $hasil = HasilSempro::with(['jadwalSempro.pengajuanSempro.mahasiswa.user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('jadwalSempro.pengajuanSempro', function ($q) use ($search) {
                        $q->where('judul', 'like', "%{$search}%")
                            ->orWhereHas('mahasiswa.user', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->paginate(10); // Add pagination
        return view('admin.hasil.index', compact('hasil', 'search'));
    }

    public function create()
    {
        // Hanya ambil jadwal sempro yang belum memiliki hasil
        $jadwalSemproList = JadwalSempro::whereNotIn('id', HasilSempro::pluck('jadwal_sempro_id'))
            ->with('pengajuanSempro')
            ->get();
        return view('admin.hasil.create', compact('jadwalSemproList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_sempro_id' => [
                'required',
                'exists:jadwal_sempro,id',
                Rule::unique('hasil_sempro', 'jadwal_sempro_id'),
            ],
            'nilai_peng1' => 'required|numeric|min:0|max:100',
            'nilai_peng2' => 'required|numeric|min:0|max:100',
            'nilai_peng3' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:lolos_tanpa_revisi,revisi_minor,revisi_mayor,tidak_lolos',
            'revisi_file' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        // Hitung rata-rata
        $rata_rata = ($validated['nilai_peng1'] + $validated['nilai_peng2'] + $validated['nilai_peng3']) / 3;

        // Simpan file revisi jika ada
        $revisi_file_path = null;
        if ($request->hasFile('revisi_file')) {
            $revisi_file_path = $request->file('revisi_file')->storeAs(
                'revisi',
                time() . '_' . $request->file('revisi_file')->getClientOriginalName(),
                'public'
            );
        }

        HasilSempro::create([
            'jadwal_sempro_id' => $validated['jadwal_sempro_id'],
            'nilai_peng1' => $validated['nilai_peng1'],
            'nilai_peng2' => $validated['nilai_peng2'],
            'nilai_peng3' => $validated['nilai_peng3'],
            'rata_rata' => $rata_rata,
            'status' => $validated['status'],
            'revisi_file_path' => $revisi_file_path,
        ]);

        return redirect()->route('admin.hasil.sempro.index')
            ->with('success', 'Hasil sempro berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hasil = HasilSempro::findOrFail($id);
        // Ambil jadwal sempro yang belum memiliki hasil, tapi sertakan jadwal saat ini
        $jadwalSemproList = JadwalSempro::whereNotIn('id', HasilSempro::where('id', '!=', $id)->pluck('jadwal_sempro_id'))
            ->with('pengajuanSempro')
            ->get();
        return view('admin.hasil.edit', compact('hasil', 'jadwalSemproList'));
    }

    public function update(Request $request, $id)
    {
        $hasil = HasilSempro::findOrFail($id);

        $validated = $request->validate([
            'jadwal_sempro_id' => [
                'required',
                'exists:jadwal_sempro,id',
                Rule::unique('hasil_sempro', 'jadwal_sempro_id')->ignore($id),
            ],
            'nilai_peng1' => 'required|numeric|min:0|max:100',
            'nilai_peng2' => 'required|numeric|min:0|max:100',
            'nilai_peng3' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:lolos_tanpa_revisi,revisi_minor,revisi_mayor,tidak_lolos',
            'revisi_file' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        // Hitung rata-rata
        $rata_rata = ($validated['nilai_peng1'] + $validated['nilai_peng2'] + $validated['nilai_peng3']) / 3;

        // Simpan file revisi baru jika ada, hapus file lama
        $revisi_file_path = $hasil->revisi_file_path;
        if ($request->hasFile('revisi_file')) {
            if ($revisi_file_path && Storage::disk('public')->exists($revisi_file_path)) {
                Storage::disk('public')->delete($revisi_file_path);
            }
            $revisi_file_path = $request->file('revisi_file')->storeAs(
                'revisi',
                time() . '_' . $request->file('revisi_file')->getClientOriginalName(),
                'public'
            );
        }

        $hasil->update([
            'jadwal_sempro_id' => $validated['jadwal_sempro_id'],
            'nilai_peng1' => $validated['nilai_peng1'],
            'nilai_peng2' => $validated['nilai_peng2'],
            'nilai_peng3' => $validated['nilai_peng3'],
            'rata_rata' => $rata_rata,
            'status' => $validated['status'],
            'revisi_file_path' => $revisi_file_path,
        ]);

        return redirect()->route('admin.hasil.sempro.index')
            ->with('success', 'Hasil sempro berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hasil = HasilSempro::findOrFail($id);
        if ($hasil->revisi_file_path && Storage::disk('public')->exists($hasil->revisi_file_path)) {
            Storage::disk('public')->delete($hasil->revisi_file_path);
        }
        $hasil->delete();

        return redirect()->route('admin.hasil.sempro.index')
            ->with('success', 'Hasil sempro berhasil dihapus.');
    }
}
