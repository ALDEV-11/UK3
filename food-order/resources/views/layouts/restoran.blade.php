@extends('layouts.app')

@section('title', 'Dashboard Restoran - ' . config('app.name'))

@section('page_heading')
    <div class="flex items-center justify-between gap-3">
        <h1 class="text-xl font-semibold text-gray-800">Panel Restoran</h1>
        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
            Restoran
        </span>
    </div>
@endsection
