<?php
/**
 * Created by PhpStorm.
 * User: DustDustin
 * Date: 27-Mar-18
 * Time: 12:59 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kleynpark - Adminpanel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/Style.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/datatables.net/css/datatables.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>K</b>G</span>
            <!-- logo for regular state and mobile devices -->
            <img class="logo-img logo-lg" src="{{ asset('img/logo.png') }}"/>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><i class="fa fa-user"></i>{{session()->get('username')}}<i class="fa fa-caret-down"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                </div>
                                <div class="pull-right">
                                    <a href="logout" class="btn btn-kleynorange btn-flat">log out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">	NAVIGATION BAR</li>
                <li><a href="#"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                <li><a href="users"><i class="fa fa-user"></i> <span>Users</span></a></li>
                <li><a href="roles"><i class="fa fa-users"></i> <span>Roles</span></a></li>
                <li><a href="#"><i class="fa fa-search"></i> <span>User Logs</span></a></li>
                <li class="aapjebutton"><a href="#"><i class="aapje"><img class="aapje-img" src="img/aapje1.png"/> </i> <span>API Connections</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				<?php echo $title; ?>
                <small><?php echo $small;?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield("content")
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2018 Dustin van Hal.</strong> All rights reserved.
</footer>

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<!--Datatables -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript">
    $('.aapjebutton').hover(function(){
        $('.aapje-img').attr("src","img/aapje2.png");
    }, function(){
        $('.aapje-img').attr("src","img/aapje1.png");
    });
</script>


<script type="text/javascript">
    // Modals for User page
        $('#DeleteEmployee').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var employee = button.data('employee');
            var employeerole = button.data('employeerole');
            // console.log(char);
            $('#EmployeeTxt').html(employee);
            $('#employee').val(employee);
            $('#employeerole').val(employeerole);
        });

        $('#FreezeUser').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userid = button.data('userid');
            var userrole = button.data('userrole');
            var userstate = button.data('userstate');
            var warn = button.data('warn');
            // console.log(char);
            $('#userid1').val(userid);
            $('#userstate').val(userstate);
            $('#userrole').val(userrole);
            $('#warn1').html(warn);
            $('#warn2').html(warn);
            $('#warn3').html(warn);
            $('#warn4').html(warn);
        });

        $('#EditUser').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userid = button.data('userid');
            var userrole = button.data('userrole');
            var usermail = button.data('usermail');
            var username = button.data('username');
            var rolename = button.data('userrolename');
            // console.log(char);
            $('#usernametxt').html(username);
            $('#userid').val(userid);
            $('#userrole1').val(userrole);
            $('#userrole2').val(userrole);
            $('#userrole2').html('Current Role: ' + rolename);
            $('#username').val(username);
            $('#usermail').val(usermail);
            $('#rolename1').html(rolename);
        });
    //Modals for Roles page
        $('#DeleteRole').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var role = button.data('roleid');
            var counts = button.data('counted');
            // console.log(char);
            $('#counter').html(counts);
            $('#roleid').val(role);
        });

    $('#RoleEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var roleInput = button.data('rolenumber');
        var rolenameInput = button.data('rolename');
        console.log(roleInput);
        $('#roleidEdit').val(roleInput);
        $('#rolenameEdit').val(rolenameInput);
    });
</script>
@if($error_code == 5)

    <?php session()->put('error_code', 0); ?>
    <script>
        $(function() {
            $('#AddEmployee').modal('show');
        });
        $(function() {
            $('#AddRole').modal('show');
        });
    </script>
@elseif($error_code ==4)
	<?php session()->put('error_code', 0); ?>
    <script>
        $(function() {
            $('#AddGuest').modal('show');
        });
    </script>
@endif
<script>
    $('#dataatable').dataTable();
    $('#dataatable2').dataTable();
</script>
</body>
</html>

