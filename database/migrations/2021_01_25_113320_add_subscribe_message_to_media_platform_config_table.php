<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscribeMessageToMediaPlatformConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_platform_config', function (Blueprint $table) {
            $table->text('subscribe_message')->nullable($value = true)->comment('公众号订阅消息')->after('account_aes_key');
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
            $table->dropColumn('subscribe_message');
        });
    }
}
