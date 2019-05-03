<?php

use Faker\Generator as Faker;

$category = ["milk","bread","laptop","mobile"];
$factory->define(\App\Product::class, function (Faker $faker) use ($category) {
    return [
        'name' => $faker->name,
        'category' => $category[rand(0,3)] ,
        'price' => $faker->numberBetween(20000,10000000),
        'description' => $faker->paragraph(),
        'count' => $faker->numberBetween(0,1000),
        'image_url' => 'https://www.google.com/search?q=google&source=lnms&tbm=isch&sa=X&ved=0ahUKEwjO9OT0vfjhAhUSyqQKHQbTDQkQ_AUIDigB&biw=1517&bih=310#',
    ];
});
