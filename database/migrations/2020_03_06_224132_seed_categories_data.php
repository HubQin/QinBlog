<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => 'About Blog',
                'icon'        => 'iconblog',
                'description' => '',
            ],
            [
                'name'        => 'PHP',
                'icon'        => 'iconphpx',
                'description' => '',
            ],
            [
                'name'        => 'Laravel',
                'icon'        => 'iconlaravel',
                'description' => '',
            ],
            [
                'name'        => 'MySQL',
                'icon'        => 'iconshujukuleixingtubiao-kuozhan-',
                'description' => '',
            ],
            [
                'name'        => 'Vue',
                'icon'        => 'iconVue',
                'description' => '',
            ],
            [
                'name'        => 'Docker',
                'icon'        => 'icondocker',
                'description' => '',
            ],
            [
                'name'        => 'Python',
                'icon'        => 'iconpython',
                'description' => '',
            ],
            [
                'name'        => 'JavaScript',
                'icon'        => 'iconphpx',
                'description' => '',
            ],
            [
                'name'        => 'Life',
                'icon'        => 'iconlife',
                'description' => '',
            ],
            [
                'name'        => 'Other',
                'icon'        => 'iconother',
                'description' => '',
            ],
        ];
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
