@extends('layouts.app')

@section('title', 'Dashboard Admin - ' . config('app.name'))

@section('page_heading')
    <div class="flex items-center justify-between gap-3">
        <h1 class="text-xl font-semibold text-gray-800">Panel Admin</h1>
        <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
            Admin
        </span>
    </div>
@endsection
