<?php

namespace App\Http\Triggers;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketTrigger;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
class TriggerAction extends Controller
{

    public TriggerConfiguration $triggerConfiguration ;
    public array $triggerConfig;
    public array $conditions;
    public array $timeFrame;
    public SupportTicket $ticket;
    public array $originaTicket;
    public Conditions $condition;
    public array $conditionTypes;


    public function __construct(SupportTicket $ticket , array $originaTicket){

        $this->ticket                =  $ticket;
        $this->originaTicket         =  ($originaTicket);
        $this->triggerConfiguration  =  new TriggerConfiguration();
        $this->condition             =  new Conditions();
        $this->triggerConfig         =  $this->triggerConfiguration->getTriggerConfig();
        $this->conditions            =  Arr::get($this->triggerConfig  , 'conditions' , []);
        $this->timeFrame             =  Arr::get($this->conditions  , 'timeframe' , []);

    }

    public function fireTrigger() :void {

        TicketTrigger::latest()->active()->lazy()
        ->each(function( $trigger)  {
            $this->triggerAction($trigger);
        });

    }


    public function triggerAction(TicketTrigger $trigger , bool $timeFrame = false)  :void{


        $getAllconditions  = @$trigger->all_condition; 
        $getAnyconditions  = @$trigger->any_condition; 

        $matchAll          = ($getAllconditions &&  $getAllconditions->condition_type) 
                                        ? ($this->matchCondition(conditions : $getAllconditions ,type :'match_all' ,timeFrame : $timeFrame))
                                        : false;

        $matchAny          = ($getAnyconditions &&  $getAnyconditions->condition_type ) 
                                        ? $this->matchCondition(conditions : $getAnyconditions,type :'match_any' , timeFrame  : $timeFrame)
                                        : false ;

                                   
        match (true) {
            $matchAll || $matchAny => $this->fireAction($trigger , $timeFrame),
            default => null,
        };


    }




    public function matchCondition(object $conditions , string $type = 'match_all' , bool $timeFrame = false  )  :mixed{


        [$timeFrameKeys, $values] = Arr::divide($this->timeFrame);


        foreach($conditions->condition_type as $index => $condition ){

            $operator =  Arr::get($conditions->conditions,$index, null );
            $value    =  Arr::get($conditions->condition_value,$index, null);

    
            if (($timeFrame && in_array($condition, $timeFrameKeys)) || (!$timeFrame && !in_array($condition, $timeFrameKeys))) {
        
                $response = $this->condition->{$condition}($this->originaTicket, $this->ticket, $operator, $value);

                if($type =='match_all' && !$response){
                    return false;
                }
                if($type =='match_any' && $response){
                    return true;
                }
            }
          
        }

        return $type  == 'match_all' ? true : false; 

    }

 

    public function fireAction(TicketTrigger $trigger ,bool $timeFrame = false){

        $alreadyLockedTrigger = @$this->ticket->locked_trigger ?? [];


        try {
            if($trigger->actions){
       
                foreach($trigger->actions as $actionKey => $actionValue){
                    if($timeFrame && in_array($trigger->id,$alreadyLockedTrigger)){
                        continue;
                    }
                    $response = $this->condition->{$actionKey}($this->ticket, $actionValue ,$trigger);

                }

                if($timeFrame && !in_array($trigger->id,$alreadyLockedTrigger)){
                    $alreadyLockedTrigger[]  = $trigger->id;
                    $this->ticket->locked_trigger = $alreadyLockedTrigger;
                    $this->ticket->saveQuietly();
                }

                
            }
     
            $trigger->increment('triggered_counter',1);
            $trigger->last_triggered =  Carbon::now();
            $trigger->save();


         

        } catch (\Throwable $th) {
   
        }
       
    }

    public function getActiveTriggers() :mixed {
        return TicketTrigger::active()->get();
    }



    public function createTriggerLog(TicketTrigger $trigger){

    }


    /**
     * Compare string haystack and needle using specified operator.
     *
     * @param string $operator
     *
     * @return bool
     */
    public function compare(mixed $haystack, mixed $needle, string $operator) :bool
    {
        return match ($operator) {
            'contains' => Str::contains($haystack, $needle),
            'not_contains' => ! Str::contains($haystack, $needle),
            'starts_with' => Str::startsWith($haystack, $needle),
            'ends_with' => Str::endsWith($haystack, $needle),
            'equals', 'is' => $haystack === $needle,
            'not_equals', 'not' => $haystack !== $needle,
            'more' => $haystack > $needle,
            'less' => $haystack < $needle,
            'matches_regex' => (bool) preg_match("/$needle/", $haystack),
            default => false,
        };
    }


    
    


}