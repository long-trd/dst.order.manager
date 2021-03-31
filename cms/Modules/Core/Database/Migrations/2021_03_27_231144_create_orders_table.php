<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('shipping_user_id')->unsigned()->nullable();
            $table->integer('helping_user_id')->unsigned()->nullable();
            $table->integer('listing_user_id')->unsigned()->nullable();
            $table->longText('name')->nullable();
            $table->longText('ebay_url')->nullable();
            $table->longText('product_url')->nullable();
            $table->longText('status')->nullable();
            $table->longText('shipping_information')->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->longText('customer_notes')->nullable();
            $table->longText('tracking')->nullable();
            $table->longText('paypal_notes')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('shipping_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('helping_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('listing_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_shipping_user_id_foreign');
            $table->dropForeign('orders_helping_user_id_foreign');
            $table->dropForeign('orders_listing_user_id_foreign');
            $table->dropForeign('orders_account_id_foreign');
        });

        Schema::dropIfExists('orders');
    }
}
