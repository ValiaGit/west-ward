<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateNewGameVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integrate:vendor {name} {provider_guid?} {provider_secret?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create appropriate files for new GameVendor Integration';

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
        if(!$this->argument('name')) {
            return $this->info("Please provider {name} ar argument");
        }

        //
        $VendorName = $this->info( $this->argument('name'));


        //Check If Vendor Already Exists


        //Create Database Record for new Vendor


        //Create Folder Structure For New Vendor


        //Create Handler Classes Fro Vendor


    }
}
