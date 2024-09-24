<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    /**
     * Interact with the short_url attribute.
     *
     * return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function shortUrl(): Attribute
    {
        return Attribute::make(fn ( $value, $attributes) => route('short.url',$attributes['short_code']) );
    }
}
