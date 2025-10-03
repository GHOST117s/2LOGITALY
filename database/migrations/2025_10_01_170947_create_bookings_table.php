<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('Booking_ID')->unique();
            $table->timestamp('booked_est')->nullable()->after('comments');
            $table->timestamp('booked_act')->nullable()->after('booked_est');
            $table->timestamp('picked_up_est')->nullable()->after('booked_act');
            $table->timestamp('picked_up_act')->nullable()->after('picked_up_est');
            $table->timestamp('departed_est')->nullable()->after('picked_up_act');
            $table->timestamp('departed_act')->nullable()->after('departed_est');
            $table->timestamp('arrived_est')->nullable()->after('departed_act');
            $table->timestamp('arrived_act')->nullable()->after('arrived_est');
            $table->timestamp('delivered')->nullable()->after('arrived_act');
            $table->string('shipper_name');
            $table->string('consignee_name');
            $table->string('origin_agent');
            $table->string('destination_agent');
            $table->string('booking_reference');
            $table->string('booking_status');
            $table->string('lsp_carrier');
            $table->string('tracking_no')->nullable();
            $table->string('mode_of_transport');
            $table->string('shipment_type');
            $table->string('service_type');
            $table->string('movement_type');
            $table->integer('number_of_containers');
            $table->string('container_number');
            $table->string('shipper_reference_number');
            $table->string('house_bl');
            $table->string('master_bl');
            $table->float('gross_weight');
            $table->string('hs_code');
            $table->boolean('is_dg_goods')->default(false);
            $table->boolean('is_reefer')->default(false);
            $table->string('load_reference');
            $table->string('place_of_receipt');
            $table->string('port_of_loading');
            $table->string('port_of_discharge');
            $table->string('place_of_delivery');
            $table->text('comments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
