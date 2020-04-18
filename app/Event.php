<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Event extends Model
{
    public $fillable = ['title', 'organizer', 'description', 'url', 'image_url', 'date', 'approved'];

    public function scopeApproved($query) {
        return $query->where('approved', 1);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  string $searchText
     * @param  string $searchDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchApproved($query, $searchText, $searchDate) {
        $query = $query->where('date', '>=', Carbon::now()->toDateTimeString())
                    ->where('approved', 1)
                    ->orderBy('date', 'ASC');

        if ($searchText) {
            $query->where(function($query) use ($searchText) {
                $query->where('title', 'like', $searchText)
                    ->orWhere('description', 'like', $searchText)
                    ->orWhere('organizer', 'like', $searchText);
            });
        }

        if ($searchDate) {
            $query->where(DB::raw('date(date)'), '=', $searchDate);
        }

        return $query;
    }
}
