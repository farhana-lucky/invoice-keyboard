<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();

            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('date')->nullable();

            $table->string('from_address')->nullable();
            $table->string('to_address')->nullable();

            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('work_hours')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('labor')->nullable();
            $table->integer('stairs')->nullable();
            $table->integer('supplies')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('tax')->nullable();
            $table->double('total')->nullable();

            $table->string('driver')->nullable();
            $table->string('helper')->nullable();
            $table->string('vehicle')->nullable();

            $table->string('inspected_by')->nullable();
            $table->string('crew_initial')->nullable();
            $table->string('customer_initial')->nullable();

            $table->string('sign')->nullable();
            $table->text('comment_instruction')->nullable();
            $table->text('operation_details')->nullable();

            $table->boolean('mail')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
