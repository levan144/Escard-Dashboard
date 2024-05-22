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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longtext('subtitle')->nullable();
            $table->longtext('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('sale_text')->nullable();
            $table->json('benefits')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('company_id');
            $table->integer('category_id');
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
        Schema::dropIfExists('offers');
    }
};
