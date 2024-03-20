<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\EPaper;
use Illuminate\Http\Request;

class EpaperController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $epapers = EPaper::latest()->paginate(5);

        //return collection of posts as a resource
        return new ApiResource(true, 'List Data E-Paper', $epapers);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $post = EPaper::find($id);

        //return single post as a resource
        return new ApiResource(true, 'Detail Data E-Paper', $post);
    }
}
