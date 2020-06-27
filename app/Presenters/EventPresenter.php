<?php

namespace App\Presenters;

use App\Helpers\HashidHelper;
use Robbo\Presenter\Presenter;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use Carbon\Carbon;

class EventPresenter extends Presenter
{
    private $day;
    private $month;
    private $time;
    private $type;
    private $calendarUrl;
    private $descriptionHtml;
    private $isToday;

    /**
     * Create the Presenter and store the object we are presenting.
     *
     * @param mixed $object
     */
    public function __construct($object)
    {
        parent::__construct($object);

        $date = Carbon::create($object->date);
        $this->day = $date->isoFormat('dddd D');
        $this->month = $date->isoFormat('MMMM');
        $this->time = $date->isoFormat('LT');
        $this->descriptionHtml = $this->convertDescriptionToHtml($object->description);
        $this->type = $this->guessEventType($object->url);

        $hashids = resolve('Helpers\HashidHelper');
        $this->calendarUrl = route('calendar', ['id' => $hashids->encodeId($object->id)]);

        $this->isToday = Carbon::now()->diffInDays($date) === 0;
    }

    /**
     * @return string
     */
    public function presentDay()
    {
        return $this->day;
    }

    /**
     * @return string
     */
    public function presentMonth()
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function presentTime()
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function presentDescriptionHtml()
    {
        return $this->descriptionHtml;
    }

    /**
     * @return string
     */
    public function presentType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function presentCalendarUrl()
    {
        return $this->calendarUrl;
    }

    /**
     * @return boolean
     */
    public function presentIsToday()
    {
        return $this->isToday;
    }

   /**
    * Get description in html
    * @param  string $description
    * @return string
    */
    private function convertDescriptionToHtml($description)
    {
        if (!$description) return '';

        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AutolinkExtension());

        $converter = new CommonMarkConverter([], $environment);
        return $converter->convertToHtml($description);
    }


    /**
     * @param  string $url
     * @return string
     */
    private function guessEventType($url)
    {
        if (strpos($url, 'facebook.com')) {
            return __('foto-diretta.event-type-facebook');
        }
        if (strpos($url, 'instagram.com')) {
            return __('foto-diretta.event-type-instagram');
        }

        return __('foto-diretta.event-type-live');
    }
}
