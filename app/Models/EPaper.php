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
        'img_header',
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function imgHeader(): Attribute
    {
        return Attribute::make(
            get: fn ($img_header) => url('/storage/epapers/header/' . $img_header),
        );
    }

}
