<?php

use Illuminate\Database\Seeder;

use App\Post;
use App\Photo;
use App\Category;
use App\Tag;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Category::truncate();
    	tag::truncate();

    	$category = new Category;
        $category->name = "Categoria 1";
        $category->color = "#984563";
        $category->save();

        $category2 = new Category;
        $category2->name = "Categoria 2";
        $category2->color = "#984563";
        $category2->save();

        $category3 = new Category;
        $category3->name = "Categoria 3";
        $category3->color = "#984563";
        $category3->save();

        $tag = new Tag;
        $tag->name = "Tag 1";
        $tag->save();

        $tag2 = new Tag;
        $tag2->name = "Tag 2";
        $tag2->save();

        $tag3 = new Tag;
        $tag3->name = "Tag 3";
        $tag3->save();

        Factory(Post::class, 100)->create();
    }
}
