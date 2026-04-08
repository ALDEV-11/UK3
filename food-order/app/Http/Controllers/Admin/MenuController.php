<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Restoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = Menu::query()
            ->with(['restoran:id_restoran,nama_restoran', 'kategori:id_kategori,nama_kategori'])
            ->latest('id_menu')
            ->paginate(10);

        return view('admin.menu.index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restoranList = Restoran::query()
            ->orderBy('nama_restoran')
            ->get(['id_restoran', 'nama_restoran']);

        $kategoriList = KategoriMenu::query()
            ->with('restoran:id_restoran,nama_restoran')
            ->orderBy('nama_kategori')
            ->get(['id_kategori', 'id_restoran', 'nama_kategori']);

        return view('admin.menu.create', compact('restoranList', 'kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_restoran' => ['required', 'exists:restoran,id_restoran'],
            'id_kategori' => ['required', 'exists:kategori_menu,id_kategori'],
            'nama_menu' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'stok' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['tersedia', 'habis'])],
        ]);

        $kategori = KategoriMenu::query()->findOrFail((int) $validated['id_kategori']);
        if ((int) $kategori->id_restoran !== (int) $validated['id_restoran']) {
            return back()
                ->withErrors(['id_kategori' => 'Kategori tidak sesuai dengan restoran yang dipilih.'])
                ->withInput();
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        Menu::query()->create($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::query()
            ->with(['restoran:id_restoran,nama_restoran', 'kategori:id_kategori,nama_kategori'])
            ->findOrFail($id);

        return view('admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::query()->findOrFail($id);

        $restoranList = Restoran::query()
            ->orderBy('nama_restoran')
            ->get(['id_restoran', 'nama_restoran']);

        $kategoriList = KategoriMenu::query()
            ->with('restoran:id_restoran,nama_restoran')
            ->orderBy('nama_kategori')
            ->get(['id_kategori', 'id_restoran', 'nama_kategori']);

        return view('admin.menu.edit', compact('menu', 'restoranList', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::query()->findOrFail($id);

        $validated = $request->validate([
            'id_restoran' => ['required', 'exists:restoran,id_restoran'],
            'id_kategori' => ['required', 'exists:kategori_menu,id_kategori'],
            'nama_menu' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'stok' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['tersedia', 'habis'])],
        ]);

        $kategori = KategoriMenu::query()->findOrFail((int) $validated['id_kategori']);
        if ((int) $kategori->id_restoran !== (int) $validated['id_restoran']) {
            return back()
                ->withErrors(['id_kategori' => 'Kategori tidak sesuai dengan restoran yang dipilih.'])
                ->withInput();
        }

        if ($request->hasFile('gambar')) {
            if (! empty($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('menu', 'public');
        } else {
            unset($validated['gambar']);
        }

        $menu->update($validated);

        return redirect()
            ->route('admin.menu.show', $menu->id_menu)
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::query()->findOrFail($id);

        if (! empty($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
