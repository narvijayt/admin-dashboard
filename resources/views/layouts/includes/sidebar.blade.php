<div class="sidebar-nav sidebar-dark px-0 box-shadow-none min-vh-100">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link px-3">
        <span class="brand-text font-weight-light"><b> {{ env('APP_NAME', 'Admin Dashboard')}}</b></span>
    </a>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item mb-1 {{ (getControllerName() == 'DashboardController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('dashboard') }}"> <i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            @if( in_array(strtolower(session()->get('user')['accountType']), ['admin']) )
                <li class="nav-item mb-1 {{ (getControllerName() == 'ParticipantsController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('participants.index') }}"> <i class="fa-solid fa-list"></i> Participants</a></li>
                <li class="nav-item mb-1 {{ (getControllerName() == 'UsersController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('users.index') }}"> <i class="fa-solid fa-users"></i> Users</a></li>
            @endif
            @if(in_array(strtolower(session()->get('user')['accountType']), ['admin', 'translator']) )
                <li class="nav-item mb-1 {{ (getControllerName() == 'TranslationController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('translations.index') }}"> <i class="fa-solid fa-language"></i> Translations</a></li>
            @endif
        </ul>
    </div>
</div>