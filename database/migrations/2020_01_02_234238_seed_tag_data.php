<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedTagData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tags = [
            [
                'name'        => 'PHP',
                'description' => 'PHP 是世界上最好的语言，没有之一',
                'icon'        => 'iconphpx'
            ],
            [
                'name'        => 'Laravel',
                'description' => '开发流畅优雅的PHP框架',
                'icon'        => 'iconlaravel'
            ],
            [
                'name'        => 'Python',
                'description' => '人生苦短，我用 Python',
                'icon'        => 'iconpython'
            ],
            [
                'name'        => 'Linux',
                'description' => '最适合程序员的操作系统',
                'icon'        => 'iconlinux-'
            ],
        ];
        DB::table('tags')->insert($tags);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tags')->truncate();
    }
}
