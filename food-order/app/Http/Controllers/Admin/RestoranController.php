<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restoran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestoranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restoran = Restoran::query()
            ->with('user:id,name,email')
            ->latest('id_restoran')
            ->paginate(10);

        return view('admin.restoran.index', compact('restoran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query()
            ->where('role', 'restoran')
            ->whereDoesntHave('restoran')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.restoran.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', 'restoran')),
                'unique:restoran,id_user',
            ],
            'nama_restoran' => ['required', 'string', 'max:150', 'unique:restoran,nama_restoran'],
            'deskripsi' => ['nullable', 'string'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:15'],
            'gambar' => ['nullable', 'string', 'max:255'],
            'jam_buka' => ['required', 'date_format:H:i'],
            'jam_tutup' => ['required', 'date_format:H:i', 'after:jam_buka'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $restoran = Restoran::query()->create($validated);

        return redirect()
            ->route('admin.restoran.show', $restoran->id_restoran)
            ->with('success', 'Data restoran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restoran = Restoran::query()
            ->with('user:id,name,email')
            ->findOrFail($id);

        return view('admin.restoran.show', compact('restoran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restoran = Restoran::query()->findOrFail($id);

        $users = User::query()
            ->where('role', 'restoran')
            ->where(function ($q) use ($restoran) {
                $q->whereDoesntHave('restoran')
                    ->orWhere('id', $restoran->id_user);
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.restoran.edit', compact('restoran', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $restoran = Restoran::query()->findOrFail($id);

        $validated = $request->validate([
            'id_user' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', 'restoran')),
                Rule::unique('restoran', 'id_user')->ignore($restoran->id_restoran, 'id_restoran'),
            ],
            'nama_restoran' => ['required', 'string', 'max:150', Rule::unique('restoran', 'nama_restoran')->ignore($restoran->id_restoran, 'id_restoran')],
            'deskripsi' => ['nullable', 'string'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:15'],
            'gambar' => ['nullable', 'string', 'max:255'],
            'jam_buka' => ['required', 'date_format:H:i'],
            'jam_tutup' => ['required', 'date_format:H:i', 'after:jam_buka'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $restoran->update($validated);

        return redirect()
            ->route('admin.restoran.show', $restoran->id_restoran)
            ->with('success', 'Data restoran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restoran = Restoran::query()->findOrFail($id);
        $restoran->delete();

        return redirect()
            ->route('admin.restoran.index')
            ->with('success', 'Data restoran berhasil dihapus.');
    }
}
