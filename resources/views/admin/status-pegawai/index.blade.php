@extends('layouts.app')
@section('breadcrumb','Status Pegawai')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-slate-800">Status Pegawai</h1>
        <a href="{{ route('admin.status-pegawai.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">Tambah</a>
    </div>
    @if(session('success'))<div class="mb-3 text-sm bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-3 text-sm bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded">{{ session('error') }}</div>@endif
    <div class="bg-white border rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->nama }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('admin.status-pegawai.edit',$item) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.status-pegawai.destroy',$item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus status ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="px-4 py-4 text-center text-slate-500">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
