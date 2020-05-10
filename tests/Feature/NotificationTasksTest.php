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

    protected function setUp(): void
    {
        parent::setUp();

        config(['foto-diretta.notification.beforeStart.gateway' => ['debug']]);
        config(['foto-diretta.notification.dailyFull.gateway' => ['debug']]);
        config(['foto-diretta.notification.dailyShort.gateway' => ['debug']]);
    }


    /**
     * @test
     */
    public function it_will_send_before_start_notification()
    {
        $this->performBeforeStartTask();

        $task = new BeforeStartTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_before_start_notification_with_date()
    {
        $date = Carbon::now()->sub('10d');
        $this->performBeforeStartTask($date);

        $task = new BeforeStartTask();
        $task($date);
    }

    /**
     * @test
     */
    public function it_will_send_before_start_notification_with_zero_events()
    {
        $this->performFullAndShortTaskZeroEvents('formatBeforeStart');

        $task = new BeforeStartTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_daily_full_notification()
    {
        $this->performFullAndShortTask('formatDailyFull');

        $task = new DailyFullTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_daily_full_notification_with_date()
    {
        $date = Carbon::now()->sub('10d');
        $this->performFullAndShortTask('formatDailyFull', $date);

        $task = new DailyFullTask();
        $task($date);
    }

    /**
     * @test
     */
    public function it_will_send_daily_full_notification_with_zero_events()
    {
        $this->performFullAndShortTaskZeroEvents('formatDailyFull');

        $task = new DailyFullTask();
        $task();
    }

    /**
     * @test
     */
    public function it_will_send_daily_short_notification()
    {
        $this->performFullAndShortTask('formatDailyShort');

        $task = new DailyShortTask();
        $task();
    }


    /**
     * @test
     */
    public function it_will_send_daily_short_notification_with_date()
    {
        $date = Carbon::now()->sub('10d');
        $this->performFullAndShortTask('formatDailyShort', $date);

        $task = new DailyShortTask();
        $task($date);
    }

    /**
     * @test
     */
    public function it_will_not_send_daily_short_notification_with_zero_events()
    {
        $this->performFullAndShortTaskZeroEvents('formatDailyShort');

        $task = new DailyShortTask();
        $task();
    }

    /**
     * @param  Carbon $now
     */
    private function performBeforeStartTask($now=null)
    {
        $now = $now ?: Carbon::now();
        $numberEvents = 4;
        $minutesBeforeStart = 10;
        $minutesBeforeStartString = intval($minutesBeforeStart/2).'m';

        config(['foto-diretta.notification.beforeStart.minutesBeforeStart' => $minutesBeforeStart]);

        $this->eventFactory(['date' => $now->clone()->add($minutesBeforeStartString)], $numberEvents);
        $this->eventFactory(['date' => $now->clone()->add('1h')]);

        $mocked = $this->mock(DebugGateway::class, function ($mock) use ($numberEvents) {
            $mock->shouldReceive('formatBeforeStart')->times($numberEvents);
            $mock->shouldReceive('post')->times($numberEvents);
        });
        config(['foto-diretta.notification.gateway.debug.class' => $mocked]);
    }


    /**
     * @param  string $taskName
     * @param  Carbon $now
     */
    private function performFullAndShortTask($taskName, $now=null)
    {
        $now = $now ?: Carbon::now()->add('1h');
        $numberEvents = 4;
        $this->eventFactory(['date' => $now], $numberEvents);
        $this->eventFactory(['date' => $now->clone()->add('3d')]);

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
    private function performFullAndShortTaskZeroEvents($taskName)
    {
        $mocked = $this->mock(DebugGateway::class, function ($mock) use ($taskName) {
            $mock->shouldNotReceive($taskName);
            $mock->shouldNotReceive('post');
        });
        config(['foto-diretta.notification.gateway.debug.class' => $mocked]);
    }
}
