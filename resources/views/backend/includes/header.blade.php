<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    {{--    <a class="navbar-brand" href="#">--}}
    {{--        <h3 class="navbar-brand-full d-md-down-none">WodBoss</h3>--}}
    {{--        <img class="navbar-brand-full d-md-down-none" src="{{ asset('img/backend/brand/logo.svg') }}" width="89" height="25" alt="CoreUI Logo">--}}
    {{--        <img class="navbar-brand-minimized" src="{{ asset('img/backend/brand/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo">--}}
    {{--    </a>--}}
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('frontend.index') }}"><i class="fas fa-home"></i></a>
        </li>

        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">@lang('navs.frontend.dashboard')</a>
        </li>

        @if(config('locale.status') && count(config('locale.languages')) > 1)
            <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <span class="d-md-down-none">@lang('menus.language-picker.language') ({{ strtoupper(app()->getLocale()) }})</span>
                </a>

                @include('includes.partials.lang')
            </li>
        @endif
    </ul>

    @if(FeatureFlag::isActive('active_box'))
        <ul class="nav ml-md-auto">
            <li class="nav-item ">
                <form id="box_selection_form" action="{{route('admin.updateActiveBox')}}" method="POST">
                    @csrf
                    <select class="box-select show-tick" title="Active Box" data-live-search="true" data-width="fit"
                            name="active-box">
                        @foreach($logged_in_user->getAllBoxes() as $box)
                            <option data-tokens="{{$box->name}} {{$box->permissions}}"
                                    data-subtext="{{$box->permissions}}"
                                    value="{{$box->id}}"
                                {{session('active_box')->id == $box->id ? "selected" : ""}}>
                                {{$box->name}}
                            </option>
                        @endforeach
                    </select>
                    {{--                                    <submit type="hidden"></submit>--}}
                </form>
            </li>
            <li class="nav-item m-auto d-none d-sm-block">
                @if(session('active_box'))
                    <a class="nav-link" href="{{ route('admin.boxes.view', session('active_box')) }}" data-toggle="tooltip"
                       data-placement="top" title="Manage Box">
                        <i class="fas fa-tasks"></i>
                    </a>
                @endif
            </li>
        </ul>
    @endif

    <ul class="nav navbar-nav {{!FeatureFlag::isActive('active_box') ? "ml-auto" : ""}}">
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
                <i class="fas fa-bell"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <img src="{{ $logged_in_user->picture }}" class="img-avatar" alt="{{ $logged_in_user->email }}">
                <span class="d-md-down-none">{{ $logged_in_user->full_name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="{{ route('frontend.auth.logout') }}">
                    <i class="fas fa-lock"></i> @lang('navs.general.logout')
                </a>
            </div>
        </li>
    </ul>

    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
