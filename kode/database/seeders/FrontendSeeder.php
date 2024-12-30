<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Frontend;
use Illuminate\Database\Seeder;

class FrontendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existingSetup = Frontend::pluck('slug')->toArray();



        $settings = [

                "banner_section" =>[

                    "static_element" => [
                        "title" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),

                        "banner_image" => array(
                            "type" => "file",
                            "value" => "",
                            "size" => "520x480"
                        ),
                    ]
                ],

                "explore_section" => [

                    "static_element" => [

                        "title" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "sub_title" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),

                        "btn_text" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "btn_url" => array(
                            "type" => "url",
                            "value" => ""
                        ),

                        "banner_image" => array(
                            "type" => "file",
                            "value" => "",
                            "size" => "490x450"
                        ),

                    ]
                    
                ],

                "support_section" => [

                        "static_element" => [
                        "title" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "sub_title" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                    ]

                ],

                "faq_section" => [

                    "static_element" => [
                        "title" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "sub_title" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                    ]

                ]
                ,
                
                "contact_section" => [

                    "static_element" => [
                        "title" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),

                    ]

                ]
                ,

                "newsletter_section" => [
                    "static_element" => [
                        "title" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),
                    ]

                ]  ,
            

               "social_section" => [
                    "static_element" => [
                        "facebook"=>
                          array(
                            "icon" => "#",
                            "url" => "#",
                            "type" => "text"
                        ),
                        "google"=>
                          array(
                            "icon" => "#",
                            "url" => "#",
                            "type" => "text"
                        ),
                        "linked_in"=>
                          array(
                            "icon" => "#",
                            "url" => "#",
                            "type" => "text"
                        ),
                        "twitter"=>
                          array(
                            "icon" => "#",
                            "url" => "#",
                            "type" => "text"
                        ),
                        "instagram"=>
                          array(
                            "icon" => "#",
                            "url" => "#",
                            "type" => "text"
                        ),
                    ]

                ]
                ,
            
                "footer_section" => [
                    "static_element" =>  
                    [
                        "title" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),
                    ]
                ],




                // "test_section" => [
                //     "static_element" =>  
                //     [
                //         "title" => array(
                //             "type" => "textarea",
                //             "value" => ""
                //         ),
                //     ],
                //     "dynamic_element" =>  
                //     [
                //         "title" => array(
                //             "type" => "textarea",
                //             "value" => ""
                //         ),
                //     ]
                // ],
            
            
            ];
            

        $frontendSection = [];
        foreach($settings as $key=>$value){
            $newSection = [];
            if(!in_array($key,$existingSetup)){
                 $newSection['name'] = ucfirst(str_replace('_',' ',$key));
                 $newSection['slug'] = $key;
                 $newSection['value'] = json_encode($settings[$key]);
                 $newSection['status'] = StatusEnum::true->status();

                 array_push($frontendSection ,$newSection);
            }
        }

       
        Frontend::insert($frontendSection);

    }
}
