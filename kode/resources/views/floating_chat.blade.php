@if($messages->count() != 0)
<div class="chat-body"> 

        <ul class="chat-list"> 
            @foreach($messages as $message)
                <li class="chat-{{ $message->sender == App\Enums\StatusEnum::true->status() ? 'left' : 'right' }}">
                    <p>{{ $message->message }}</p>
                    <span>{{ diff_for_humans($message->created_at) }}</span>
                </li>
            @endforeach
        </ul> 

 </div>

@else
    <div class="chat-body text-center mx-auto d-flex align-items-center justify-content-center"> 
        {{translate("Start Message")}}
    </div>
@endif

