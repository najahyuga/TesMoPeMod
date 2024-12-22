<?php

namespace App\Http\Controllers;

use App\Models\modem;
use Illuminate\Http\Request;

class ModemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modems = Modem::paginate(10);
        return view('index', compact('modems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_perangkat'        => 'required|string|max:255',
            'lokasi_pemasangan'     => 'required|string|max:255',
            'tipe_modem'            => 'required|string|max:255',
            'status'                => 'required|in:aktif,nonaktif',
        ]);

        Modem::create($request->all());

        return redirect()->route('modem.index')->with('success', 'Data modem berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(modem $modem)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(modem $modem)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, modem $modem)
    {
        $request->validate([
            'nama_perangkat'    => 'required|string|max:255',
            'lokasi_pemasangan' => 'required|string|max:255',
            'tipe_modem'        => 'required|string|max:255',
            'status'            => 'required|in:aktif,nonaktif',
        ]);

        $modem->update($request->all());

        return redirect()->route('modem.index')->with('success', 'Data modem berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(modem $modem)
    {
        $modem->delete();

        return redirect()->route('modem.index')->with('success', 'Data modem berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $modems = Modem::where('nama_perangkat', 'like', "%$query%")
                        ->orWhere('lokasi_pemasangan', 'like', "%$query%")
                        ->paginate(10);

        return view('index', compact('modems'));
    }
}
