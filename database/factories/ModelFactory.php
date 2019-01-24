<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

/**
 * Factory definition for model App\Customer.
 */
$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'cnp' => rand(100,100000),
    ];
});

/**
 * Factory definition for model App\Transaction.
 */
$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    $customers = App\Customer::pluck('id')->toArray();

    return [
        'amount' => $faker->randomFloat(2),
        'date'    => $faker ->date("Y-m-d"),
        'customer_id' => $faker->randomElement($customers)
    ];
});


/**
 * Factory for users
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'email'    => $faker->unique()->email,
        'password' => bcrypt('password'),
    ];
});