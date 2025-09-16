@extends('layouts.app')

@section('breadcrumb', 'Test Profile')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Test Profile Page</h1>
    
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <h2 class="text-lg font-semibold mb-2">User Info:</h2>
        <p>Name: {{ auth()->user()->name }}</p>
        <p>Email: {{ auth()->user()->email }}</p>
        <p>Status: {{ auth()->user()->status }}</p>
        <p>Role: {{ auth()->user()->role }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <h2 class="text-lg font-semibold mb-2">Karyawan Data:</h2>
        @if(auth()->user()->karyawan)
            <p>Has Karyawan: YES</p>
            <p>NIK: {{ auth()->user()->karyawan->nik }}</p>
        @else
            <p>Has Karyawan: NO</p>
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-2">Available Data:</h2>
        <p>Ruangan Count: {{ \App\Models\Ruangan::count() }}</p>
        <p>Profesi Count: {{ \App\Models\Profesi::count() }}</p>
    </div>
</div>
@endsection
