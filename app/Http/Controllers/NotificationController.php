<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $list = Epaper::when($request->search, function($query, $search){
        //     $query->where('title', 'like', '%'.$search.'%')
        //             ->OrWhere('description', 'like', '%'.$search.'%');
        // })
        // ->orderBy('release_date', 'desc')
        // ->paginate(10);

        return Inertia::render('Notification/Index', [
            // 'list' => $list,
        ]);
    }
}
