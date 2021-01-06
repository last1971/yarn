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
    $products = \App\Models\Product::select('products.id')
        ->join('parameter_values', 'parameter_values.product_id', '=', 'products.id')
        ->where('producer_id', '01063897-6076-46a9-85ab-429a5e059e60')
        ->where('string_value', 'Россия');
    $parameters = \App\Models\ParameterValue::whereIn('product_id', $products);
    dd($parameters->groupBy(['parameter_name_id', 'string_value', 'numeric_value'])->get(['parameter_name_id', 'string_value', 'numeric_value']));
    \App\Models\ParameterName::with('parameterUnit.parameterUnits')->get();
    /*
    $categories = \App\Models\Category::whereRaw('_lft+1 = _rgt')->get();
    $producers = \App\Models\Producer::get();
    for ($i=0;$i < 200; $i++) {
        $category = rand(0, $categories->count() - 1);
        $producer = rand(0, $producers->count() - 1);
        \App\Models\Product::factory([
            'producer_id' => $producers->get($producer)->id,
            'category_id' => $categories->get($category)->id,
        ])->create();
    }*/
    //\App\Models\Category::factory()->count(30)->create();
    //\App\Models\Producer::factory()->count(20)->create();
})->purpose('Test');

Artisan::command('test:parameters', function () {
    $products = \App\Models\Product::get();
    foreach ($products as $product) {
        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Назначение');
        $v = [
            'Специально для деток',
            'Для шарфиков',
            'Для декорирования',
            'Для пледов',
            'Для любой одежды',
            'Для носков',
            'Для плетения',
        ];
        $i = rand(0, 6);
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'string_value' => $v[$i],
        ]);

        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Способ вязания');
        $v = [
            'Спицами и крючком',
            'Машинная',
            'Ручная и машинная',
        ];
        $i = rand(0, 2);
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'string_value' => $v[$i],
        ]);

        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Страна');
        $v = [
            'Китай',
            'Россия',
            'Германия',
        ];
        $i = rand(0, 2);
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'string_value' => $v[$i],
        ]);

        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Сезонность');
        $v = [
            'Зимняя пряжа',
            'Летняя пряжа',
            'Демисезон',
            'Весна-лето',
        ];
        $i = rand(0, 3);
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'string_value' => $v[$i],
        ]);

        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Структура нити');
        $v = [
            'Простая',
            'Буклированная',
            'С понпонами',
            'Разная по толщине',
            'Травка',
            'С люрексом',
            'Трубчатая',
            'Ленточная',
            'С пайетками',
            'Фантазийная',
            'Плетенная',
            'Плюшевая',
        ];
        $i = rand(0, 11);
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'string_value' => $v[$i],
        ]);

        $p = \App\Models\ParameterName::with('parameterUnit')
            ->firstWhere('name', 'Толщина нити от');
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'numeric_value' => rand(100, 500),
            'fraction' => 0,
            'parameter_unit_id' => $p->parameterUnit->id,
        ]);

        $p = \App\Models\ParameterName::with('parameterUnit')
            ->firstWhere('name', 'Толщина нити до');
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'numeric_value' => rand(500, 900),
            'fraction' => 0,
            'parameter_unit_id' => $p->parameterUnit->id,
        ]);

        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Состав');
        $v = [
            'Акрил',
            'Шерсть',
            'Хлопок',
            'Вискоза',
            'Полипропилен',
            'Полиамид',
            'Полушерсть',
            'Мохер',
            'Ангора',
            'Меринос',
            'Лён',
            'Крапива',
            'Козий пух',
            'Шерсть норки',
            'Полиэстер',
            'Микрофибра',
            'Микрополиэстер',
            'Хлопок велюровый',
            'Вискозный велюр',
            'Шёлк',
            'Бамбук',
            'Альпака',
            'Шерсть яка',
            'Стрейч',
            'Верблюжья шерсть',
            'Кашемир',
        ];
        $i = rand(0, 25);
        $j = 100;
        $k = rand(0, 2);
        while ($k != 0 && $j > 0) {
            $l = rand(1, $j);
            \App\Models\ParameterValue::query()->create([
                'product_id' => $product->id,
                'parameter_name_id' => $p->id,
                'string_value' => $v[$i],
                'numeric_value' => $l,
                'fraction' => 0,
                'parameter_unit_id' => $p->parameterUnit->id,
            ]);
            $i = rand(0, 25);
            $j = $j - $l;
            $i = rand(0, 25);
            $k = $k - 1;
        }
        if ($j > 0) {
            \App\Models\ParameterValue::query()->create([
                'product_id' => $product->id,
                'parameter_name_id' => $p->id,
                'string_value' => $v[$i],
                'numeric_value' => $j,
                'fraction' => 0,
                'parameter_unit_id' => $p->parameterUnit->id,
            ]);
        }

        $p = \App\Models\ParameterName::query()->firstWhere('name', 'Окрас');
        $v = [
            'Однотонная пряжа',
            'Меланжевая пряжа',
        ];
        $i = rand(0, 1);
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'string_value' => $v[$i],
        ]);

        $p = \App\Models\ParameterName::with('parameterUnit')
            ->firstWhere('name', 'Длина нити в мотке');
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'numeric_value' => rand(300, 800),
            'fraction' => 0,
            'parameter_unit_id' => $p->parameterUnit->id,
        ]);

        $p = \App\Models\ParameterName::with('parameterUnit')
            ->firstWhere('name', 'Вес мотка');
        \App\Models\ParameterValue::query()->create([
            'product_id' => $product->id,
            'parameter_name_id' => $p->id,
            'numeric_value' => rand(25, 600),
            'fraction' => 0,
            'parameter_unit_id' => $p->parameterUnit->id,
        ]);
    }
})->purpose('Test parameters');
