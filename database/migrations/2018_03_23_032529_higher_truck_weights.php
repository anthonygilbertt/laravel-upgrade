<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HigherTruckWeights extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('trucks', function ($table) {
      //$table->decimal('weight_capacity', 20, 16)->change();
      $table->float('weight_capacity', 20, 16)->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('trucks', function ($table) {
      $table->float('weight_capacity', 8, 2)->change();
    });
  }
}
