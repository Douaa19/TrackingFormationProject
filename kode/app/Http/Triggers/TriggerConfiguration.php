<?php

namespace App\Http\Triggers;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\TicketStatus as ModelsTicketStatus;
use Illuminate\Database\Eloquent\Collection;

class TriggerConfiguration extends Controller
{

    protected array $agents ;
    protected array $operators ;
    protected array $conditions ;
    protected array $actions ;
    protected array $categories ;

    public function __construct(){

        $locale            = session()->get('locale','en');
        $this->agents      = Admin::agent()->pluck('name','id')->toArray();

        $this->categories  = Category::pluck('name','id')
                                ->mapWithKeys(function ($name , $id) {

                                    $name = limit_words(get_translation($name),15) ;
                                    return [$id => $name];
                                })
                                ->toArray();;

        
        $this->operators = [
            0 => [
                'name' => 'contains',
                'display_name' => 'Contains',

            ],
            1 => [
                'name' => 'not_contains',
                'display_name' => 'Does not contain',
                
            ],
            2 => [
                'name' => 'starts_with',
                'display_name' => 'Starts with',
                
            ],
            3 => [
                'name' => 'ends_with',
                'display_name' => 'Ends with',
                
            ],
            4 => [
                'name' => 'equals',
                'display_name' => 'Equals',
                
            ],
            5 => [
                'name' => 'not_equals',
                'display_name' => 'Does not equal',
                
            ],
            6 => [
                'name' => 'matches_regex',
                'display_name' => 'Matches regex pattern',
                
            ],
            7 => [
                'name' => 'more',
                'display_name' => 'More than',
                
            ],
            8 => [
                'name' => 'less',
                'display_name' => 'Less than',
                
            ],
            9 => ['name' => 'is', 'display_name' => 'Is'],
            10 => [
                'name' => 'not',
                'display_name' => 'Is not',
                
            ],
            11 => [
                'name' => 'changed',
                'display_name' => 'Changed',
              
            ],
            12 => [
                'name' => 'changed_to',
                'display_name' => 'Changed to',
              
            ],
            13 => [
                'name' => 'changed_from',
                'display_name' => 'Changed from',
              
            ],
            14 => [
                'name' => 'not_changed',
                'display_name' => 'Not changed',
              
            ],
            15 => [
                'name' => 'not_changed_to',
                'display_name' => 'Not changed to',
              
            ],
            16 => [
                'name' => 'not_changed_from',
                'display_name' => 'Not changed from',
              
            ],
        ];
    
        $this->conditions = [
          
             'ticket' => [
                'subject' => [
                    'operators' => [0, 1, 2, 3, 4, 5, 6],
                ],
                'body' => [
                    'operators' => [0, 1, 2, 3],
                ],
                'status' => [
                    'operators'   => [9, 10, 11, 12, 13, 14, 15, 16],
                    'values'      => array_flip(ModelsTicketStatus::pluck('id','name')->toArray()),
                    'type'        => 'select'
                ],
                'category' => [
                    'operators'   => [9, 10, 11, 12, 13, 14, 15, 16],
                    'values'      =>  $this->categories,
                    'type'        => 'select',
                ],
                'uploads' => [
                    'operators' => [4, 5, 7, 8],
                ],
                'assignee' => [
                    'operators'   => [4,5],
                    'type'        => 'select',
                    'values'      =>  $this->agents, 
            
                ],
                'mail' => [
                    'operators' => [0, 1, 2, 3, 4, 5, 6],
                ],
            ],
    
            'customer' => [
                'name' => [
                    'operators' => [0, 1, 2, 3, 4, 5, 6],
                ],
                'email' => [
                    'operators' => [0, 1, 2, 3, 4, 5, 6],
                ],
        
            ],
           
            'timeframe' =>  [
                'hours_since_created' => [
                    'timeBased' => true,
                    'operators' => [9, 7, 8],
              
                ],
                'hours_since_closed' => [
                    'timeBased' => true,
                    'operators' => [9, 7, 8],
     
                ],
                'hours_since_last_activity' => [
                    'timeBased' => true,
                    'operators' => [9, 7, 8]
             
                ],
                'hours_since_last_reply' => [
                    'timeBased' => true,
                    'operators' => [9, 7, 8],
                ],
                'hours_since_last_user_reply' => [
                    'timeBased' => true,
                    'operators' => [9, 7, 8],
                ],
            ],
            
            
        ];
    
        $this->actions = [
            [
                'display_name' => 'Move to Category',
                'name'         => 'move_to_category',
                'inputs' => [
                    [
                        'name'           => 'categories',
                        'type'           => 'select',
                        'values'         => $this->categories,
                    ],
                ],
    
            ],
    
    
            [
                'display_name' => 'Notify: via Email To User',
                'name'         => 'send_email_to_user',

                'inputs' => [
                   
                    [
                        'placeholder' => 'Subject',
                        'type' => 'text',
                        'name' => 'subject',
                    ],
                    [
                        'placeholder' => 'Email Message',
                        'type' => 'textarea',
                        'name' => 'message',
                    ],
                ],
            ],
    
    
            [
                'display_name' => 'Notify: via Email To Agent',
                'name'         => 'send_email_to_agent',
    
                'inputs' => [
                    [
                        'type'           => 'select',
                        'name'           => 'agents',
                        'values'         => $this->agents,
                    ],
                    [
                        'placeholder' => 'Subject',
                        'type' => 'text',
                        'name' => 'subject',
                    ],
                    [
                        'placeholder' => 'Email Message',
                        'type' => 'textarea',
                        'name' => 'message',
                    ],
                ],
            ],
            [
                'display_name' => 'Notify: via SMS To Agent',
                'name'         => 'send_sms_to_agent',
    
                'inputs' => [
                    [
                        'type'           => 'select',
                        'name'           => 'agents',
                        'values'         => $this->agents,
                    ],
                  
                    [
                        'placeholder' => 'SMS Message',
                        'type' => 'textarea',
                        'name' => 'message',
                    ],
                ],
            ],
    
    
            [
                'display_name' => 'Add a note',
                'name'         => 'add_note_to_ticket',
    
                'inputs' => [
                    [
                        'type' => 'textarea',
                        'placeholder' => 'Note Text',
                        'name' => 'note_text',
    
                    ]
                ]
    
            ],


                
            [
                'display_name' => 'Add a reply',
                'name'         => 'add_reply_to_ticket',
    
                'inputs' => [
                    [
                        'type' => 'textarea',
                        'placeholder' => 'Reply text',
                        'name' => 'reply_text',
    
                    ]
                ]
    
            ],
            [
                'display_name' => 'Change status',
                'name' => 'change_status',
                'ticket_update' => true,
    
                'inputs' => [
                    [
                        'type'           => 'select',
                        'values'         => array_flip(ModelsTicketStatus::pluck('id','name')->toArray()),
                        'name'           => 'status_name',
                    ],
                ],
                
               
            ],
            [
                'display_name' => 'Assign to Agent',
                'name' => 'assign_to_agent',
                'inputs' => [
                    [
                        'type'           => 'select',
                        'name'           => 'agents',
                        'data_type'      => 'array',
                        'is_multiple'    => true,
                        'values'         => $this->agents,
                    ],
                ],

               
            ],
       
            [
                'display_name' => 'Delete',
                'name' => 'delete_ticket',
            ],
        ];
    
    }


   


    public function getTriggerConfig()  :array{

        return [
            'operators'  => $this->operators,
            'conditions' => $this->conditions,
            'actions'    => $this->actions,
        ];

        

    }

    
    


}