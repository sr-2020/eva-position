<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class HotCache extends Command
{
    protected $period = 1;
    protected $timeout = 5;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hotcache:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Cache /api/v1/users route
     */
    protected function cache()
    {
        $key = 'page:/api/v1/users';
        $list = User::with('location')
            ->get()
            ->makeVisible(['location']);

        app('redis')->set($key, $list->toJson());
        app('redis')->expire($key, $this->timeout);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dt = Carbon::now();
        $iteration = 60 / $this->period;

        do {
            try {
                $this->cache();
                time_sleep_until($dt->addSeconds($this->period)->timestamp);
            } catch (\Exception $e) {
                time_sleep_until($dt->addSeconds($this->timeout)->timestamp);
            }
        } while($iteration-- > 0);
    }
}
