<?php

namespace App\Console\Commands\Test;

use App\Services\GibberishDetectionService;
use Illuminate\Console\Command;

class NosayTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nosay:test';

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



    public function handle(GibberishDetectionService $gibberishDetectionService)
    {
        $content = 'LPyRnuOjR';
        $score = $gibberishDetectionService->calculateGibberishScore($content);
        dd($score);
    }
}
