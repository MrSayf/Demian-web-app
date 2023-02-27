<?php include "head.php"?>

  <!-- Body Start -->
  <body>
    <!-- Header Start -->
    <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Add Address</h1>
      </div>
    </header>
    <!-- Header End -->
    <!-- Skeleton loader Start -->
    <div class="skeleton-loader">
      

      <!--Main Start -->
      <div class="main-wrap address1-page mb-xxl">
        <!-- Map Start -->
        <div class="map-section"></div>
        <!-- Map End -->

        <!-- Location Section Start -->
        <div class="location-section">
          <!-- Search Box Start -->
          <div class="search-box">
            <input class="form-control" disabled type="search" />
          </div>
          <!-- Search Box End -->

          <div class="current-box">
            <div class="media">
              <span><i data-feather="send"></i></span>
              <div class="media-body"><h2 class="font-md title-color">Use current location</h2></div>
            </div>

            <div class="location">
              <div class="location-box">
                <h3 class="title-color font-sm">
                  <span class="img d-block"></span>
                </h3>
                <p class="content-color font-sm">8857 Morris Rd. ,Charlottesville, VA 22901</p>
              </div>

              <div class="location-box">
                <h3 class="title-color font-sm"><span class="img d-block"></span></h3>
                <p class="content-color font-sm">8857 Morris Rd. ,Charlottesville, VA 22901</p>
              </div>
            </div>
          </div>
          <a href="address2.php" class="btn-solid"><span></span></a>
        </div>
        <!-- Location Section End -->
      </div>
      <!--Main End -->
    </div>
    <!-- Skeleton loader End -->

    

    
    <!-- Main Start -->
    <main class="main-wrap address1-page">
      <!-- Map Start -->

      <div class="map-wrap">
        <div class="top-address">
          <i data-feather="truck"> </i>
          <p>Delivery on 7th Aug, Slot: 7am to 9am</p>
        </div>
        <div class="map-section" id="map"></div>
        <span class="navgator"><i data-feather="crosshair"></i></span>
      </div>
      <!-- Map End -->
      
      <!-- Location Section Start -->
      <section class="location-section">
        <!-- Search Box Start -->
        <div class="search-box">
          <i class="iconly-Search icli search"></i>
          <input class="form-control" type="search" placeholder="How Can We Help..." />
          <i class="iconly-Voice icli mic"></i>
        </div>
        <!-- Search Box End -->

        <div class="current-box">
          <div class="media">
            <span><i data-feather="send"></i></span>
            <div class="media-body"><h2 class="font-md title-color">Use current location</h2></div>
          </div>

          <div class="location">
            <div class="location-box">
              <h3 class="title-color font-sm"><i class="iconly-Location icli"></i>Noah Hamilton</h3>
              <p class="content-color font-sm">8857 Morris Rd. ,Charlottesville, VA 22901</p>
            </div>

            <div class="location-box">
              <h3 class="title-color font-sm"><i class="iconly-Location icli"></i>Noah Hamilton</h3>
              <p class="content-color font-sm">8857 Morris Rd. ,Charlottesville, VA 22901</p>
            </div>
          </div>
        </div>
        <a href="payment.php" class="btn-solid">Confirm location & proceed</a>
      </section>
      <!-- Location Section End -->
    </main>
    <!-- Main End -->

    <?php include "footer-main.php"?>

<!-- Mirrored from themes.pixelstrap.com/fastkart-app/address1.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 18 Feb 2023 10:53:38 GMT -->
</html>
<!-- Html End -->
