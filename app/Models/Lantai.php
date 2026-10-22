<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lantai extends Model
{
    protected $fillable = [
        'gedung_id',
        'nama',
    ];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }
}
