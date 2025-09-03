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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('concepto');
            $table->decimal('importe', 8,2);
            $table->string('empresa')->nullable();
            $table->enum('tipo_comprobante', ['ticket', 'factura', 'presupuesto', 'nota', 'firma', 'papel', 'otro']);
            $table->string('numero_comprobante')->nullable();
            $table->string('solicitante');
            $table->text('observaciones')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};
