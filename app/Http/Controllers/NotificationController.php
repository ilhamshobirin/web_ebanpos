<?php

namespace App\Http\Controllers;

use App\Models\AppParameter;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Exception\FirebaseException;


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

            $message = CloudMessage::fromArray([
                'notification' => [
                    'title' => $validated['title'],
                    'body' => $validated['body'],
                ],
                'topic' => 'flutter_notification',
            ]);
    
            $firebaseMessaging = app('firebase.messaging');
            
            try {
                $response = $firebaseMessaging->send($message);

                // dd($response);

                Notification::create([
                    'title' => $validated['title'],
                    'body' => $validated['body'],
                ]);

                session()->flash('flash.banner', 'Notifikasi Berhasil terkirim');
                return redirect()->route('notification.index');
                
            } catch (MessagingException $e) {
                // Jika pengiriman gagal karena masalah dengan Firebase
                session()->flash('flash.bannerStyle', 'danger'); 
                session()->flash('flash.banner', 'Notifikasi gagal terkirim: '. $e->getMessage());
            } catch (FirebaseException $e) {
                // Jika terjadi kesalahan umum dengan Firebase
                session()->flash('flash.bannerStyle', 'danger'); 
                session()->flash('flash.banner', 'Notifikasi gagal terkirim: '. $e->getMessage());
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
