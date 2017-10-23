<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Properties;
use App\PropertyDetail;
use App\Http\Controllers\PropertiesController;


class GetProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:properties';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       \Log::info("ok");
        $output = (new PropertiesController)->index();
    }
}
