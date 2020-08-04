<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = [
        'name', 'url', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
