<?php

namespace ChrisReedIO\SecureMeilisearch\Filament\Commands;

use Illuminate\Console\Command;

class FilamentSecureMeilisearchCommand extends Command
{
    public $signature = 'filament-secure-meilisearch';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
