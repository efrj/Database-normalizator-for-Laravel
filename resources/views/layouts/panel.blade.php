<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title') - Database normalizer</title>

<!-- BOOTSTRAP STYLES-->
<link href="{{ URL::asset('assets/css/bootstrap.css') }}" rel="stylesheet" />

<!-- FONTAWESOME STYLES-->
<link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />

<!-- CUSTOM STYLES-->
<link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet" />

<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

@yield('css')

</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Database normalizer</a> 
        </div>
        <div class="btn-logout" style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"> {{-- Last access : 16 Apr 2017 --}} &nbsp;
            <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="subit" class="btn btn-danger">Logout <span class="fa fa-user-times"></span></button>
            </form>
        </div>
    </nav>

    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-2x"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ url('/tables') }}"><i class="fa fa-table fa-2x"></i> Tables</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-gears fa-2x"></i> Code Generator<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">Migrations</a>
                        </li>
                        <li>
                            <a href="#">Seeds</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('/tables') }}"><i class="fa fa-microchip fa-2x"></i> Configurations</a>
                </li>
                <li>
                    <a href="{{ url('/help') }}"><i class="fa fa-support fa-2x"></i> Help</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" >
        <div id="page-inner">
            {{-- @include('flash::message') --}}
            @yield('content')
        </div>
    </div>
</div>

<!-- JQUERY SCRIPTS -->
<script src="{{ URL::asset('assets/js/jquery-1.10.2.js') }}"></script>

<!-- BOOTSTRAP SCRIPTS -->
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>

<!-- METISMENU SCRIPTS -->
<script src="{{ URL::asset('assets/js/jquery.metisMenu.js') }}"></script>
<!-- CUSTOM SCRIPTS -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script>

@yield('script')

</body>
</html>
