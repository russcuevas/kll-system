<!DOCTYPE html>
<html>

<head>
    <title>KLL - Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/kll-logo.jpg" />
    <!-- Bootstrap -->
    <link href="auth/css/bootstrap.min.css" rel="stylesheet">
    <!-- end of bootstrap -->
    <!--page level css -->
    <link type="text/css" href="vendors/themify/css/themify-icons.css" rel="stylesheet" />
    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
    <link href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" />
    <link href="auth/css/login.css?v=2" rel="stylesheet">
    <link href="auth/css/app/evsu-theme.css?v=1" rel="stylesheet">
    <link rel="stylesheet" href="auth/css/responsive.css">

    <!-- Sweetalert Css -->
    <link href="auth/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <!--end page level css-->
</head>

<body id="sign-in">

    <div class="preloader">
        <div class="loader_img"><img src="assets/images/kll-logo.jpg" alt="loading..." height="64" width="64"></div>
    </div>

    <div class="flex-container">
        <div class="container">
            <div class="row row-inner-container">
                <div class="col-md-12">
                    <div class="row my-form-row">
                        <div class="col-md-6 my-col">
                            <div class="logo-container">
                                <img class="img-logo" src="assets/images/homepage-kll-logo.png">
                            </div>
                        </div>
                        <div class="col-md-6 my-col">
                            <div class="my-form-container">

                                <div class="my-form-inner-container">
                                    <div class="panel-header">
                                        <h2 class="text-center">
                                            KLL COURSE PATH
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-xs-12">
                                                <h3 style="font-weight: bold;margin-bottom: 20px;">ADMIN LOGIN</h3>
                                                <form id="loginForm" class="loginForm" method="post" class="">
                                                    <div class="form-group">
                                                        <label for="email" class="sr-only"> Email</label>
                                                        <input type="email" class="form-control  form-control-lg input-lg" id="student_id" name="email" placeholder="Email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password" class="sr-only">Password</label>
                                                        <input type="password" class="form-control form-control-lg input-lg" id="password" name="password" placeholder="Password">
                                                    </div>

                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-block btn-lg" type="submit">Login</button>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </form>
                                            </div>
                                            <div class="col-xs-12">
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p style="margin: 10px 0px"><a href="../index.php" style="color: white !important; font-weight: 900;"><small>&larr; Back to Homepage</small></a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="auth/js/jquery.min.js" type="text/javascript"></script>
    <script src="auth/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="auth/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="ajax-auth/login.js"></script>
    <!-- end of global js -->
    <!-- page level js -->
    <script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>
    <script src="vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="auth/js/custom_js/login.js?v=3"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-182226591-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-182226591-1');
    </script>
</body>

</html>