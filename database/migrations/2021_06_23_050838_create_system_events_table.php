<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->foreignId('public_sector_id');
            $table->ipAddress('host_ip');
            $table->text('message');
            $table->dateTime('device_time');
            $table->string('user')->nullable();
            $table->string('sys_log_tag')->nullable();
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
        Schema::dropIfExists('system_events');
    }
}
