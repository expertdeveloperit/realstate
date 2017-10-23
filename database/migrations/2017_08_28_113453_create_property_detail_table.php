<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('bathrooms');
            $table->integer('bedrooms');
            $table->integer('bedrooms_above_ground');
            $table->integer('bedrooms_below_ground');
            $table->string('amenities');
            $table->string('cooling_type');
            $table->string('exterior_finish');
            $table->string('fireplace_present');
            $table->string('heating_fuel');
            $table->string('Heating_type');
            $table->string('type');
            $table->string('street_address');
            $table->string('address_line1');
            $table->string('street_number');
            $table->string('street_name');
            $table->string('street_suffix');
            $table->string('unit_number');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('country');
            $table->string('community_name');
            $table->string('features');
            $table->string('listing_contract_date');
            $table->string('maintenance_fee');
            $table->string('maintenance_fee_payment_unit');
            $table->string('management_company');
            $table->string('ownership_type');
            $table->string('parking_space_total');
            $table->string('price');
            $table->string('property_type');
            $table->longText('public_remarks');
            $table->string('transaction_type');
            $table->string('more_information_link');
            $table->rememberToken();
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
        Schema::dropIfExists('property_detail');
    }
}
