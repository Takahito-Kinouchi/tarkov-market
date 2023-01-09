<?php

namespace App\Console\Commands;

use App\Scrape\Scraper;
use Illuminate\Console\Command;

class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:tarkov-market';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes item information from tarkov-market';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $scraper = new Scraper();
        $data = $scraper->itemList();
        dump($data);
        return Command::SUCCESS;
    }
}
