<?php include "head.php"?>
  <!-- Body Start -->
  <body>
    <!-- Header Start -->
    <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Add Payment Method</h1>
      </div>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main class="main-wrap payment-page mb-xxl">
      <button class="d-block btn-outline-grey" data-bs-toggle="offcanvas" data-bs-target="#add-card" aria-controls="add-card">+ Add New Card</button>

      <!-- Payment Section Start -->
      <section class="payment-section">
        <!-- Payment Method Accordian Start -->
        <div class="accordion" id="accordionExample">
          <!-- Accordion Start -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button font-md title-color" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Select Card
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <ul class="filter-row">
                  <li class="filter-col active">
                    <img class="payment-card" src="assets/icons/png/mastercard1.png" alt="card" /> 9800 XXXX XXXX 0545<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
                  </li>

                  <li class="filter-col">
                    <img class="payment-card" src="assets/icons/png/visacard.png" alt="card" />6580 XXXX XXXX 2562<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
                  </li>

                  <li class="filter-col">
                    <img class="payment-card discovery" src="assets/icons/png/discover.png" alt="card" /> <img class="payment-card discovery-w" src="assets/icons/png/discover-w.png" alt="card" />5125
                    XXXX XXXX 6262<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Accordion End -->

          <!-- Accordion Start -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button font-md title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Net Banking
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body net-banking">
                <div class="row">
                  <!-- Net Banking Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="c-bank" value="option1" checked="" />
                    <label class="form-check-label" for="c-bank">Industrial & Commercial Bank </label>
                  </div>
                  <!-- Net Banking Option End -->

                  <!-- Net Banking Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="con-bank" value="option1" />
                    <label class="form-check-label" for="con-bank">Construction Bank Corp.</label>
                  </div>
                  <!-- Net Banking Option End -->

                  <!-- Net Banking Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="agr-bank" value="option1" />
                    <label class="form-check-label" for="agr-bank"> Agricultural Bank</label>
                  </div>
                  <!-- Net Banking Option End -->

                  <!-- Net Banking Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="hsbc-bank" value="option1" />
                    <label class="form-check-label" for="hsbc-bank"> HSBC Holdings </label>
                  </div>
                  <!-- Net Banking Option End -->

                  <!-- Net Banking Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="a-bank" value="option1" />
                    <label class="form-check-label" for="a-bank">Bank of America</label>
                  </div>
                  <!-- Net Banking Option End -->

                  <!-- Net Banking Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="jpm-moro" value="option1" />
                    <label class="form-check-label" for="jpm-moro">JPMorgan Chase & Co.</label>
                  </div>
                  <!-- Net Banking Option End -->
                </div>
              </div>
            </div>
          </div>
          <!-- Accordion End -->

          <!-- Accordion Start -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button
                class="accordion-button font-md title-color collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseThree"
                aria-expanded="false"
                aria-controls="collapseThree"
              >
                Wallet/UPI
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="row">
                  <!-- Wallet Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="adyen" value="option1" checked="" />
                    <label class="form-check-label" for="adyen">Adyen </label>
                  </div>
                  <!-- Wallet Option End -->

                  <!-- Wallet Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="airtel-money" value="option1" />
                    <label class="form-check-label" for="airtel-money"> Airtel Money</label>
                  </div>
                  <!-- Wallet Option End -->

                  <!-- Wallet Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="alliedWallet" value="option1" />
                    <label class="form-check-label" for="alliedWallet"> AlliedWallet </label>
                  </div>
                  <!-- Wallet Option End -->

                  <!-- Wallet Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="apple-Pay" value="option1" />
                    <label class="form-check-label" for="apple-Pay"> Apple Pay </label>
                  </div>
                  <!-- Wallet Option End -->

                  <!-- Wallet Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="brinks" value="option1" />
                    <label class="form-check-label" for="brinks"> Brinks </label>
                  </div>
                  <!-- Wallet Option End -->

                  <!-- Wallet Option Start -->
                  <div class="input-box col-6">
                    <input type="radio" name="radio1" id="cardFree" value="option1" />
                    <label class="form-check-label" for="cardFree">CardFree</label>
                  </div>
                  <!-- Wallet Option End -->
                </div>
              </div>
            </div>
          </div>
          <!-- Accordion End -->

          <!-- Accordion Start -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingfour">
              <button class="accordion-button font-md title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                Cash on Delivery
              </button>
            </h2>
            <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
              <div class="accordion-body cash">
                <ul class="filter-row">
                  <li class="filter-col active">
                    Cash on Delivery<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Accordion End -->
        </div>
        <!-- Payment Method Accordian End -->
      </section>
      <!-- Payment Section End -->

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
            <a href="offer.php" class="font-danger">Apply Coupon</a>
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
      <a href="order-success.php" class="font-md">Confirm Payment</a>
    </footer>
    <!-- Footer End -->

    <!-- Add New Card OffCanvas Start -->
    <div class="offcanvas add-card offcanvas-bottom" tabindex="-1" id="add-card" aria-labelledby="add-card">
      <div class="offcanvas-header">
        <h5 class="title-color font-md fw-600">Add Card</h5>
      </div>

      <div class="offcanvas-body small">
        <form class="custom-form">
          <div class="input-box">
            <input type="text" placeholder="Card Holder Name" class="form-control" />
            <input type="number" placeholder="Card Number " class="form-control" />
          </div>

          <div class="row">
            <div class="col-6">
              <div class="input-box mb-0">
                <i class="iconly-Calendar icli"></i>
                <input class="datepicker-here form-control digits expriydate" type="text" data-language="en" data-multiple-dates-separator=", " placeholder="Expiry Date" />
              </div>
            </div>
            <div class="col-6">
              <div class="input-box mb-0">
                <input type="number" placeholder="CV" class="form-control" />
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="offcanvas-footer">
        <div class="btn-box">
          <button class="btn-outline font-md" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
          <button class="btn-solid font-md" data-bs-dismiss="offcanvas" aria-label="Close">Add</button>
        </div>
      </div>
    </div>
    <!-- Add New Card OffCanvas Start -->

    <!-- jquery 3.6.0 -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <?php include "footer-main.php"?>

    </html>
<!-- Html End -->
