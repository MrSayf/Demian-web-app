<?php include "head.php"?>

  <!-- Body Start -->
  <body>
    <!-- Header Start -->
    <header class="header">
      <div class="logo-wrap">
        <i class="iconly-Category icli nav-bar"></i>
       
      </div>
      <div class="avatar-wrap">
        <a href="index.php">
          <i class="iconly-Home icli"></i>
        </a>
      </div>
    </header>
    <!-- Header End -->
    <!-- Skeleton loader Start -->
    <div class="skeleton-loader">
      

      <!-- Main Start -->
      <div class="main-wrap order-success-page mb-xxl">
        <!-- Banner Section Start -->
        <div class="banner-section section-p-tb">
          <div class="banner-wrap">
            <img src="assets/svg/order-success.svg" alt="order-success" />
          </div>
          <div class="content-wrap">
            <div class="heading"></div>
            <p class="font-sm content-color sk-1"></p>
            <p class="font-sm content-color sk-2"></p>
          </div>
        </div>
        <!-- Banner Section End -->

        <!-- Order Id Section Start -->
        <div class="order-id-section section-p-tb">
          <div class="media">
            <span><i class="iconly-Calendar icli"></i></span>
            <div class="media-body">
              <h2 class="font-sm color-title">Order Date</h2>
              <span class="content-color">Sun, 14 Apr, 19:12</span>
            </div>
          </div>
          <div class="media">
            <span><i class="iconly-Document icli"></i></span>
            <div class="media-body">
              <h2 class="font-sm color-title">Order ID</h2>
              <span class="content-color">#548475151</span>
            </div>
          </div>
        </div>
        <!-- Order Id Section End -->

        <!-- Order Detail Start -->
        <div class="order-detail">
          <h3 class="title-2">Order Summary:</h3>
          <!-- Product Detail  Start -->
          <ul>
            <li>
              <span>Bag total</span>
              <span>$220.00</span>
            </li>

            <li>
              <span>Bag savings</span>
              <span class="font-theme">-$20.00</span>
            </li>

            <li>
              <span>Coupon Discount</span>
              <span> <a href="offer.html" class="font-danger">Apply Coupon</a></span>
            </li>

            <li>
              <span>Delivery</span>
              <span>$50.00</span>
            </li>
            <li>
              <span>Total Amount</span>
              <span>$270.00</span>
            </li>
          </ul>
          <!-- Product Detail  End -->
        </div>
        <!-- Order Detail End -->
      </div>
      <!-- Main End -->
    </div>
    <!-- Skeleton loader End -->

    

    <!-- Sidebar Start -->
    <a href="javascript:void(0)" class="overlay-sidebar"></a>
    <aside class="header-sidebar">
      <div class="wrap">
        <div class="user-panel">
          <div class="media">
            <a href="account.html"> <img src="assets/images/avatar/avatar.jpg" alt="avatar" /></a>
            <div class="media-body">
              <a href="account.html" class="title-color font-sm"
                >Andrea Joanne
                <span class="content-color font-xs">andreajoanne@gmail.com</span>
              </a>
            </div>
          </div>
        </div>

        <?php include "sidebar.php"?>
      </div>

      <div class="contact-us">
        <span class="title-color">Contact Support</span>
        <p class="content-color font-xs">If you have any problem,queries or questions feel free to reach out</p>
        <a href="javascript:void(0)" class="btn-solid"> Contact Us </a>
      </div>
    </aside>
    <!-- Sidebar End -->

    <!-- Main Start -->
    <main class="main-wrap order-success-page mb-xxl">
      <!-- Banner Section Start -->
      <section class="banner-section">
        <div class="banner-wrap">
          <img src="assets/svg/order-success.svg" alt="order-success" />
        </div>

        <div class="content-wrap">
          <h1 class="font-lg title-color">Thank you for your order!</h1>
          <p class="font-sm content-color">your order has been placed successfully. your order ID is #548475151</p>
        </div>
      </section>
      <!-- Banner Section End -->

      <!-- Order Id Section Start -->
      <section class="order-id-section">
        <div class="media">
          <span><i class="iconly-Calendar icli"></i></span>
          <div class="media-body">
            <h2 class="font-sm color-title">Order Date</h2>
            <span class="content-color">Sun, 14 Apr, 19:12</span>
          </div>
        </div>

        <div class="media">
          <span><i class="iconly-Document icli"></i></span>
          <div class="media-body">
            <h2 class="font-sm color-title">Order ID</h2>
            <span class="content-color">#548475151</span>
          </div>
        </div>
      </section>
      <!-- Order Id Section End -->

      <!-- Order Detail Start -->
      <section class="order-detail">
        <h3 class="title-2">Order Details</h3>
        <!-- Product Detail  Start -->
        <ul>
          <li>
            <span>Bag total</span>
            <span>$220.00</span>
          </li>

          <li>
            <span>Bag savings</span>
            <span class="font-theme">-$20.00</span>
          </li>

          <li>
            <span>Coupon Discount</span>
            <a href="offer.index.php" class="font-danger">Apply Coupon</a>
          </li>

          <li>
            <span>Delivery</span>
            <span>$50.00</span>
          </li>

          <li>
            <span>Total Amount</span>
            <span>$270.00</span>
          </li>
        </ul>
        <!-- Product Detail  End -->
      </section>
      <!-- Order Detail End -->
    </main>
    <!-- Main End -->

    <!-- Footer Start -->
    <footer class="footer-wrap footer-button">
      <a href="order-tracking.index.php" class="font-md">Track Package on Map</a>
    </footer>
    <!-- Footer End -->
<?php include "footer-main.php"?>
    </html>
<!-- Html End -->
