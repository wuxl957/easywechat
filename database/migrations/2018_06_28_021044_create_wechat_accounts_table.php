<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id')->index()->comment('开发者ID');
            $table->string('name')->index()->comment('公号名称');
            $table->string('secret')->comment('AppSecret(应用密钥)');
            $table->string('token')->comment('WeChat Token');
            $table->string('aes_key')->nullable()->comment('消息加解密密钥');
            $table->tinyInteger('default_reply_type')->default(1)->comment('1text,2voice,3image,4news(byID),5latestNews(byAccount),6kf_session');
            $table->string('default_reply')->nullable()->comment('default_reply');
            $table->boolean('certified')->default(false)->comment('微信认证与否');
            $table->json('menu')->nullable()->comment('json_menu');
            $table->json('resources')->nullable()->comment('开启的资源');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_accounts');
    }
}
