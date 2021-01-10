<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaPlatformMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_platform_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->id();
            $table->string('media_platform_code', 100)->default('')->comment('微信公众号代号');
            $table->string('to_user_name', 100)->default('')->comment('接收方微信号');
            $table->string('from_user_name', 100)->default('')->comment('发送方微信号，若为普通用户，则是一个OpenID');
            $table->unsignedInteger('create_time')->default(0)->comment('消息创建时间');
            $table->string('msg_type',50)->default('')->comment('消息类型，link:链接,location:地理位置,text:文本,image:图片,voice:语音,video:视频,shortvideo:小视频,file:文件,event:事件');
            $table->unsignedBigInteger('msg_id')->default(0)->comment('消息id，64位整型');
            //文字
            $table->text('content')->nullable($value = true)->comment('文本消息内容');
            //多媒体（通用）
            $table->string('media_id', 255)->default('')->comment('图片消息媒体id，可以调用获取临时素材接口拉取数据');
            //图片
            $table->string('pic_url', 255)->default('')->comment('图片链接（由系统生成）');
            //语音
            $table->string('format',50)->default('')->comment('语音格式，如amr，speex等');
            $table->string('recognition',255)->default('')->comment('语音识别结果，UTF8编码');
            //视频&&小视频
            $table->string('thumb_media_id',255)->default('')->comment('视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。');
            //地理位置
            $table->string('location_x',20)->default('')->comment('地理位置纬度');
            $table->string('location_y',20)->default('')->comment('地理位置经度');
            $table->string('scale',20)->default('')->comment('地图缩放大小');
            $table->string('label',100)->default('')->comment('地理位置信息');
            //链接
            $table->string('title',50)->default('')->comment('消息标题');
            $table->string('description',150)->default('')->comment('消息描述');
            $table->text('url')->nullable($value = true)->comment('消息链接');

            $table->text('original_data')->nullable($value = true)->comment('接收方微信号');
            $table->timestamps();

            $table->index('from_user_name');
            $table->index('msg_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_platform_messages');
    }
}
