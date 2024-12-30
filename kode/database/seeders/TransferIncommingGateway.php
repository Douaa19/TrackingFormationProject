<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\IncommingMailGateway;
use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
class TransferIncommingGateway extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        try {

            /** V2.1*/

            $queries = [
    
                "ALTER TABLE `departments` ADD COLUMN `envato_item_id` VARCHAR(255) UNIQUE NULL AFTER `id`",
                "ALTER TABLE `users` ADD COLUMN `envato_purchases` LONGTEXT NULL AFTER `email`",
                "ALTER TABLE `admins` ADD `super_agent` TINYINT NULL AFTER `muted_ticket`",
                "ALTER TABLE `admins` ADD `super_admin` TINYINT NULL AFTER `agent`",
                "ALTER TABLE `departments` ADD `envato_payload` LONGTEXT NULL AFTER `status`",
                "ALTER TABLE `canned_replies` ADD `share_with` LONGTEXT NULL AFTER `status`",
                "ALTER TABLE `support_tickets` ADD `envato_payload` LONGTEXT NULL AFTER `notification_settings`",
                "ALTER TABLE `support_tickets` ADD `is_support_expired` TINYINT NULL AFTER `subject`",
            ];
        
            foreach ($queries as $query) {
                DB::statement($query);
            }

        } catch (\Exception $ex) {
        

        }
    
    }
}
