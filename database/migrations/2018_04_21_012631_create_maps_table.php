<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mark_type');                       //标记类型
            $table->string('title');                           //标记名称
            $table->text('body');                            //标记描述
            $table->unsignedInteger('user_id');                //创建作者
            $table->decimal('latitude',10,7);     //纬度
            $table->decimal('longitude',10,7);    //经度
            $table->integer('comments_count')->default(0);                 //评论数量
            $table->integer('followers_count')->default(0);                //关注数量
            $table->boolean('close_comment')->default(false);  //是否关闭评论
            $table->boolean('is_hidden')->default(false);      //是否公开
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps');
    }
}
