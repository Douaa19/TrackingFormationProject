<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Models\SupportTicket;
use App\Models\TicketStatus as ModelsTicketStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        SupportTicket::latest()->lazyById(100,'id')->each(function(SupportTicket $ticket){
            $ticket->update([
                'user_last_reply' => $ticket->created_at
            ]);
        });
        
        $sqlQuery = "ALTER TABLE support_tickets MODIFY COLUMN status BIGINT UNSIGNED";
        DB::statement($sqlQuery);

        /** trigger table  */

        try {
            DB::table('ticket_triggers')->truncate();
            $sqlQuery = "ALTER TABLE `ticket_triggers` ADD PRIMARY KEY(`id`)";
            DB::statement($sqlQuery);
            $sqlQuery = "ALTER TABLE `ticket_triggers` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT";
            DB::statement($sqlQuery);
            
        } catch (\Throwable $th) {
            //throw $th;
        }
     
        DB::table('ticket_statuses')->truncate();
        

        $ticketStauts = collect(TicketStatus::toArray())->each(function(int $id , string $status){

            $ticketStatus             =  new ModelsTicketStatus();
            $ticketStatus->id         =  $id;
            $ticketStatus->name       =  $status;
            $ticketStatus->color_code = '#db1414';
            $ticketStatus->status     =  StatusEnum::true->status();
            $ticketStatus->is_base    =  StatusEnum::true->status();
            $ticketStatus->default    =  ($id == TicketStatus::PENDING->value) 
                                            ? StatusEnum::true->status() 
                                            : StatusEnum::false->status();

            $ticketStatus->save();




        });



    }
}
