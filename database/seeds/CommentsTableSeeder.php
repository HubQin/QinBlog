<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use App\Comment;

class CommentsTableSeeder extends Seeder
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

        $comments = factory(Comment::class)->times(1000)->make()->each(function ($comment, $index) use($faker, $userIds, $postIds){
            $comment->user_id = $faker->randomElement($userIds);
            $comment->commentable_id = $faker->randomElement($postIds);
            $comment->commentable_type = Post::class;
            $comment->approved = 1;
        });

        \DB::table('comments')->insert($comments->toArray());

        $posts = Post::all();

        // 更新文章回复数
        foreach ($posts as $post) {
            $post->comment_count = $post->comments()->count();
            \DB::table('posts')->where('id', $post->id)->update(['comment_count' => $post->comment_count]);
        }
    }
}
