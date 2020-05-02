<?php

namespace Tests;

use App\Event;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Carbon\Carbon;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    /**
     * @param  array $overrideValues
     * @param  integer $number
     * @return Event|Collection
     */
    protected function eventFactory($overrideValues=[], $number=null)
    {
        $now = Carbon::now();
        return factory(Event::class, $number)->create(array_merge([
            'title' => '',
            'description' => '',
            'date' => $now->toDateTimeString(),
            'approved' => 1
        ], $overrideValues));
    }
}
