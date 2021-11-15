<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_log', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction', ['send', 'received']);
            $table->decimal('before_value', 10, 2);
            $table->decimal('transfer_value', 10, 2);
            $table->decimal('current_value', 10, 2);
            $table->foreignId('user_id_transfer')->references('id')->on('users');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('wallet_log');
    }
}
