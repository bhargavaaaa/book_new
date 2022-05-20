<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignkeyFromStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('students_standard_id_foreign');
            $table->dropColumn('standard_id');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->integer('standard_id')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->bigInteger('standard_id')->index()->unsigned();

            $table->foreign('standard_id')->references('id')->on('standards')->onDelete('cascade');
        });
    }
}
