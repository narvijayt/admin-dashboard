<div class="sidebar-nav sidebar-dark px-3">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link px-3">
        <span class="brand-text font-weight-light"><b> {{ env('APP_NAME', 'Admin Dashboard')}}</b></span>
    </a>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ (getControllerName() == 'DashboardController') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
            @if( in_array(strtolower(session()->get('accountType')), ['admin']) )
                <li class="nav-item"><a class="nav-link" href="{{ route('participants') }}">Participants</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('users') }}">Users</a></li>
            @endif
            @if(in_array(strtolower(session()->get('accountType')), ['admin', 'translator']) )
                <li class="nav-item"><a class="nav-link {{ (getControllerName() == 'TranslationController') ? 'active' : '' }}" href="{{ route('translations') }}">Translations</a></li>
            @endif
        </ul>
    </div>
</div>