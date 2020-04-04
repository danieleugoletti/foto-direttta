<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public function scopeApproved($query) {
        return $query->where('approved', 1);
    }

    public function scopeVisible($query) {
        return $query->where('date', '>=', DB::raw('NOW()'));
    }

}
