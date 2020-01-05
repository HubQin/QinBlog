<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                'name'        => '博客相关',
                'description' => 'Something about the blog',
            ],
            [
                'name'        => 'Laravel 源码分析',
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
