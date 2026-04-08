<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use App\Models\Restoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function edit()
    {
        $restoran = Restoran::query()->findOrFail((int) Auth::user()?->restoran?->id_restoran);

        return view('restoran.profil.edit', compact('restoran'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_restoran' => ['required', 'string', 'max:120'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_telp' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $restoran = Restoran::query()->findOrFail((int) Auth::user()?->restoran?->id_restoran);
        $restoran->update($validated);

        return redirect()
            ->route('restoran.profil.edit')
            ->with('success', 'Profil restoran berhasil diperbarui.');
    }
}
