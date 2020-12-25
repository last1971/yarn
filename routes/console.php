<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test', function () {
    $categories = \App\Models\Category::whereRaw('_lft+1 = _rgt')->get();
    $producers = \App\Models\Producer::get();
    for ($i=0;$i < 100; $i++) {
        $category = rand(0, $categories->count() - 1);
        $producer = rand(0, $producers->count() - 1);
        \App\Models\Product::factory([
            'producer_id' => $producers->get($producer)->id,
            'category_id' => $categories->get($category)->id,
        ])->create();
    }
    //\App\Models\Category::factory()->count(30)->create();
    //\App\Models\Producer::factory()->count(20)->create();
})->purpose('Test');
