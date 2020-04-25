<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;

class Event extends Model implements Feedable
{
    public $fillable = ['title', 'organizer', 'description', 'url', 'image_url', 'date', 'approved'];

   /**
    * Get description in html
    *
    * @return string
    */
    public function getDescriptionHtmlAttribute()
    {
        if (!$this->description) return '';

        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AutolinkExtension());

        $converter = new CommonMarkConverter([], $environment);
        return $converter->convertToHtml($this->description);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query) {
        return $query->where('approved', 1);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  string $searchText
     * @param  string $searchDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchApproved($query, $searchText='', $searchDate='', $timeOffset=null) {
        $now = Carbon::now();
        if ($timeOffset) {
            $ci = CarbonInterval::fromString($timeOffset);
            $now->sub($ci);
        }
        $query = $query->where('date', '>=', $now->toDateTimeString())
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

    /**
     * @return Spatie\Feed\FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create([
            'id' => sha1($this->id),
            'title' => $this->title,
            'summary' => $this->description_html,
            'updated' => Carbon::create($this->date),
            'link' => $this->url,
            'author' => $this->organizer,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAllFeedItems()
    {
       return self::searchApproved()->get();
    }
}
