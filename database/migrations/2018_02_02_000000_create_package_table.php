<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{

    private $table;

    /**
     * CreatePackageTable constructor.
     */
    public function __construct()
    {
        $this->table = '';
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//        if (!Schema::hasTable($this->table)) {
//            Schema::create($this->table, function (Blueprint $table) {
//                $table->increments('id');

                // .....

//                $table->timestamps();
//            });
//        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists($this->table);
    }
}
