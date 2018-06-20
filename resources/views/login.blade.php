<?php
/**
 * Created by PhpStorm.
 * User: DustDustin
 * Date: 28-Mar-18
 * Time: 2:48 PM
 */

?>
<html>
    <head>
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{asset('css/LoginStyle.css')}}">
        <title>kleynpark Adminpanel</title>
    </head>
    <body>

    <img class="logo-img" src="{{ asset('img/logo.png') }}"/>
      <div class="container">

          <div class="row vertical-offset-100">
              <div class="col-md-4 col-md-offset-4">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h3 class="panel-title">Please log in</h3>
                      </div>
                      <div class="panel-body">
                          <form action="/Login" method="post" accept-charset="UTF-8" role="form">
                              <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                              <fieldset>
                                  <div class="form-group">
                                      <input class="form-control" type="Text" name="username" placeholder="Username..." />
                                  </div>
                                  <div class="form-group">
                                      <input class="form-control" type="password" name="password" placeholder="Password..." />
                                  </div>
                                  <button type="submit" value="Login" class="btn btn-kleynorange">login</button>
                              </fieldset>
                          </form>
                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  @foreach ($errors->all() as $error)
                                      {{ $error }}<br>
                                  @endforeach
                              </div>
                          @endif

                          @if(session()->has('message'))
                              <p class="alert alert-info">{{ session()->get('message') }}</p>
                          @endif
                      </div>
                      <div class="panel-footer">
                            <p>   <strong>Copyright &copy; 2018 Dustin van Hal.</strong> All rights reserved.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </body>
</html>