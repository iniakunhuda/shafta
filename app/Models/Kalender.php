<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kalender extends Model
{
    protected $table = 'kalender';
    protected $fillable = ['title', 'description', 'start', 'end', 'type', 'className', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
