<div class="sidebar-nav sidebar-dark px-0 box-shadow-none">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link px-3">
        <span class="brand-text font-weight-light"><b> {{ env('APP_NAME', 'Admin Dashboard')}}</b></span>
    </a>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item mb-1 active "><a class="nav-link px-3 {{ (getControllerName() == 'DashboardController') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="icon-dashboard me-2"></i> Dashboard</a></li>
            @if( in_array(strtolower(session()->get('accountType')), ['admin']) )
                <li class="nav-item mb-1"><a class="nav-link px-3" href="{{ route('participants') }}"><i class="icon-list me-2"></i>Participants</a></li>
                <li class="nav-item mb-1"><a class="nav-link px-3" href="{{ route('users') }}"><i class="icon-user me-2"></i>Users</a></li>
            @endif
            @if(in_array(strtolower(session()->get('accountType')), ['admin', 'translator']) )
                <li class="nav-item mb-1"><a class="nav-link px-3 {{ (getControllerName() == 'TranslationController') ? 'active' : '' }}" href="{{ route('translations') }}"><i class="icon-edit me-2"></i>Translations</a></li>
            @endif
        </ul>
    </div>
</div>