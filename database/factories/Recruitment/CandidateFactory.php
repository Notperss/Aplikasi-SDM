<?php

namespace Database\Factories\Recruitment;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recruitment\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'ktp_address' => $this->faker->address(),
            'current_address' => $this->faker->address(),
            'npwp_number' => $this->faker->numberBetween(1000000000000000, 9999999999999999),
            'ktp_number' => $this->faker->numberBetween(1000000000000000, 9999999999999999),
            'kk_number' => $this->faker->numberBetween(1000000000000000, 9999999999999999),
            'religion' => $this->faker->randomElement(['Islam', 'Christian', 'Hindu', 'Buddha', 'Others']),
            'nationality' => 'Indonesian',
            'height' => $this->faker->numberBetween(150, 200),
            'weight' => $this->faker->numberBetween(50, 100),
            'pob' => $this->faker->city(),
            'dob' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['PRIA', 'WANITA']),
            'date_applied' => $this->faker->date(),
        ];
    }
}
