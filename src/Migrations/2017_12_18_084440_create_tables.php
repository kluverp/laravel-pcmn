<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName('user'), function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(0);
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('reset_token')->nullable();
            $table->dateTime('last_visit')->nullable();
            $table->timestamps();
        });

        // add admin user
        DB::table($this->getTableName('user'))->insert([
            'active' => true,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('@admin')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('user'));
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
