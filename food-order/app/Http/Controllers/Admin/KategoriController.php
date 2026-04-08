<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Restoran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriMenu::query()
            ->with('restoran:id_restoran,nama_restoran')
            ->withCount('menu')
            ->latest('id_kategori')
            ->paginate(10);

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        $restoranList = Restoran::query()
            ->orderBy('nama_restoran')
            ->get(['id_restoran', 'nama_restoran']);

        return view('admin.kategori.create', compact('restoranList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_restoran' => ['required', 'exists:restoran,id_restoran'],
            'nama_kategori' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $duplicate = KategoriMenu::query()
            ->where('id_restoran', $validated['id_restoran'])
            ->whereRaw('LOWER(nama_kategori) = ?', [mb_strtolower((string) $validated['nama_kategori'])])
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['nama_kategori' => 'Nama kategori sudah dipakai di restoran tersebut.'])
                ->withInput();
        }

        KategoriMenu::query()->create($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $kategori = KategoriMenu::query()
            ->with(['restoran:id_restoran,nama_restoran', 'menu:id_menu,id_kategori,nama_menu,harga,stok,status'])
            ->findOrFail($id);

        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit(string $id)
    {
        $kategori = KategoriMenu::query()->findOrFail($id);

        $restoranList = Restoran::query()
            ->orderBy('nama_restoran')
            ->get(['id_restoran', 'nama_restoran']);

        return view('admin.kategori.edit', compact('kategori', 'restoranList'));
    }

    public function update(Request $request, string $id)
    {
        $kategori = KategoriMenu::query()->findOrFail($id);

        $validated = $request->validate([
            'id_restoran' => ['required', 'exists:restoran,id_restoran'],
            'nama_kategori' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $duplicate = KategoriMenu::query()
            ->where('id_kategori', '!=', $kategori->id_kategori)
            ->where('id_restoran', $validated['id_restoran'])
            ->whereRaw('LOWER(nama_kategori) = ?', [mb_strtolower((string) $validated['nama_kategori'])])
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['nama_kategori' => 'Nama kategori sudah dipakai di restoran tersebut.'])
                ->withInput();
        }

        $kategori->update($validated);

        return redirect()
            ->route('admin.kategori.show', $kategori->id_kategori)
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriMenu::query()->findOrFail($id);

        $dipakai = Menu::query()->where('id_kategori', $kategori->id_kategori)->exists();
        if ($dipakai) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh menu.');
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
