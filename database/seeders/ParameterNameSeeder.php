<?php

namespace Database\Seeders;

use App\Models\ParameterName;
use App\Models\ParameterUnit;
use Illuminate\Database\Seeder;

class ParameterNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meter = ParameterUnit::query()->firstWhere('name', 'Метр');

        $gram = ParameterUnit::query()->firstWhere('name', 'Грамм');

        $percent = ParameterUnit::query()->firstWhere('name', 'Процент');

        ParameterName::query()->firstOrCreate([
            'name' => 'Сезонность',
            'type' => 'string',
            'parameter_unit_id' => null,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Назначение',
            'type' => 'string',
            'parameter_unit_id' => null,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Способ вязания',
            'type' => 'string',
            'parameter_unit_id' => null,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Длина нити в мотке',
            'type' => 'numeric',
            'parameter_unit_id' => $meter->id,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Вес мотка',
            'type' => 'numeric',
            'parameter_unit_id' => $gram->id,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Состав',
            'type' => 'complex',
            'parameter_unit_id' => $percent->id,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Страна',
            'type' => 'string',
            'parameter_unit_id' => null,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Толщина нити от',
            'type' => 'numeric',
            'parameter_unit_id' =>$meter->id,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Толщина нити до',
            'type' => 'numeric',
            'parameter_unit_id' =>$meter->id,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Окрас',
            'type' => 'string',
            'parameter_unit_id' => null,
        ]);
        ParameterName::query()->firstOrCreate([
            'name' => 'Структура нити',
            'type' => 'string',
            'parameter_unit_id' => null,
        ]);
    }
}
