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
        Schema::create('sidis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('family_member_id')->constrained('family_members')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('sidi');
            $table->date('tanggal');
            $table->string('gereja', 50);
            $table->text('keterangan');
            $table->string('tahun', 5);
            $table->softDeletes();
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
        Schema::dropIfExists('sidis');
    }
};
