<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ways', function (Blueprint $table) {
            $table->bigInteger("id", false, true)->primary();
            $table->boolean("visible");
            $table->timestamp("timestamp");
            $table->bigInteger("version", false, true);
        });

        Schema::create('way_tags', function (Blueprint $table) {
            $table->bigInteger("way_id", false, true)->primary()->nullable(false);
            $table->bigInteger("version", false, true);
            $table->string("k", 255);
            $table->string("v", 255);

            $table->foreign('way_id')->references('id')->on('ways');
        });


        Schema::create('way_nodes', function (Blueprint $table) {
            $table->bigInteger("way_id", false, true);
            $table->bigInteger("node_id", false, true);
            $table->bigInteger("version", false, true);
            $table->bigInteger("sequence");

            $table->foreign('way_id')->references('id')->on('ways');
            $table->foreign('node_id')->references('id')->on('nodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('way_nodes', function (Blueprint $table) {
            $table->dropForeign(['way_id']);
            $table->dropForeign(['node_id']);
        });
        Schema::dropIfExists('way_nodes');
        Schema::table('way_tags', function (Blueprint $table) {
            $table->dropForeign(['way_id']);
        });
        Schema::dropIfExists('way_tags');
        Schema::dropIfExists('ways');
    }
}