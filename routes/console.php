<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about-project', function (): void {
    $this->info('Delivery Service');
});
