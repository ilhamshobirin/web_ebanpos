<?php

namespace App\Http\Controllers;

use App\Models\EPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list = Epaper::when($request->search, function($query, $search){
            $query->where('title', 'like', '%'.$search.'%')
                    ->OrWhere('description', 'like', '%'.$search.'%');
        })
        ->orderBy('release_date', 'desc')
        ->paginate(10);

        return Inertia::render('EPaper/Index', [
            'list' => $list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $edit_mode = '0';

        return Inertia::render('EPaper/Editor', [
            'edit_mode' => $edit_mode
        ]);
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
            'header' => 'file|mimes:jpg,png|max:10240',
            'epaper' => 'file|mimes:pdf',
        ]);

        Log::info('Store E-Paper', ['validated' => $validated]);

        if ($validated) {
            //HEADER
            $header_directory = 'public/epapers';
          	$header_prefix = 'header_';

            //if (Storage::exists($header_directory)) {
            //    Storage::deleteDirectory($header_directory);
            //}

            $header_file = $request->file('header');
            $header_extension = $header_file->getClientOriginalExtension();
            $header_filename = ($header_extension === 'jpg') ? $header_prefix.$validated['release_date'] . '.jpg' : $header_prefix.$validated['release_date'] . '.png';
            $header_file->storeAs($header_directory, $header_filename);

            // EPAPER
            $epaper_directory = 'public/epapers';
            $epaper_prefix = 'epaper_';

            //if (Storage::exists($epaper_directory)) {
            //    Storage::deleteDirectory($epaper_directory);
            //}

            $epaper_file = $request->file('epaper');
            $epaper_filename = $epaper_prefix.$validated['release_date'] . '.pdf';
            $epaper_file->storeAs($epaper_directory, $epaper_filename);

            EPaper::create([
                'release_date' => $validated['release_date'],
                'title' => $validated['title'],
                'description' => $validated['desc'],
                'header_path' => $header_filename,
                'epaper_path' => $epaper_filename
            ]);
                
            $data = [
                'title' => $validated['title'],
                'body' => $validated['desc'],
            ];
        
            session()->flash('flash.banner', 'E-Paper berhasil ditambahkan. Silakan buat notifikasi untuk epaper baru');
            return Inertia::render('Notification/Editor', [
                'data' => $data
            ]);

        }
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
        $edit_mode = '1';

        return Inertia::render('EPaper/Editor', [
            'data' => $data,
            'edit_mode' => $edit_mode
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
        $data = EPaper::find($id);

        $data->delete();

        Log::info('Delete E-Paper ID' . $id);

        session()->flash('flash.banner', 'E-Paper berhasil dihapus.');
        session()->flash('flash.bannerStyle', 'success');

        return Redirect::route('epaper.index');
    }
}
