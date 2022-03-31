<?php

use App\Models\Standard;
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
        Schema::create('standards', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->text('title')->nullable();
            $table->text('url');
            $table->string('provider')->nullable();
            $table->text('overview')->nullable();
            $table->string('status')->nullable();
            $table->string('year')->nullable();
            $table->text('cross_reference')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('pages')->nullable();
            $table->text('replaces')->nullable();
            $table->string('replaced_by')->nullable();
            $table->string('provider_standard_id')->nullable();
            $table->string('isbn')->nullable();
            $table->date('changed_at')->nullable();
            $table->date('publication_date')->nullable();
            $table->date('withdrawn_date')->nullable();
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
        Schema::dropIfExists('standards');
    }
};
