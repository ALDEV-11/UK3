<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $kategori = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->withCount('menu')
            ->latest('id_kategori')
            ->paginate(10);

        return view('restoran.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restoran.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori_menu', 'nama_kategori')->where(fn ($q) => $q->where('id_restoran', $restoranId)),
            ],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['id_restoran'] = $restoranId;

        KategoriMenu::query()->create($validated);

        return redirect()
            ->route('restoran.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $kategori = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->with('menu:id_menu,id_kategori,nama_menu,harga,stok,status')
            ->findOrFail($id);

        return view('restoran.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $kategori = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        return view('restoran.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $kategori = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori_menu', 'nama_kategori')
                    ->where(fn ($q) => $q->where('id_restoran', $restoranId))
                    ->ignore($kategori->id_kategori, 'id_kategori'),
            ],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('restoran.kategori.show', $kategori->id_kategori)
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $kategori = KategoriMenu::query()
            ->where('id_restoran', $restoranId)
            ->findOrFail($id);

        $digunakanMenu = Menu::query()
            ->where('id_restoran', $restoranId)
            ->where('id_kategori', $kategori->id_kategori)
            ->exists();

        if ($digunakanMenu) {
            return redirect()
                ->route('restoran.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh menu.');
        }

        $kategori->delete();

        return redirect()
            ->route('restoran.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
