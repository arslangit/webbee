<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
         *  see the shows table
     * As a user I want to only see the shows which are not booked out
        *  see the show_seats table for booked_by null

     **Show administration**
     * As a cinema owner I want to run different films at different times
         * use the shows table
     * As a cinema owner I want to run multiple films at the same time in different showrooms
        * use the shows table

     **Pricing**
     * As a cinema owner I want to get paid differently per show
        Can override the price for seat *
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat
         * Use the seat type

     **Seating**
     * As a user I want to book a seat
         * add user_id in show_seats.booked_by table
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name');
            // more columns as per needed
            $table->timestamps();
        });

        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('descriptions');
            $table->tinyInteger('status')->comment("0 for un active 1 for active");
            $table->timestamps();
        });

        Schema::create('showrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('descriptions');
            $table->tinyInteger('status')->comment("0 for un active 1 for active");
            $table->timestamps();
        });

        Schema::create('seattypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('descriptions');
            $table->double('premium_percentage');
            $table->tinyInteger('status')->comment("0 for un active 1 for active");
            $table->timestamps();
        });

        Schema::create('seats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('descriptions');
            $table->double('price'); // default price
            $table->foreign('seat_type')->references('id')->on('seattypes')->onDelete('cascade');
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
            $table->tinyInteger('status')->comment("0 for un active 1 for active");
            $table->timestamps();
        });

        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('descriptions');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->timestamps();
        });

        /** to get paid differently for each show */
        Schema::create('show_seats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('price'); // copy the default price but price can be over rided for every show if needed
            $table->foreign('booked_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
            $table->timestamps();
        });

        throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
