<?php

namespace App\Console\Commands;

use App\Console\Notification\Tasks\BeforeStartTask;
use App\Console\Notification\Tasks\DailyFullTask;
use App\Console\Notification\Tasks\DailyShortTask;

use Illuminate\Console\Command;
use Carbon\Carbon;

class TestNotification extends Command
{
    /**
     * @var array
     */
    private $availableTask = [
            'beforeStart' => BeforeStartTask::class,
            'dailyFull' => DailyFullTask::class,
            'dailyShort' => DailyShortTask::class
        ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test {task : Task name (beforeStart|dailyFull|dailyShort)} {gateway} {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $task = $this->getTask();
            $gateway = $this->getGateway();
            $date = $this->getDate();

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }

        config(['foto-diretta.notification.'.$task.'.gateway' => [$gateway]]);
        $taskClass = $this->availableTask[$task];
        $taskInstance = new $taskClass;
        $taskInstance($date);
    }


    /**
     * @return string
     */
    private function getTask()
    {
        $task = $this->argument('task');
        if (!isset($this->availableTask[$task])) {
            $message = sprintf('Wrong task name "%s" use: %s.', $task, implode(',', array_keys($this->availableTask)));
            throw new \Exception($message);
        }

        return $task;
    }

    /**
     * @return string
     */
    private function getGateway()
    {
        $gateway = $this->argument('gateway');
        $gateways = array_keys(config('foto-diretta.notification.gateway'));
        if (!in_array($gateway, $gateways)) {
            $message = sprintf('Wrong gateway name "%s" use: %s.', $gateway, implode(',', $gateways));
            throw new \Exception($message);
        }

        return $gateway;
    }

    /**
     * @return Carbon
     */
    private function getDate()
    {
        try {
            return Carbon::createFromFormat('Y-m-d H:i', $this->argument('date'));
        } catch (\Exception $e) {
            $message = sprintf('Wrong date %s formatm use: Y-m-d H:i', $this->argument('date'));
            throw new \Exception($message);
        }
    }
}
