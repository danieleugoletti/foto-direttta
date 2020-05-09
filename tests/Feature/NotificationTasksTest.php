<?php

namespace Tests\Feature;

use App\Console\Notification\Tasks\BeforeStartTask;
use App\Console\Notification\Tasks\DailyFullTask;
use App\Console\Notification\Tasks\DailyShortTask;
use App\Console\Notification\Gateways\DebugGateway;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class NotificationTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_send_before_start_notification()
    {
        $numberEvents = 4;
        $minutesBeforeStart = 10;
        $minutesBeforeStartString = intval($minutesBeforeStart/2).'m';

        config(['foto-diretta.notification.beforeStart.minutesBeforeStart' => $minutesBeforeStart]);
        config(['foto-diretta.notification.beforeStart.gateway' => ['debug']]);

        $this->eventFactory(['date' => Carbon::now()->add($minutesBeforeStartString)], $numberEvents);
        $this->eventFactory(['date' => Carbon::now()->add('1h')]);

        $mocked = $this->mock(DebugGateway::class, function ($mock) use ($numberEvents) {
            $mock->shouldReceive('formatBeforeStart')->times($numberEvents);
            $mock->shouldReceive('post')->times($numberEvents);
        });
        config(['foto-diretta.notification.gateway.debug.class' => $mocked]);

        $task = new BeforeStartTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_before_start_notification_with_zero_events()
    {
        $this->performFullAndShorTaskZeroEvents('formatBeforeStart');

        $task = new BeforeStartTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_daily_full_notification()
    {
        config(['foto-diretta.notification.dailyFull.gateway' => ['debug']]);

        $this->performFullAndShorTask('formatDailyFull');
        $task = new DailyFullTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_daily_full_notification_with_zero_events()
    {
        config(['foto-diretta.notification.dailyFull.gateway' => ['debug']]);

        $this->performFullAndShorTaskZeroEvents('formatDailyFull');
        $task = new DailyFullTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_daily_short_notification()
    {
        config(['foto-diretta.notification.dailyShort.gateway' => ['debug']]);

        $this->performFullAndShorTask('formatDailyShort');
        $task = new DailyShortTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_not_send_daily_short_notification_with_zero_events()
    {
        config(['foto-diretta.notification.dailyShort.gateway' => ['debug']]);

        $this->performFullAndShorTaskZeroEvents('formatDailyShort');
        $task = new DailyShortTask();
        $task();
    }

    /**
     * @param  string $taskName
     */
    private function performFullAndShorTask($taskName)
    {
        $numberEvents = 4;
        $this->eventFactory(['date' => Carbon::now()->add('1h')], $numberEvents);
        $this->eventFactory(['date' => Carbon::now()->add('1d')]);

        $mocked = $this->mock(DebugGateway::class, function ($mock) use ($taskName, $numberEvents) {
            $mock->shouldReceive($taskName)
                ->once()
                ->withArgs(function (Collection $events, $searchLink) use ($numberEvents) {
                    return $events->count() == $numberEvents;
                });

            $mock->shouldReceive('post')->once();
        });
        config(['foto-diretta.notification.gateway.debug.class' => $mocked]);
    }

    /**
     * @param  string $taskName
     */
    private function performFullAndShorTaskZeroEvents($taskName)
    {
        $mocked = $this->mock(DebugGateway::class, function ($mock) use ($taskName) {
            $mock->shouldNotReceive($taskName);
            $mock->shouldNotReceive('post');
        });
        config(['foto-diretta.notification.gateway.debug.class' => $mocked]);
    }
}
