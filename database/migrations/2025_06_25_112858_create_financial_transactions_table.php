<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('prefix', ['นาย', 'นาง', 'นางสาว']);
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate');
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_transactions');
    }
}
