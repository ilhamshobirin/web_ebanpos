<?php

namespace App\Http\Controllers;

use App\Models\EPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class EpaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = EPaper::paginate(10);
        return Inertia::render('EPaper/Index', [
            'list' => $list,
        ]);
        // return $list;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('EPaper/EPaper');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'release_date' => 'required|max:20',
            'title' => 'required|max:150',
            'desc' => 'required|max:255',
        ]);

        Log::info('Store E-Paper', ['validated' => $validated]);

        if ($validated) {
            EPaper::create([
                'release_date' => $validated['release_date'],
                'title' => $validated['title'],
                'description' => $validated['desc'],
                'page_count' => 0,
            ]);
        }

        session()->flash('flash.banner', 'E-Paper berhasil ditambahkan');
        return redirect()->back();
        // return Redirect::back()->with('status', 'Pesan sukses.');
        // return redirect()->route('dashboard')
        //         ->with('message', 'E-Paper berhasil ditambahkan.');

        // }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = EPaper::find($id);

        return Inertia::render('EPaper/EPaper', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
