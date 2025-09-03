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
        Schema::table('egresos', function (Blueprint $table) {
            // Agregar la columna categoria_id
            $table->unsignedBigInteger('categoria_id')->nullable()->after('hora');
            
            // Crear la foreign key
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            
            // Opcional: Remover la columna categoria antigua (string)
            $table->dropColumn('categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            // Remover foreign key y columna
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
            
            // Restaurar columna categoria original
            $table->string('categoria')->after('hora');
        });
    }
};