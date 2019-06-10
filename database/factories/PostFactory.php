<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
   	$title = $faker->sentence(6);
    //fecha random
    $published_at = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1 year', 'now')->getTimestamp());

    return [
    	'user_id' => rand(1,2),
    	'category_id' => rand(1,3),
       	'title' => $title,
       	'url' => str_slug($title),
       	'excerpt' => $faker->text(200),
       	'body' => $faker->text(1000),
       	/*'file' => $faker->imageUrl($width = 586, $height = 490),*/
       	'published_at' => $published_at,
        'municipality_id' => $faker-> randomElement([588, 553, 587, 599, 625, 614, 576, 648, 644, 582, 550, 581, 559, 632, 613 ])
    ];

});
