<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'file'
    ];
}
