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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('sector_id')->constrained('sectors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama', 100);
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('no_hp', 13);
            $table->text('alamat');
            $table->enum('status_keluarga', ['Ayah', 'Ibu', 'Anak']);
            $table->enum('status_anak', ['Anak Kandung', 'Anak Angkat'])->nullable();
            $table->enum('pendidikan', ['Belum Sekolah', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3']);
            $table->enum('status', ['Hidup', 'Almarhum'])->nullable();
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
        Schema::dropIfExists('family_members');
    }
};
