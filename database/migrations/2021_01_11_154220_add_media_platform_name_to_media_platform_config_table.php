<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediaPlatformNameToMediaPlatformConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_platform_config', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->string('media_platform_code', 100)->default('')->comment('微信公众号代号')->after('id');
            $table->string('media_platform_name', 100)->default('')->comment('微信公众号名称')->after('media_platform_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_platform_config', function (Blueprint $table) {
            $table->dropColumn('media_platform_name');
        });
    }
}
