<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kiosk_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        // Заполняем начальными данными
        DB::table('kiosk_settings')->insert([
            [
                'key'   => 'Заголовок',
                'value' => 'Информация для посетителей',
            ],
            [
                'key'   => 'Футер',
                'value' => '© Организация',
            ],
            [
                'key'   => 'Отправлять Email на адрес',
                'value' => 'admin@admin.com',
            ],
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Важно: при откате удаляем данные и таблицу
        DB::table('kiosk_settings')->truncate();
        Schema::dropIfExists('kiosk_settings');
    }
};
