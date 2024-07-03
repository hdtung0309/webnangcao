<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGenderColumnInStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('gender', 10)->change();
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->change();
        });
    }
}