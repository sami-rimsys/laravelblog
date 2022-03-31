<?php

namespace Database\Factories;

use App\Models\Standard;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\DataProviders\Techstreet;

class StandardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Standard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->words(4, true),
            'title' => $this->faker->sentences(2, true),
            'url' => $this->faker->url(),
            'provider' => $this->faker->randomElement(['techstreet']),
            'overview' => $this->faker->sentences(1, true),
            'status' => $this->faker->randomElement(['current', 'superseeded']),
            'cross_reference' => $this->faker->sentences(1, true),
            'publisher' => $this->faker->words(4, true),
            'pages' => $this->faker->randomNumber(5),
            'replaces' => $this->faker->boolean() ? $this->faker->words(4, true) : null,
            'replaced_by' => $this->faker->boolean() ? $this->faker->words(4, true) : null,
            'isbn' => $this->faker->isbn10(),
            'changed_at' => $this->faker->date(),
            'publication_date' => $this->faker->date(),
            'withdrawn_date' => null,
        ];
    }

    /**
     * Indicate that the standard is current.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function current()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Techstreet::CURRENT,
            ];
        });
    }

    /**
     * Indicate that the standard is withdrawn.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withdrawn()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Techstreet::WITHDRAWN,
            ];
        });
    }

    /**
     * Indicate that the standard is from techstreet.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function techstreet()
    {
        return $this->state(function (array $attributes) {
            return [
                'provider' => Techstreet::PROVIDER_ID,
            ];
        });
    }
}
