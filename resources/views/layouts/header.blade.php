<div class="header">
    <div class="header-left">
        <a href="{{route('home')}}" class="logo">
            <img src="{{$logoPath}}" width="35" height="35" alt="" style='border-radius: 50%'> <span>{{$clinicName}}</span>
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
    @if (Auth::check())
    <ul class="nav user-menu float-right">
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span
                    class="badge badge-pill bg-danger float-right">3</span></a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>

            </div>
        </li>
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i
                    class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
        </li>

        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    @php
            // تأكد من استرجاع الصورة بشكل صحيح
            $image_path = auth()->user()->image
                ? asset('storage/' . auth()->user()->image->image_path)
                : asset('assets/img/user.jpg');
            @endphp
            <img width="60" height="40" src="{{ $image_path }}" class="rounded-circle" alt="">
                <span>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span>
            </a>
            <div class="dropdown-menu">
                @if(auth()->user()->hasRole('doctor') || auth()->user()->hasRole('employee'))
                <a class="dropdown-item" href="{{ route('employees.show', auth()->user()->employee->id) }}">My Profile</a>
                <a class="dropdown-item" href="{{ route('employees.edit', auth()->user()->employee->id) }}">Edit Profile</a>
                @endif

                @if(auth()->user()->hasRole('admin'))
                <a class="dropdown-item" href="settings.html">Settings</a>
                @endif
                {{-- add logout route              --}}
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </li>
    </ul>
    @endif
    <div class="dropdown mobile-user-menu float-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            @if(auth()->user()->hasRole('doctor') || auth()->user()->hasRole('employee'))
            <a class="dropdown-item" href="{{ route('employees.show', auth()->user()->id) }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('employees.edit', auth()->user()->id) }}">Edit Profile</a>
            @endif

            @if(auth()->user()->hasRole('admin'))
            <a class="dropdown-item" href="{{route('clinic.show')}}">Settings</a>
            @endif
            <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout
                </a>
        </div>
    </div>
</div>
