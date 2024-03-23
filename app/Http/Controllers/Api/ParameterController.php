<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\AppParameter;
use App\Models\WPCategoryParams;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $appParameter = AppParameter::all()->first();
        $wpCategory = WPCategoryParams::all();

        $data = [
            'wp_api_url' => $appParameter->wp_api_url,
            'wp_category' => $wpCategory,
        ];

        return new ApiResource(true, 'Data Parameter', $data);
    }
}