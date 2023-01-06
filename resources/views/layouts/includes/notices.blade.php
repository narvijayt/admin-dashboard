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
        {{ session()->get('error') }}
    </div>
@endif

@if(session()->has('message'))    
    <div class="m-3 alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif