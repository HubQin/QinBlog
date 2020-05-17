<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Post;
use App\Services\PostService;
use DB;

class PostObserver
{
    public function saving(Post $post)
    {
        $post->body = clean($post->body, 'post_body');
        $post->excerpt = make_excerpt($post->body);
    }

    public function saved(Post $post)
    {
        // 如果没有slug，使用文章标题翻译并转化成slug
        if (empty($post->slug)) {
            dispatch(new TranslateSlug($post));
        }

        // 更新分类文章数量
        $this->updateCategoryPostCount($post);

        $this->forgetPostRelatedCache();
    }

    public function deleting(Post $post)
    {
        // 在删除前更新标签 因为删除后拿不到$post->tags_id属性
        app(PostService::class)->updateTagsPostCount($post->tag_ids->toArray());
    }

    public function deleted(Post $post)
    {
        $this->updateCategoryPostCount($post);
        $this->forgetPostRelatedCache();
    }

    private function forgetPostRelatedCache()
    {
        cache()->forget('categories');
        cache()->forget('tags');
        cache()->forget('archives');
    }

    private function updateCategoryPostCount(Post $post)
    {
        if ($post->category_id) {
            $this->dbUpdatePostCount($post->category_id);
        }

        if ($oldCategoryId = $post->getOriginal('category_id')) {
            $this->dbUpdatePostCount($oldCategoryId);
        }
    }

    private function dbUpdatePostCount($categoryId)
    {
        DB::table('categories')
            ->where('id', $categoryId)
            ->update([
                'post_count' => DB::table('posts')
                    ->where('category_id', $categoryId)
                    ->where('is_show', 1)
                    ->count()
            ]);
    }
}
