<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('teachers', function (Blueprint $table) {
    $table->id();
    $table->string('email')->unique();
    $table->string('national_id_image');
    $table->enum('education', ['SSC','HSC','Bachelors','Masters']);
    $table->string('last_qualification');
    $table->integer('age');
    $table->string('phone_number');
    $table->string('account_no', 5)->unique(); // 5 digit fixed
    
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
        Schema::dropIfExists('teachers');
    }
};
