<?php
session_start();
include_once "admin/adm/conexao/conexao.php";
include_once "functions/cookies.php";
include_once "head.php";

// se não estiver logado, volta
if(!isset($_SESSION['loggedAdmin']['token'])){
	if (!isset($_COOKIE['uidck']) || $_COOKIE['uidck'] == 0) {
        header("location: login.php");
        die;
    } else {
		$token = json_decode(decryptCookieContent($_COOKIE['uidck']), true);
        $_SESSION['loggedAdmin']['token'] = $token;
        $_SESSION['loggedAdmin']['me'] 	  = HTTPRequester::HTTPMeLaravelApi($token, API_URL);
    }
}else{
    //session exists, check if cookie exists
    if (!isset($_COOKIE['uidck'])) {
        $resuJson = json_encode($_SESSION['loggedAdmin']['token']);
        setcookie('uidck',  encryptCookieContent($resuJson), time() + (60 * 10080), "/");
    }
}

?>




<body class="bg-white" >

    <!-- splash -->
    <div class="loader-screen" id="splashscreen">
        <div class="main-screen">
            <!-- <div class="circle-1">                
                <img src="assets/images/food1.png" alt="food-image">
            </div> -->
            <div class="circle-2"></div>
            <div class="circle-3"></div>
            <div class="circle-4"></div>
            <div class="circle-5"></div>
            <div class="circle-6"></div>
            <!-- <div class="circle-7">
                <img src="assets/images/food2.png" alt="food-image">
            </div> -->
            <div class="brand-logo">
                <div class="logo">
                    
                    
                </div>
                <h1 class="brand-title text-white mt-3">Ciclo Keto</h1>
            </div>
        </div>
    </div>
    <!-- splash-->

    <div class="page-wraper">

        <!-- Page Content -->
        <div class="page-content page page-onboading" >
            <!-- Onboading Start -->
       
            <div class="started-swiper-box">
            <!-- <img src="keto.png" style="width:100px;height:400px;position:absolute;margin-top:80px"/> -->
                <div class="swiper-container get-started">
           
                    <div class="swiper-wrapper">
                    <div class="dz-media">
                                    <!-- <img src="1.png" alt="image" style="width:750px;margin-left:380px;" /> -->
                                </div>
                        <div class="swiper-slide">
                            <div class="slide-info">
                              
                            </div>
                        </div>
                        <div class="slide-content" style="text-align: center;">
                    <h1 class="brand-title" style="color:#CE0125" >CicloKeto</h1>
                    <p style="color:#CE0125">Eat Right For The Healthy Life</p>
                </div>
                        <div class="swiper-slide">
                        <div class="slide-info">
                            <div class="dz-media">
                                <img src="assets/images/product/on.jpg" style=" height: 601px; width: 600px;" alt="image"/>
                            </div>
                        </div>
                    </div>
                       
                    </div>
                </div>
                
                
            </div>
            <!-- Onboading End-->
        </div>
        <!-- Page Content End-->

        <!-- Footer -->
        <footer class="footer border-0" style="background-color:#FFDBAE;">
            <div class="container" style="background-color:#FFDBAE;" >
                <a href="index.php" style="background-color:#CE0125;" class="btn btn-primary btn-rounded d-block">LET'S ROCK</a>
            </div>
        </footer>
        <!-- Footer End-->
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dz.carousel.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/wow/dist/wow.min.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        new WOW().init();

        var wow = new WOW(
            {
                boxClass: 'wow',            // animated element css class (default is wow)
                animateClass: 'animated',   // animation css class (default is animated)
                offset: 50,                 // distance to the element when triggering the animation (default is 0)
                mobile: false               // trigger animations on mobile devices (true is default)
            });
        wow.init();	
    </script>
</body>

</html>