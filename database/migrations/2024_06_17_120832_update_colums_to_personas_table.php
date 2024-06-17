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
        //eliminar llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['documento_id']);
            $table->dropColumn('documento_id');
        });

        //crear nueva llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('documento_id')->after('estado')->constrained('documentos')->onDelete('cascade');
        });

        //crear nuevo campo numero_documento
        Schema::table('personas', function (Blueprint $table) {
            $table->string('numero_documento',20)->after('documento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //elminar nueva llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['documento_id']);
            $table->dropColumn('documento_id');
        });

        //crear llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('documento_id')->after('estado')->unique()->constrained('documentos')->onDelete('cascade');
        });

        //eliminar el nuevo  campo numero_documento
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('numero_documento',20)->after('documento_id');
        });
    }
};
