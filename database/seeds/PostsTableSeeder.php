<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Tag;
use App\Category;

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

        $categories = Category::all()->pluck('id');

        $posts = factory(Post::class)->times(100)->make()->each(function ($post, $index) use($faker, $categories){
            $post->user_id = 1;
            $post->category_id = $faker->randomElement($categories);
        });

        $postArray = $posts->toArray();

        // 使用DB避免触发模型事件
        \DB::table('posts')->insert($postArray);

        // 给文章随机打标签
        $posts = Post::all();
        $tags = Tag::all()->pluck('id');

        foreach ($posts as $post) {
            $postTags = $faker->randomElements($tags, $faker->numberBetween(1, 3));
            $post->tags()->attach($postTags);
        }
    }
}
