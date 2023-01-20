<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->name(),
            'image'     => 'files/7oDzQi5gOVKAQi1yCt1OWTj7I9fGFSQAqsEOje59.png',
            'status'    => 'تفعيل',
        ];
    }
}
