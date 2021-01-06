<?php

namespace Database\Seeders;

use App\Models\ParameterUnit;
use Illuminate\Database\Seeder;

class ParameterUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Length
        $meter = ParameterUnit::query()->firstOrCreate([
            'name' => 'Метр',
            'abbreviation' => 'м',
            'coefficient' => 1,
            'multiply' => true,
            'parameter_unit_id' => null,
        ]);
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Километр',
            'abbreviation' => 'км',
            'coefficient' => 1000,
            'multiply' => true,
            'parameter_unit_id' => $meter->id,
        ]);
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Дециметр',
            'abbreviation' => 'дм',
            'coefficient' => 10,
            'multiply' => false,
            'parameter_unit_id' => $meter->id,
        ]);
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Сантиметр',
            'abbreviation' => 'см',
            'coefficient' => 100,
            'multiply' => false,
            'parameter_unit_id' => $meter->id,
        ]);
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Миллиметр',
            'abbreviation' => 'мм',
            'coefficient' => 1000,
            'multiply' => false,
            'parameter_unit_id' => $meter->id,
        ]);

        // Percent
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Процент',
            'abbreviation' => '%',
            'coefficient' => 1,
            'multiply' => true,
            'parameter_unit_id' => null,
        ]);

        // Weight
        $gram = ParameterUnit::query()->firstOrCreate([
            'name' => 'Грамм',
            'abbreviation' => 'г',
            'coefficient' => 1,
            'multiply' => true,
            'parameter_unit_id' => null,
        ]);
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Килограмм',
            'abbreviation' => 'кг',
            'coefficient' => 1000,
            'multiply' => true,
            'parameter_unit_id' => $gram->id,
        ]);
        ParameterUnit::query()->firstOrCreate([
            'name' => 'Миллиграмм',
            'abbreviation' => 'мг',
            'coefficient' => 1000,
            'multiply' => false,
            'parameter_unit_id' => $gram->id,
        ]);
    }
}
