<?php 
session_start();
if(!empty($_SESSION['privilege']))
{
  echo "<script language=javascript>
              parent.location.href='index.php';
        </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="fav.ico" type="image/png">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Si Border - Welcome!</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet"
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <style>
    body{padding-top:120px}
    footer{
      margin:5em 0
      }
    footer li{
      float:left;
      margin-right:1.5em;
      margin-bottom:1.5em
      }
    footer p{
      clear:left;
      margin-bottom:0
      }

    .vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
    } 
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<div class="container">

<form name="form1" method="POST" action="auth.php">
<div class="row">
<div class="col-lg-8 col-lg-offset-2">  
<div class="panel panel-danger">
  <div class="panel-body">
  <div class="row">

  <div class="col-md-7">
    <div class="form-group"><br /><br />
    <p align="center"><img src="img/logo.png" width="300" class="img img-responsive"></p>
    </div>
  </div>

  <div class="col-md-5">
  <h4><i class="fa fa-lock"></i> LOGIN</h4>  
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon input-sm"><i class="fa fa-user"></i></span>
        <input type="text" name="username" id="username" class="form-control input-sm" placeholder="NIK / USERNAME">
      </div>
    </div>
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon input-sm"><i class="fa fa-key"></i></span>
        <input type="password" name="password" id="password" class="form-control input-sm" placeholder="PASSWORD">
      </div>
    </div>
    <div class="form-group">
    <input type="submit" class="btn btn-sm btn-block btn-danger" value="LOGIN">
    </div>
  </div>

  </div>
</div>
</div>
</div> 
</div>
</form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>  

    <!-- Load jQuery Validator -->
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/additional-methods.min.js"></script>

    <script>
$('form').validate({
        rules: {
            username:{
                required: true
            },
            password:{
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
</script>
</body>
</html>