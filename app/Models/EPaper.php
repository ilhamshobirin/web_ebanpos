<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EPaper extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'e_papers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'release_date',
        'title',
        'description',
        'page_count',
        'header_path',
        'epaper_path',
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function headerPath(): Attribute
    {
        return Attribute::make(
            get: fn ($header_path) => url('/storage/epapers/' . $header_path),
        );
    }

    protected function epaperPath(): Attribute
    {
        return Attribute::make(
            get: fn ($epaper_path) => url('/storage/epapers/' . $epaper_path),
        );
    }

}
