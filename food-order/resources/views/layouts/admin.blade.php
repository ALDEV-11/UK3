@extends('layouts.app')

@section('title', 'Dashboard Admin - ' . config('app.name'))

@section('page_heading')
    <div class="flex items-center justify-between gap-3">
        <h1 class="text-2xl font-extrabold tracking-tight" style="color: #2C1810;">Panel Admin</h1>
        <span class="inline-flex items-center rounded-full px-4 py-1 text-sm font-bold shadow" style="background-color: #E8612A; color: #FFF8F3; letter-spacing: 1px;">
            Admin
        </span>
    </div>
@endsection
