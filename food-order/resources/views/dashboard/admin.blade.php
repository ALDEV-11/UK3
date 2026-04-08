<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
            <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                Admin
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <p class="text-gray-700">Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>. Anda login sebagai <span class="font-semibold text-rose-600">Admin</span>.</p>
                <p class="mt-1 text-sm text-gray-500">Kelola data master, laporan, dan monitoring sistem dari menu berikut.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <a href="{{ route('profile.edit') }}" class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 hover:ring-indigo-200">
                    <p class="text-sm text-gray-500">Akun</p>
                    <h3 class="mt-1 font-semibold text-gray-900">Kelola Profil</h3>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 hover:ring-indigo-200">
                    <p class="text-sm text-gray-500">Laporan</p>
                    <h3 class="mt-1 font-semibold text-gray-900">Lihat & Export Laporan</h3>
                </a>

                <a href="{{ route('admin.laporan.pdf') }}" class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 hover:ring-indigo-200">
                    <p class="text-sm text-gray-500">Dokumen</p>
                    <h3 class="mt-1 font-semibold text-gray-900">Download PDF Bulan Ini</h3>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
