<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                <li class="active">
                    <a href="index-2.html"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="active">
                    <a href="{{route('doctors.index')}}"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                </li>
                <li class="active">
                    <a href="{{route('patients.index')}}"><i class="fa fa-wheelchair"></i><span>Patients</span></a>
                </li>
                <li class="active">
                    <a href="{{route('departments.index')}}"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                </li>
                <li class="active">
                    <a href="{{route('employees.index')}}"><i class="fa fa-user-md"></i> <span>Employees</span></a>
                </li>
                <li class="active">
                    <a href="{{route('appointments.index')}}"><i class="fa fa-user-md"></i> <span>Appointments</span></a>
                </li>
                @canany(['create-role', 'edit-role', 'delete-role']) 
                <li class="active">
                    <a href="{{route('roles.index')}}"><i class="fa fa-key"></i> <span>Roles &amp; Permissions</span></a>
                </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>
