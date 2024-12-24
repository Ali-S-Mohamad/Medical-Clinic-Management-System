<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
   
   
@include('layouts.head')

  
		<script src="{{ asset('assets/js/html5shiv.min.js')}}"></script>
		<script src="{{ asset('assets/js/respond.min.js')}}"></script>

</head>

<body>
    <div class="main-wrapper">
       
        @include('layouts.header')

        @include('layouts.sidbar')

        <div class="page-wrapper">
           
            @yield('content')
            
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
   
    @include('layouts.foot_scr')

</body>



</html>