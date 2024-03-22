<?php

namespace App\Http\Controllers;

use App\Models\EPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EpaperController extends Controller
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
            'files.*' => 'file|mimes:jpg,png|max:10240'
        ]);

        Log::info('Store E-Paper', ['validated' => $validated]);

        if ($validated) {
            if($request->hasFile('files')){

                $files = $request->file('files');
                $directory = 'public/epapers/' . $validated['release_date'];
    
                if (Storage::exists($directory)) {
                    Storage::deleteDirectory($directory);
                }

                $index = 1;
    
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = ($extension === 'jpg') ? $index . '.jpg' : $index . '.png';
                    $file->storeAs($directory, $filename);
    
                    $index++;
                }

                // Save Header Image
                $file = $files[0];

                if ($file) {
                    $header_directory = 'public/epapers/header';

                    $header_extension = $file->getClientOriginalExtension();
                    $header_filename = ($header_extension === 'jpg') ? $validated['release_date'] . '.jpg' : $validated['release_date'] . '.png';
                    $file->storeAs($header_directory, $header_filename);
                    
                    EPaper::create([
                        'release_date' => $validated['release_date'],
                        'title' => $validated['title'],
                        'description' => $validated['desc'],
                        'page_count' => 0,
                        'img_header' => $header_filename
                    ]);
                }
                
    
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
        // return redirect()->route('epaper.index');
        // return $request;
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
        //
    }
}
