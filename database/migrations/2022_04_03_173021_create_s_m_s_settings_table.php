<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nexmo_key')->nullable();
            $table->text('nexmo_secret')->nullable();
            $table->text('nexmo_sender_name')->nullable();
            $table->text('twilio_sid')->nullable();
            $table->text('twilio_auth_token')->nullable();
            $table->text('twilio_number')->nullable();
            $table->integer('status')->default('1')->comment('1 Twilio, 2 Nexmo');
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
        Schema::dropIfExists('s_m_s_settings');
    }
}
