<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes; // Add this trait
    protected $fillable = [
        'shipper_name',
        'consignee_name',
        'origin_agent',
        'destination_agent',
        'booking_reference',
        'booking_status',
        'lsp_carrier',
        'tracking_no',
        'mode_of_transport',
        'shipment_type',
        'service_type',
        'movement_type',
        'number_of_containers',
        'container_number',
        'shipper_reference_number',
        'house_bl',
        'master_bl',
        'gross_weight',
        'hs_code',
        'is_dg_goods',
        'is_reefer',
        'load_reference',
        'place_of_receipt',
        'port_of_loading',
        'port_of_discharge',
        'place_of_delivery',
        'comments',
    ];
    
}
