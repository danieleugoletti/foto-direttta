<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Event extends Model
{

    public function scopeApproved($query) {
        return $query->where('approved', 1);
    }

    public function scopeSearchApproved($query, $searchText) {
        $query = $query->where('date', '>=', Carbon::now()->toDateTimeString())
                    ->where('approved', 1)
                    ->orderBy('date', 'ASC');

        if ($searchText) {
            $searchText = '%'.$searchText.'%';
            $query->where(function($query) use ($searchText) {
                $query->where('title', 'like', $searchText)
                    ->orWhere('description', 'like', $searchText)
                    ->orWhere('organizer', 'like', $searchText);
            });
        }

        return $query;
    }

}
