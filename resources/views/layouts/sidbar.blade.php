<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                @hasrole('Admin')
                @if (Auth::check()  && Auth::user()->hasRole('Admin'))
                <li class="">
                    <a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                @endif
                <li class="">
                    <a href="{{route('roles.index')}}"><i class="fa fa-key"></i> <span>Roles &amp; Permissions</span></a>
                </li>
                <li class="submenu">
                    <a href="{{route('employees.index')}}"><i class="fa fa-user"></i> <span>All Employees </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="">
                            <a href="{{route('employees.index',['role' => 'doctor'])}}"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                        </li>
                        <li class="">
                            <a href="{{route('employees.index',['role' => 'employee'])}}"><i class="fa fa-user"></i> <span>Administrative Staffs</span></a>
                        </li>
                    </ul>
                </li>
                @endhasrole
                <li class="">
                    <a href="{{route('patients.index')}}"><i class="fa fa-wheelchair"></i><span>Patients</span></a>
                </li>
                <li class="">
                    <a href="{{route('departments.index')}}"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                </li>
                <li class="">
                    <a href="{{route('time-slots.index')}}"><i class="fa fa-hospital-o"></i> <span>Time Slot</span></a>
                </li>
                <li class="">
                    <a href="{{route('appointments.index')}}"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                </li>
                <li>
                    <a href="{{route('prescriptions.index')}}"><i class="fa fa-cube"></i> <span>Prescriptions</span></a>
                </li>
                <li>
                    <a href="{{route('medicalFiles.index')}}"><i class="fa fa-cube"></i> <span>Medical Files</span></a>
                </li>
                <li class="">
                    <a href="{{route('ratings.index')}}"><i class="fa fa-dashboard"></i> <span>Ratings</span></a>
                </li>
                <li class="">
                    <a href="{{route('clinic.show', ['clinic' => 1] )}}"><i class="fa fa-cogs"></i> <span>Clini Info</span></a>
                </li>
                <li class="">
                    <a href="{{route('reports.index')}}"><i class="fa fa-dashboard"></i> <span>Reports</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
