<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeIdToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Aggiungi la colonna 'type_id' solo se non esiste
            if (!Schema::hasColumn('projects', 'type_id')) {
                $table->unsignedBigInteger('type_id')->nullable(); // Colonna nullable
            }
        });

        // Aggiungi la chiave esterna solo se la colonna è stata aggiunta
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'type_id')) {
                $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Rimuovi la chiave esterna e la colonna 'type_id' se esistono
            $table->dropForeign(['type_id']); // Rimuove la chiave esterna
            $table->dropColumn('type_id');    // Rimuove la colonna
        });
    }
}
