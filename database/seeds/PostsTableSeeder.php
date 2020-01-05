<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Tag;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $tagIds = Tag::all()->pluck('id')->toArray();

        $posts = factory(Post::class)->times(100)->make()->each(function ($post, $index) use($faker,$tagIds){
            $post->user_id = 1;
        });

        $postArray = $posts->toArray();

        Post::insert($postArray);

        // Add Tags to post
        Post::all()->each(function ($post, $index) use ($faker, $tagIds){
            $post->tags()->sync($faker->randomElements($tagIds));
        });
    }
}
