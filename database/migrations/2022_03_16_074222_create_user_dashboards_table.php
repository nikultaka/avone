<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDashboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_dashboards', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('user_id');
            $table->text('networkAssessmentFindings')->nullable();
            $table->string('severity')->nullable();
            $table->text('cve_cwe')->nullable();
            $table->string('cvss3')->nullable();
            $table->longText('description')->nullable();
            $table->longText('buisness_impact')->nullable();
            $table->string('published_exploit')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('monitor_your_threat ')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_dashboards');
    }
}
