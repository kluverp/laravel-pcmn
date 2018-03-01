<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXrefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName('xref'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('child_id');
            $table->string('child_table');
            $table->string('parent_id');
            $table->string('parent_table');
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
        Schema::dropIfExists($this->getTableName('xref'));
    }

    /**
     * Returns the prefixed table name.
     *
     * @param $name
     * @return string
     */
    private function getTableName($name)
    {
        return config('pcmn.config.table_prefix') . $name;
    }
}
