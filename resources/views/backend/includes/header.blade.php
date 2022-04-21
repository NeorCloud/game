<header class="c-header c-header-light c-header-fixed">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show">
        <i class="c-icon c-icon-lg cil-menu"></i>
    </button>

    <a class="c-header-brand d-lg-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#full') }}"></use>
        </svg>
    </a>

    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true">
        <i class="c-icon c-icon-lg cil-menu"></i>
    </button>

    <ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3">
            <a class="c-header-nav-link" href="{{ route('admin.dashboard') }}">@lang('Home')</a>
        </li>
    </ul>

    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown">
            <x-utils.link class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                          aria-expanded="false">
                <x-slot name="text">
                    <div class="c-avatar">
                        <img class="c-avatar-img" src="{{ $logged_in_user->avatar }}"
                             alt="{{ $logged_in_user->email ?? '' }}">
                    </div>
                    <span class="d-md-down-none mr-2">{{ $logged_in_user->name }}</span>
                </x-slot>
            </x-utils.link>
            <div class="dropdown-menu dropdown-menu-right pt-0 pb-0">
                @can('admin.access.files')
                    <div class="dropdown-header bg-light py-2 text-center border-bottom">
                        <strong>@lang('Administration')</strong>
                    </div>
                @endcan
                @can('admin.access.backups')
                    <a class="dropdown-item" href="{{ route('admin.backups.index') }}">
                        <i class="fas fa-database"></i> &nbsp;&nbsp;@lang('Databases')
                    </a>
                @endcan
                @can('admin.access.files')
                    <a class="dropdown-item d-md-none" href="{{ route('admin.files.index') }}">
                        <i class="fas fa-folder"></i> &nbsp;&nbsp;@lang('Files Index')
                    </a>
                @endcan
                <div class="dropdown-header bg-light py-2 text-center">
                    <strong>@lang('Account')</strong>
                </div>
                <a class="dropdown-item" href="{{ route('admin.auth.user.show',$logged_in_user->id) }}">
                    <i class="fas fa-eye"></i> &nbsp;&nbsp;@lang('User Information')
                </a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.change-password',$logged_in_user->id) }}">
                    <i class="fas fa-key"></i> &nbsp;&nbsp;@lang('Change Password')
                </a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.edit',$logged_in_user->id) }}">
                    <i class="fas fa-user-alt"></i> &nbsp;&nbsp;@lang('Update')
                </a>
                <x-utils.link class="dropdown-item" icon="c-icon cil-account-logout"
                              onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <x-slot name="text">
                        &nbsp;&nbsp;@lang('Logout')
                        <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none"/>
                    </x-slot>
                </x-utils.link>
            </div>
        </li>

        @can('admin.access.files')
            <li class="c-header-nav-item px-3 d-md-down-none">
                <a class="c-header-nav-link" href="{{ route('admin.files.index') }}">
                    <i class="fas fa-folder"></i>
                </a>
            </li>
        @endcan
    </ul>

    <div class="c-subheader justify-content-between px-3">
        @include('backend.includes.partials.breadcrumbs')

        <div class="c-subheader-nav mfe-2">
            @yield('breadcrumb-links')
        </div>
    </div><!--c-subheader-->
</header>
