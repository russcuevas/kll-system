<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KLL - Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/kll-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/homepage.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
    <style>
        .nav-link.active {
            color: #FEC653 !important;
        }

        .slick-container img {
            width: 100%;
            height: auto;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #7D0A0A;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .logo-preloader {
            border-radius: 50px !important;

            width: 100px;
            animation: tibok 1s infinite;
        }

        @keyframes tibok {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.2);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .pagination .page-item.active .page-link {
            background-color: #7D0A0A !important;
            border-color: #7D0A0A !important;
            color: #fff !important;
        }

        .pagination .page-link {
            color: #7D0A0A;
        }

        .pagination .page-link:hover {
            background-color: #FEC653;
            color: #7D0A0A;
        }
    </style>
</head>

<body>

    <div id="preloader">
        <img class="logo-preloader" src="assets/images/kll-logo.jpg" alt="UB Logo" class="logo">
    </div>


    <nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img style="height: 60px" src="assets/images/kll-logo.jpg" alt="UB Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="admin/admin_login.php">Admin Login</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Examiners Login</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    <header>
        <h1>
            FUTURE: Facilitating University Track <br> Understanding and Recommendation Engine
        </h1>
        <p></p>
    </header>

    <div class="container">
        <h3 class="mt-5">OFFERED COURSE</h3>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                <div class="course-card d-flex flex-column">
                    <div class="slick-container">
                        <img style="height: 300px" src="https://images.ctfassets.net/wp1lcwdav1p1/7JwZNrzXiFWPAkdcenHTRN/debb648bfa04176d87ae8702bf6607f8/GettyImages-1280720394.jpg?w=1500&h=680&q=60&fit=fill&f=faces&fm=jpg&fl=progressive" alt="">
                    </div>
                    <h2>Bachelor of Science in Computer Science</h2>
                    <p>A bachelor's degree in computer science is a four-year undergraduate program that covers both theoretical and practical aspects of designing, developing, and testing software.</p>
                    <div class="mt-auto">
                        <a href="" class="btn btn-primary learn-btn">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                <div class="course-card d-flex flex-column">
                    <div class="slick-container">
                        <img style="height: 300px" src="https://evlumogdang23.wordpress.com/wp-content/uploads/2013/02/0.jpeg" alt="">
                    </div>
                    <h2>Bachelor of Science in Criminology</h2>
                    <p>BSCRIM stands for Bachelor of Science in Criminology. It's a degree program that focuses on the study of crime, criminal behavior, and the justice system.</p>
                    <div class="mt-auto">
                        <a href="" class="btn btn-primary learn-btn">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                <div class="course-card d-flex flex-column">
                    <div class="slick-container">
                        <img style="height: 300px" src="https://149747948.v2.pressablecdn.com/wp-content/uploads/GPS_Blog-BSN-BS.jpg" alt="">
                    </div>
                    <h2>Bachelor of Science in Nursing</h2>
                    <p>Bachelor of Science in Nursing (BSN) is a four-year program consisting of general education, major and professional nursing courses.</p>
                    <div class="mt-auto">
                        <a href="" class="btn btn-primary learn-btn">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.slick-container').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: true,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 2000,
                adaptiveHeight: true
            });
        });
    </script>
    <script>
        setTimeout(function() {
            document.getElementById('preloader').style.display = 'none';
        }, 1500);
    </script>
</body>

</html>