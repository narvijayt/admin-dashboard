@if ($errors->any())
    <div class="m-3 alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('error'))
    <div class="m-3 alert alert-danger">
        @if(is_array(session()->get('error')))
            @foreach(session()->get('error') as $errorKey=>$errorText)
                <div>{{ $errorText }}</div>
            @endforeach
        @else
            {{ session()->get('error') }}
        @endif
    </div>
@endif

@if(session()->has('message'))    
    <div class="m-3 alert alert-success">
        @if(is_array(session()->get('message')))
            @foreach(session()->get('message') as $messageKey=>$messageText)
            <div>{{ $messageText }}</div>
            @endforeach
        @else
            {{ session()->get('message') }}
        @endif
    </div>
@endif