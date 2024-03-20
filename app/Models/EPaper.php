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
    ];

    /**
     * image
     *
     * @return Attribute
     */
    // protected function release_date(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($release_date) => url('/storage/epaper/' . $release_date),
    //     );
    // }

}
