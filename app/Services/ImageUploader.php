<?php
/**
 * 图片上传
 */

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ImageUploader
{
    // 只允许以下后缀名的图片文件上传
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    public function save($file, $folder, $max_width = false)
    {
        // 路径
        $folder_name = "images/$folder/" . date("Ym", time());
        $upload_path = storage_path('app/public/'.$folder_name) ;
        // 扩展名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        // 文件名
        $filename = time() . '_' . Str::random(10) . '.' . $extension;

        if (! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }
        // 返回文件路径
        return [
            'path' => Storage::url("$folder_name/$filename")
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
