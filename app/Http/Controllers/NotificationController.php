<?php

namespace App\Http\Controllers;

use App\Models\AppParameter;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list = Notification::when($request->search, function($query, $search){
            $query->where('title', 'like', '%'.$search.'%')
                    ->OrWhere('body', 'like', '%'.$search.'%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return Inertia::render('Notification/Index', [
            'list' => $list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('Notification/Editor', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'body' => 'required|max:255'
        ]);

        Log::info('Store Notification', ['validated' => $validated]);

        if ($validated) {

            $url = 'https://fcm.googleapis.com/fcm/send';
            
            $key = AppParameter::all()->first()->fcm_key;

            $data = [
                'to' => '/topics/flutter_notification',
                'notification' => [
                    'title' => $validated['title'],
                    'body' => $validated['body'],
                ],
            ];

            $headers = [
                'Authorization' => 'key=' . $key,
                'Content-Type' => 'application/json', 
            ];

            $response = Http::withHeaders($headers)
                            ->withoutVerifying()
                            ->post($url, $data);

            if ($response->status() === 200) {
                Notification::create([
                    'title' => $validated['title'],
                    'body' => $validated['body'],
                ]);
                
                session()->flash('flash.banner', 'Notifikasi Berhasil terkirim');
                return redirect()->route('notification.index');
            } else {
                session()->flash('flash.bannerStyle', 'danger'); 
                session()->flash('flash.banner', 'Notifikasi gagal terkirim: '. $response->status()); 
            }
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Notification::find($id);

        return Inertia::render('Notification/Editor', [
            'data' => $data
        ]);
    }
}
