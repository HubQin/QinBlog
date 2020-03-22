<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class PostRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => ['required', 'string', 'min:2'],
            'body'        => ['required', 'string', 'min:3'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ];
    }

    public function attributes()
    {
        return [
            'title' => '标题',
            'body' => '文章内容',
            'category_id' => '分类',
        ];
    }

    public function messages()
    {
        return [
            'title.min' => '标题必须至少两个字符',
            'body.min' => '文章内容必须至少三个字符',
        ];
    }
}
