<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeploymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deployment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deploymentID')->nullable();
            $table->string('deploymentName')->nullable();
            $table->string('sizePerZoneElastic')->nullable();
            $table->string('availabilityZonesElastic')->nullable();
            $table->string('sizePerZoneKibana')->nullable();
            $table->string('availabilityZonesKibana')->nullable();
            $table->string('sizePerZoneApm')->nullable();
            $table->string('availabilityZonesApm')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deployment');
    }
}
