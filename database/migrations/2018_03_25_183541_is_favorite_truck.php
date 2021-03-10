<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IsFavoriteTruck extends Migration
{
    /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('trucks', function($table) {
      $table->boolean('favorite')->nullable();
    });
  }
  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('trucks', function($table) {
      $table->dropColumn('favorite');
    });
  }
}
