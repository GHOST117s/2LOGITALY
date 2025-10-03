<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ports = [
            // Major Asian Ports
            'CNSHA' => 'Shanghai',
            'SGSIN' => 'Singapore',
            'CNNGB' => 'Ningbo',
            'CNSZX' => 'Shenzhen',
            'HKHKG' => 'Hong Kong',
            'KRPUS' => 'Busan',
            'CNQIN' => 'Qingdao',
            'CNTAO' => 'Qingdao',
            'JPYOK' => 'Yokohama',
            'JPKOB' => 'Kobe',

            // European Ports
            'NLRTM' => 'Rotterdam',
            'DEHAM' => 'Hamburg',
            'BEANR' => 'Antwerp',
            'GBFXT' => 'Felixstowe',
            'ESPMI' => 'Algeciras',
            'ITGOA' => 'Genoa',
            'GRCPR' => 'Piraeus',
            'FRLEH' => 'Le Havre',
            'ITLSP' => 'La Spezia',
            'ESSCT' => 'Valencia',

            // US Ports
            'USLAX' => 'Los Angeles',
            'USLGB' => 'Long Beach',
            'USNYC' => 'New York',
            'USSAV' => 'Savannah',
            'USORF' => 'Norfolk',
            'USHOU' => 'Houston',
            'USOAK' => 'Oakland',
            'USBAL' => 'Baltimore',
        ];

        $shippers = [
            'Maersk Line',
            'MSC Mediterranean Shipping',
            'COSCO Shipping',
            'CMA CGM Group',
            'Hapag-Lloyd',
            'Ocean Network Express',
            'Evergreen Marine',
            'Yang Ming Marine',
            'HMM (Hyundai Merchant Marine)',
            'ZIM Integrated Shipping',
        ];

        $consignees = [
            'Amazon Logistics',
            'Walmart Distribution',
            'Target Corporation',
            'IKEA Supply Chain',
            'Nike Global Logistics',
            'Apple Supply Chain',
            'Samsung Electronics',
            'Toyota Motors',
            'Ford Motor Company',
            'General Electric',
        ];

        $agents = [
            'DHL Global Forwarding',
            'Kuehne + Nagel',
            'DB Schenker',
            'Expeditors International',
            'CEVA Logistics',
            'Panalpina',
            'Damco',
            'Bollore Logistics',
            'Agility Logistics',
            'Nippon Express',
        ];

        $statuses = ['Booked', 'Picked Up', 'Departed', 'Arrived', 'Delivered'];
        $transportModes = ['Ocean', 'Air', 'Land'];
        $shipmentTypes = ['FCL', 'LCL'];
        $serviceTypes = ['Standard', 'Express', 'Economy'];
        $movementTypes = ['CY-CY', 'CY-CFS', 'CFS-CY', 'CFS-CFS'];

        $portCodes = array_keys($ports);

        for ($i = 1; $i <= 50; $i++) {
            $polCode = $portCodes[array_rand($portCodes)];
            $podCode = $portCodes[array_rand($portCodes)];

            // Ensure POL and POD are different
            while ($podCode === $polCode) {
                $podCode = $portCodes[array_rand($portCodes)];
            }

            $status = $statuses[array_rand($statuses)];
            $baseDate = Carbon::now()->subDays(rand(1, 60));

            // Generate timeline dates based on status
            $bookedEst = $baseDate->copy();
            $bookedAct = rand(0, 1) ? $bookedEst->copy()->addHours(rand(1, 24)) : null;

            $pickedUpEst = $bookedEst->copy()->addDays(rand(1, 3));
            $pickedUpAct = in_array($status, ['Picked Up', 'Departed', 'Arrived', 'Delivered']) && rand(0, 1)
                ? $pickedUpEst->copy()->addHours(rand(1, 48)) : null;

            $departedEst = $pickedUpEst->copy()->addDays(rand(1, 2));
            $departedAct = in_array($status, ['Departed', 'Arrived', 'Delivered']) && rand(0, 1)
                ? $departedEst->copy()->addHours(rand(1, 24)) : null;

            $arrivedEst = $departedEst->copy()->addDays(rand(7, 21));
            $arrivedAct = in_array($status, ['Arrived', 'Delivered']) && rand(0, 1)
                ? $arrivedEst->copy()->addHours(rand(1, 48)) : null;

            $delivered = $status === 'Delivered' && rand(0, 1)
                ? $arrivedEst->copy()->addDays(rand(1, 3)) : null;

            Booking::create([
                'Booking_ID' => 'BKG' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'booked_est' => $bookedEst,
                'booked_act' => $bookedAct,
                'picked_up_est' => $pickedUpEst,
                'picked_up_act' => $pickedUpAct,
                'departed_est' => $departedEst,
                'departed_act' => $departedAct,
                'arrived_est' => $arrivedEst,
                'arrived_act' => $arrivedAct,
                'delivered' => $delivered,
                'shipper_name' => $shippers[array_rand($shippers)],
                'consignee_name' => $consignees[array_rand($consignees)],
                'origin_agent' => $agents[array_rand($agents)],
                'destination_agent' => $agents[array_rand($agents)],
                'booking_reference' => 'REF' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'booking_status' => $status,
                'lsp_carrier' => $shippers[array_rand($shippers)],
                'tracking_no' => 'TRK' . str_pad($i, 10, '0', STR_PAD_LEFT),
                'mode_of_transport' => $transportModes[array_rand($transportModes)],
                'shipment_type' => $shipmentTypes[array_rand($shipmentTypes)],
                'service_type' => $serviceTypes[array_rand($serviceTypes)],
                'movement_type' => $movementTypes[array_rand($movementTypes)],
                'number_of_containers' => rand(1, 10),
                'container_number' => 'CONT' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'shipper_reference_number' => 'SHP' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'house_bl' => 'HBL' . str_pad($i, 9, '0', STR_PAD_LEFT),
                'master_bl' => 'MBL' . str_pad($i, 9, '0', STR_PAD_LEFT),
                'gross_weight' => rand(1000, 50000) / 100, // Random weight between 10-500 kg
                'hs_code' => str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'is_dg_goods' => rand(0, 1),
                'is_reefer' => rand(0, 1),
                'load_reference' => 'LOAD' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'place_of_receipt' => $ports[$polCode],
                'port_of_loading' => $polCode,
                'port_of_discharge' => $podCode,
                'place_of_delivery' => $ports[$podCode],
                'comments' => rand(0, 1) ? 'Sample booking entry #' . $i : null,
            ]);
        }
    }
}
