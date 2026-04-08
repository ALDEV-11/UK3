<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $menu = Menu::query()
            ->with('kategori:id_kategori,nama_kategori')
            ->where('id_restoran', $restoranId)
            ->latest('id_menu')
            ->paginate(10);

        return view('restoran.menu.index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $kategoriList = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->orderBy('nama_kategori')
            ->get(['id_kategori', 'nama_kategori']);

        return view('restoran.menu.create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $validated = $request->validate([
            'id_kategori' => [
                'required',
                Rule::exists('kategori_menu', 'id_kategori')->where(fn ($q) => $q->where('id_restoran', $restoranId)),
            ],
            'nama_menu' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['tersedia', 'habis'])],
        ]);

        $validated['id_restoran'] = $restoranId;

        Menu::query()->create($validated);

        return redirect()
            ->route('restoran.menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $menu = Menu::query()
            ->with('kategori:id_kategori,nama_kategori')
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        return view('restoran.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $menu = Menu::query()
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        $kategoriList = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->orderBy('nama_kategori')
            ->get(['id_kategori', 'nama_kategori']);

        return view('restoran.menu.edit', compact('menu', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $menu = Menu::query()
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        $validated = $request->validate([
            'id_kategori' => [
                'required',
                Rule::exists('kategori_menu', 'id_kategori')->where(fn ($q) => $q->where('id_restoran', $restoranId)),
            ],
            'nama_menu' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['tersedia', 'habis'])],
        ]);

        $menu->update($validated);

        return redirect()
            ->route('restoran.menu.show', $menu->id_menu)
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $menu = Menu::query()
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        $menu->delete();

        return redirect()
            ->route('restoran.menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
