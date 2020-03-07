<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedColumnsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $columns = [
            [
                'name'        => '文章',
                'link'        => '/articles',
                'description' => '',
            ],
            [
                'name'        => '专题',
                'link'        => '/topics',
                'description' => '',
            ],
            [
                'name'        => '关于',
                'link'        => '/about',
                'description' => '',
            ],
        ];
        DB::table('columns')->insert($columns);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('columns')->truncate();
    }
}
