<?php

namespace App\Services;

use App\Post;
use App\Tag;
use App\Topic;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;

class PostService
{
    /**
     * @param PostRequest $request
     * @param Post $post
     * @return Post|\Exception|mixed|\Throwable
     */
    public function store(PostRequest $request, Post $post)
    {
        try {
            $post = \DB::transaction(function () use ($request, $post) {

                // 处理标签
                $tagIds = $this->handleTag($request);

                // 处理专题
                $this->handleTopic($request, $post);

                // 处理slug TODO

                // 保存文章
                $post->save();
                // 同步文章标签
                $tagIds && $post->tags()->attach($tagIds);

                return $post;
            });
        } catch (\Throwable $e) {
            return $e;
        }
        return $post;
    }

    public function update(PostRequest $request, Post $post)
    {
        try {
            $post = \DB::transaction(function () use ($request, $post) {

                // 处理标签
                $tagIds = $this->handleTag($request);

                // 处理专题
                $this->handleTopic($request, $post);

                // 保存文章
                $post->save();
                // 同步文章标签
                $tagIds && $post->tags()->sync($tagIds);

                return $post;
            });
        } catch (\Throwable $e) {
            return $e;
        }
        return $post;
    }

    public function handleTopic($request, &$post)
    {
        if ($topicId = $request->topic_id) {
            if (Str::contains($topicId, '~')) {
                $newlyTopicData = [
                    'name' => explode('~', $topicId)[0]
                ];
                $newTopic = Topic::create($newlyTopicData);
                $post->topic_id = $newTopic->id;
            } else {
                $post->topic_id = $topicId;
            }
            $post->sort = $request->sort ?? 1;
        }
    }

    public function handleTag($request)
    {
        if ($tagIds = json_decode($request->tag_ids)) {
            $newlyTagIds = [];
            foreach ($tagIds as $k => $tagId) {
                if (!is_numeric($tagId)) {
                    $newlyTagData = [
                        'name'       => explode('~', $tagId)[0],
                        'post_count' => 1
                    ];
                    $newTag = Tag::create($newlyTagData);
                    $newlyTagIds[] = $newTag->id;
                    unset($tagIds[$k]);
                }
            }
            return array_merge($tagIds, $newlyTagIds);
        } else {
            return false;
        }
    }

    /**
     * 创建唯一不重复的Slug
     * @param Post $post
     * @param $slug
     */
    public function creatUniqueSlug(Post &$post, $text)
    {
        $slug = Str::slug($text);
        $id = $post->id ?? 0;

        $count = Post::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '<>', $id)->count();

        $post->slug = $count ? "{$slug}-{$count}" : $slug;
    }
}
