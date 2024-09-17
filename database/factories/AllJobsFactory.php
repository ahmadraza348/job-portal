<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AllJobs>
 */
class AllJobsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=> fake()->name,
            'user_id'=> 4,
            'job_type_id'=> round(1,5),
            'category_id'=> round(1,5),
            'vacancy'=> round(1,5),
            'location'=> fake()->city,
            'description'=> fake()->text,
            'experience'=>round(1,10),
            'company_name'=>fake()->name,
        ];
    }
}
