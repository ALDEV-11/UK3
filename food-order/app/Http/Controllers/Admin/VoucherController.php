<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = Voucher::query()
            ->latest('id_voucher')
            ->paginate(10);

        return view('admin.voucher.index', compact('voucher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_voucher' => ['required', 'string', 'max:20', 'unique:voucher,kode_voucher'],
            'jenis_diskon' => ['required', Rule::in(['persen', 'nominal'])],
            'nilai_diskon' => ['required', 'numeric', 'min:0'],
            'min_pesanan' => ['required', 'numeric', 'min:0'],
            'maks_diskon' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'tgl_berlaku' => ['required', 'date'],
            'tgl_kadaluarsa' => ['required', 'date', 'after_or_equal:tgl_berlaku'],
        ]);

        Voucher::query()->create($validated);

        return redirect()
            ->route('admin.voucher.index')
            ->with('success', 'Voucher berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $voucher = Voucher::query()->findOrFail($id);

        return view('admin.voucher.show', compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voucher = Voucher::query()->findOrFail($id);

        return view('admin.voucher.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $voucher = Voucher::query()->findOrFail($id);

        $validated = $request->validate([
            'kode_voucher' => ['required', 'string', 'max:20', Rule::unique('voucher', 'kode_voucher')->ignore($voucher->id_voucher, 'id_voucher')],
            'jenis_diskon' => ['required', Rule::in(['persen', 'nominal'])],
            'nilai_diskon' => ['required', 'numeric', 'min:0'],
            'min_pesanan' => ['required', 'numeric', 'min:0'],
            'maks_diskon' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'tgl_berlaku' => ['required', 'date'],
            'tgl_kadaluarsa' => ['required', 'date', 'after_or_equal:tgl_berlaku'],
        ]);

        $voucher->update($validated);

        return redirect()
            ->route('admin.voucher.show', $voucher->id_voucher)
            ->with('success', 'Voucher berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::query()->findOrFail($id);
        $voucher->delete();

        return redirect()
            ->route('admin.voucher.index')
            ->with('success', 'Voucher berhasil dihapus.');
    }
}
