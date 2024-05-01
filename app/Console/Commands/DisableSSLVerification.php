<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DisableSSLVerification extends Command
{
    protected $signature = 'ssl:disable';

    protected $description = 'Disable SSL verification for testing purposes';

    public function handle()
    {
        // Disable SSL verification for the specific route
        Http::withoutVerifying();

        $this->info('SSL verification disabled for testing.');
    }
}
