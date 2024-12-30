@if (site_settings('enable_business_hour') == App\Enums\StatusEnum::true->status())

    <div class="bg--light rounded">
        @php
            $timeZone = str_replace("'", '', site_settings('time_zone'));
            $business_hours = site_settings(key: 'business_hour', default: null)
                ? json_decode(site_settings(key: 'business_hour', default: null), true)
                : [];
            $today = now()->timezone($timeZone)->format('D');

            $todaysOperatingHour = Arr::get($business_hours, $today);

            $online = false;

            if (is_array($todaysOperatingHour)) {
                $dayOn = Arr::get($todaysOperatingHour, 'is_off');

                $todayStartTime = Arr::get($todaysOperatingHour, 'start_time');
                $todayEndTime = Arr::get($todaysOperatingHour, 'end_time');

                if (
                    $dayOn &&
                    ((strtotime($todayStartTime) <= strtotime(now()->timezone($timeZone)->format('h:i A')) &&
                        strtotime($todayEndTime) >= strtotime(now()->timezone($timeZone)->format('h:i A'))) ||
                        $todayStartTime == '24H')
                ) {
                    $online = true;
                }
            }
        @endphp

        <div class="support-collapse">
            <div class="d-flex align-items-center flex-column justify-content-betweenpb-2 gap-0">
                <h5 class="d-block mb-0">
                    {{ translate('Support agent') }}
                </h5>
                <span class="d-block">
                     @if ($online)
                    <span class="text-success fs-15 ms-2">
                        {{ translate('Online') }}
                    </span>
                    @else
                        <span class="text-danger fs-15 ms-2">
                            {{ translate('Offline') }}
                        </span>
                    @endif
                </span>
            </div>
        </div>


        <div id="operating-hour-collapse">
            <div class="support-collapse mt-4">
           

                <ul class="open-close-list">


                    @foreach ($business_hours as $day => $hours)
                        @php

                            $endTime = Arr::get($hours, 'end_time');
                            $startTime = Arr::get($hours, 'start_time');
                            $isDayOn = Arr::get($hours, 'is_off');

                            $days =  [
                                        'Mon' =>  'Monday',
                                        'Tue' =>  'Tuesday',
                                        'Wed' =>  'Wednesday',
                                        'Thu' =>  'Thursday',
                                        'Fri' =>  'Friday',
                                        'Sat' =>  'Saturday',
									];

                            $class = 'today';
                            if(!$isDayOn){
                                $class = 'close-day'; 
                            }
                            if($startTime == '24H'){
                                $class = 'full-day';   
                            }
                        @endphp

                            <li class="{{ $class }}">
                                <div class="day">{{  translate(Arr::get($days,$day))  }}</div>
                                <span class="dot-line"></span>
                                    <div class="time">

                                        <p>
                                            {{ $isDayOn ?  $startTime : translate('Closed') }}
                                        </p>
                                        @if ($today == $day)
                                            <div class="today-badge">
                                                {{ translate('Today') }}
                                            </div>
                                        @endif
                                        @if($isDayOn && $startTime != '24H' )
                                            <p class="end">
                                                {{ $endTime }}
                                            </p>
                                        @endif
                                    </div>
                            </li>



                         
                    @endforeach
                      
                @php 
             
                   $note = str_replace(
                      '[timezone]',
                      $timeZone,
                      site_settings('operating_note')
                    );


                @endphp
                <div class="mb-0 p-2 border opening-note border-info rounded text-info"> 
                    @php echo $note @endphp
                </div>
            </div>
        </div>
    </div>
@endif
