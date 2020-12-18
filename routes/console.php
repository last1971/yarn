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
    $models = [ 'category' => \App\Models\Category::class];
    $model = new $models['category'];
    dd($model->find('49556882-feb9-4404-ba4b-babb0de83b06'));
/*
    $a1 = \App\Models\Category::query()->create(['name' => \Illuminate\Support\Str::random()]);
    $a1->children()->create(['name' => \Illuminate\Support\Str::random()]);
    $b2 = $a1->children()->create(['name' => \Illuminate\Support\Str::random()]);
    $b2->children()->create(['name' => \Illuminate\Support\Str::random()]);
*/
})->purpose('Test');
