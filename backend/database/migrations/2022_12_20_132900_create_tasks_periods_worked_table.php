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
        Schema::create('tasks_periods_worked', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('task_id')->constrained();
            $table->timestamp('created_at');
            $table->timestamp('terminated_at');
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
        Schema::dropIfExists('tasks_periods_worked');
    }
};
