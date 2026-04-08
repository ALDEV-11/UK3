<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KurirController extends Controller
{
    public function index()
    {
        $kurir = Kurir::query()
            ->latest('id_kurir')
            ->paginate(10);

        return view('admin.kurir.index', compact('kurir'));
    }

    public function create()
    {
        return view('admin.kurir.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kurir' => ['required', 'string', 'max:120'],
            'no_telp' => ['required', 'string', 'max:20', 'unique:kurir,no_telp'],
            'jenis_kendaraan' => ['required', Rule::in(['motor', 'mobil'])],
            'plat_kendaraan' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        Kurir::query()->create($validated);

        return redirect()
            ->route('admin.kurir.index')
            ->with('success', 'Data kurir berhasil ditambahkan.');
    }

    public function edit(Kurir $kurir)
    {
        return view('admin.kurir.edit', compact('kurir'));
    }

    public function update(Request $request, Kurir $kurir)
    {
        $validated = $request->validate([
            'nama_kurir' => ['required', 'string', 'max:120'],
            'no_telp' => ['required', 'string', 'max:20', Rule::unique('kurir', 'no_telp')->ignore($kurir->id_kurir, 'id_kurir')],
            'jenis_kendaraan' => ['required', Rule::in(['motor', 'mobil'])],
            'plat_kendaraan' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $kurir->update($validated);

        return redirect()
            ->route('admin.kurir.index')
            ->with('success', 'Data kurir berhasil diperbarui.');
    }

    public function destroy(Kurir $kurir)
    {
        $kurir->delete();

        return redirect()
            ->route('admin.kurir.index')
            ->with('success', 'Data kurir berhasil dihapus.');
    }
}
