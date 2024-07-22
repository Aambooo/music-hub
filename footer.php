<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <!-- Your CSS styles -->
    <style>
        .footer__container {
            background-color: #000; 
            padding: 20px 0; 
        }

        .footer h2.title__line--2 {
            color: #fff; 
            margin-bottom: 20px; 
        }

        .ft__details p, .ft__contact p {
            color: #ccc; 
        }

        .ft__social__link ul.social__link {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .ft__social__link ul.social__link li {
            display: inline-block;
            margin-right: 10px;
        }

        .ft__social__link ul.social__link li a {
            color: #fff; 
            font-size: 25px; 
        }

        .footer .col-md-4 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .news__input input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .send__btn a.fr__btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e91e63; 
            color: #fff; 
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .htc__copyright {
            background-color: #333; 
            padding: 10px 0; 
            text-align: center;
        }

        .htc__copyright p {
            color: #fff; 
            margin: 0;
        }
    </style>
</head>
<body>
    <footer id="htc__footer">
        <div class="footer__container bg__cat--1">
            <div class="container">
                <div class="row">
                    <!-- ABOUT US Section -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="footer">
                            <h2 class="title__line--2">ABOUT US</h2>
                            <div class="ft__details">
                                <p>Whether you're a professional musician, a student, or a hobbyist, MusicGhar offers an extensive selection of instruments to meet your needs. With a user-friendly interface, secure checkout, and excellent customer service, MusicGhar aims to be your go-to destination for all things musical. Explore our collection and find the perfect instrument to inspire your musical journey.</p>
                            </div>
                        </div>
                    </div>
                    <!-- CONNECT WITH US Section -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="footer">
                            <h2 class="title__line--2">CONNECT WITH US</h2>
                            <div class="ft__social__link">
                                <ul class="social__link">
                                    <li><a href="https://www.instagram.com/"><i class="icon-social-instagram icons"></i></a></li>
                                    <li><a href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2F"><i class="icon-social-facebook icons"></i></a></li>
                                    <li><a href="https://www.google.com/"><i class="icon-social-google icons"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- ADDRESS AND CONTACT DETAILS Section -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="footer">
                            <h2 class="title__line--2">ADDRESS & CONTACT DETAILS</h2>
                            <div class="ft__contact">
                                <p>Putalisadak, Kathmandu</p>
                                <p>Contact Number: 01-1234567</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="htc__copyright bg__cat--5">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="copyright__inner">
                            <p>Copyright© <a href="http://localhost/php/ecommerce/index.php">2024 MusicGhar</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.imgzoom.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
