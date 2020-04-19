<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SeedTopicData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $topics = [
            [
                'name'        => 'About Blog',
                'description' => 'Something about the blog',
            ],
            [
                'name'        => 'Laravel 源码分析',
                'description' => '',
            ],
            [
                'name'        => '测试专题1',
                'description' => '',
            ],
            [
                'name'        => '测试专题2',
                'description' => '',
            ],
        ];
        DB::table('topics')->insert($topics);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('topics')->truncate();
    }
}
