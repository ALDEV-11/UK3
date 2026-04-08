<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use App\Models\Restoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function edit()
    {
        $restoran = Restoran::query()->findOrFail((int) Auth::user()?->restoran?->id_restoran);

        return view('restoran.jadwal.edit', compact('restoran'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'jam_buka' => ['required', 'date_format:H:i'],
            'jam_tutup' => ['required', 'date_format:H:i', 'after:jam_buka'],
        ]);

        $restoran = Restoran::query()->findOrFail((int) Auth::user()?->restoran?->id_restoran);
        $restoran->update($validated);

        return redirect()
            ->route('restoran.jadwal.edit')
            ->with('success', 'Jadwal restoran berhasil diperbarui.');
    }
}
