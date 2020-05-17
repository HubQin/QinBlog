<?php

namespace App\Services;

use App\Post;
use App\Tag;
use App\Topic;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;
use DB;

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

                // 保存文章
                $post->save();
                // 同步文章标签
                $tagIds && $post->tags()->attach($tagIds);
                // 更新标签文章数量
                $this->updateTagsPostCount($tagIds);

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
                $oldTagIds = $post->tag_ids->toArray();

                // 处理标签
                $tagIds = $this->handleTag($request);

                // 处理专题
                $this->handleTopic($request, $post);

                // 保存文章
                $post->save();

                // 同步文章标签
                if ($tagIds) {
                    $post->tags()->sync($tagIds);
                } else {
                    $oldTagIds && $post->tags()->detach($oldTagIds);
                }

                // 更新标签文章数
                $this->updateTagsPostCount(array_merge($tagIds, $oldTagIds));

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
            return [];
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

    /**
     * 更新文章标签数量
     * @param $tagIds
     */
    public function updateTagsPostCount($tagIds)
    {
        if ($tagIds) {
            // 用于保存存在文章的标签
            $tagIdsHasPost = [];

            // 统计各标签文章数量
            DB::table('post_tag')
                ->select(DB::raw('tag_id,count(tag_id) as post_count'))
                ->whereIn('tag_id', $tagIds)
                ->groupBy('tag_id')
                ->get()
                ->each(function ($item) use(&$tagIdsHasPost){
                    $tagIdsHasPost[] = $item->tag_id;
                    DB::table('tags')->where('id', $item->tag_id)->update(['post_count' => $item->post_count]);
                });

            // 已经没有文章的标签，删除之
            if ($tagIdsWithoutPost = array_diff($tagIds, $tagIdsHasPost)) {
                DB::table('tags')->whereIn('id', $tagIdsWithoutPost)->delete();
            }
        }
    }
}
