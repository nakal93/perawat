<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profesi;
use Illuminate\Http\Request;

class ProfesiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesi = Profesi::paginate(10);
        return view('admin.profesi.index', compact('profesi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profesi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_profesi' => 'required|string|max:255',
            'kode_profesi' => 'required|string|max:50',
            'deskripsi' => 'nullable|string'
        ]);

        Profesi::create($validated);

        return redirect()->route('admin.profesi.index')
            ->with('success', 'Profesi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profesi $profesi)
    {
        return view('admin.profesi.show', compact('profesi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profesi $profesi)
    {
        return view('admin.profesi.edit', compact('profesi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profesi $profesi)
    {
        $validated = $request->validate([
            'nama_profesi' => 'required|string|max:255',
            'kode_profesi' => 'required|string|max:50',
            'deskripsi' => 'nullable|string'
        ]);

        $profesi->update($validated);

        return redirect()->route('admin.profesi.index')
            ->with('success', 'Profesi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesi $profesi)
    {
        $profesi->delete();

        return redirect()->route('admin.profesi.index')
            ->with('success', 'Profesi berhasil dihapus');
    }
}
