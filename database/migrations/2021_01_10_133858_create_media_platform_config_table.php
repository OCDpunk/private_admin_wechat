<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaPlatformConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_platform_config', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->id();
            $table->string('code', 50)->default('')->comment('代号');
            $table->string('account_appid',255)->default('')->comment('微信公众号appid');
            $table->string('account_secret', 255)->default('')->comment('微信公众号秘钥');
            $table->string('account_token',255)->default('')->comment('微信公众号令牌');
            $table->string('account_aes_key', 255)->default('')->comment('微信公众号消息加解密密钥');
            $table->text('more')->nullable($value = true)->comment('拓展字段');
            $table->text('remark')->nullable($value = true)->comment('备注');

            $table->timestamps();

            $table->index('code');
            $table->index('account_appid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_platform_config');
    }
}
