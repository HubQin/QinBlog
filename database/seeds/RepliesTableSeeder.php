<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use App\Reply;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::all()->pluck('id')->toArray();
        $postIds = Post::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $replies = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use($faker, $userIds, $postIds){
            $reply->user_id = $faker->randomElement($userIds);
            $reply->post_id = $faker->randomElement($postIds);
            $reply->status = 1;
        });

        \DB::table('replies')->insert($replies->toArray());

        $posts = Post::all();

        // 更新文章回复数
        foreach ($posts as $post) {
            $post->view_count = $post->replies()->count();
            \DB::table('posts')->where('id', $post->id)->update(['view_count' => $post->view_count]);
        }
    }
}
