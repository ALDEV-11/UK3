@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.restoran.show', $restoran->id_restoran) }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke detail restoran</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Edit Restoran</h2>

                <form method="POST" action="{{ route('admin.restoran.update', $restoran->id_restoran) }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Pemilik (User Role Restoran)</label>
                        <select name="id_user" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected((int) old('id_user', $restoran->id_user) === (int) $user->id)>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Restoran</label>
                        <input type="text" name="nama_restoran" value="{{ old('nama_restoran', $restoran->nama_restoran) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nama_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('deskripsi', $restoran->deskripsi) }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>{{ old('alamat', $restoran->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">No Telp</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', $restoran->no_telp) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('no_telp')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Jam Buka</label>
                            <input type="time" name="jam_buka" value="{{ old('jam_buka', substr((string) $restoran->jam_buka, 0, 5)) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('jam_buka')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Jam Tutup</label>
                            <input type="time" name="jam_tutup" value="{{ old('jam_tutup', substr((string) $restoran->jam_tutup, 0, 5)) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('jam_tutup')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Gambar Restoran</label>
                            <input type="file" name="gambar" accept="image/*" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-[#F5A623] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-[#2C1810] hover:file:bg-[#E8612A] hover:file:text-[#FFF8F3]">
                            <p class="mt-1 text-xs text-[#2C1810]">Kosongkan jika tidak ingin mengganti gambar. Maksimal 2MB.</p>
                            @if ($restoran->gambar)
                                <img src="{{ asset('storage/' . $restoran->gambar) }}" alt="{{ $restoran->nama_restoran }}" class="mt-2 h-24 w-24 rounded-lg object-cover border border-[#F5A623]">
                            @endif
                            @error('gambar')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                                <option value="aktif" @selected(old('status', $restoran->status) === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status', $restoran->status) === 'nonaktif')>Nonaktif</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">Update Restoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
