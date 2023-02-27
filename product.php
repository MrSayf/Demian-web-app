<?php
session_start();
include_once "head.php";
include_once "admin/adm/conexao/conexao.php";
include_once "functions/cookies.php";

/*****************************************/
/******se não estiver logado, volta*******/
/*****************************************/
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

include_once "functions/mealsFunctions.php";

// make it an array
$planoArray = array();
$planoArray = json_decode($_SESSION['loggedAdmin']['me'], true);

// favorites
$sessionMe = json_decode($_SESSION['loggedAdmin']['me'], true);

if (isset($sessionMe['favoritos']) && strlen($sessionMe['favoritos']) > 1) {
    $favoritosArray = explode(',', $sessionMe['favoritos']);
} else {
    $favoritosArray = array();
}

// fetchs recipes with ingredients already set, for each period
$receita      = HTTPRequester::HTTPGet(API_URL . "Receitas/showByIdWithIngredients/" . $_GET['id'], array("getParam" => "foobar"),$_SESSION['loggedAdmin']['token']);
$receitaArray = json_decode((string)$receita, true);
//medidas to array
$receitaMedidasArray = json_decode($receitaArray['success'][0]['medidas'], true);


// busca 10 receitas para a busca
$receitas10        = HTTPRequester::HTTPGet(API_URL . "Receitas/get/0,10", array("getParam" => "foobar"),$_SESSION['loggedAdmin']['token']);
$receitas10Array   = json_decode((string)$receitas10, true);


//  echo '<pre>';
//  print_r($planoArray);
// die;
?>


  <!-- Body Start -->
  <body>

    <!-- Header Start -->
    <header class="header bg-theme-grey-light">
      <div class="logo-wrap">
        <a href="shop.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
      </div>

      <div class="avatar-wrap">
        <a href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#share-grid"><i data-feather="share-2"></i></a>
      </div>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main class="main-wrap product-page mb-xxl">
      <!-- Banner Section Start -->
      <div class="banner-box product-banner">
        <div class="banner">
        <img src="/uploads/receitas/<?php echo $receitaArray['success'][0]['foto']; ?>" alt="veg" />
        </div>
        
      </div>
      <!-- Banner Section End -->

      <!-- Product Section Section Start -->
      <section class="product-section">
      <h4 style="color:#CE0125"><?php echo $receitaArray['success'][0]['nome']; ?></h4>
        <div class="rating">
          <i data-feather="star"></i>
          <i data-feather="star"></i>
          <i data-feather="star"></i>
          <i data-feather="star"></i>
          <i data-feather="star"></i>
          <span class="font-xs content-color">(150 Ratings)</span>
        </div>
        <div class="price"><span>$25.00</span><del>$45.00</del><span>25% off</span></div>

        <!-- Select Group Start -->
        <div class="select-group">
          <!-- Size Select Start -->
          <div class="size-Select" data-bs-toggle="offcanvas" data-bs-target="#quantity">
            <div class="size-box">
              <span class="font-sm title-color">500 g / $24.00</span>
            </div>
            <i data-feather="chevron-right"></i>
          </div>
          <!-- Size Select End -->

          <!-- Size Select Start -->
          <div class="size-Select" data-bs-toggle="offcanvas" data-bs-target="#time" aria-controls="time">
            <div class="size-box">
              <span class="font-sm title-color">Delivery Time</span>
            </div>
            <i data-feather="chevron-right"></i>
          </div>
          <!-- Size Select End -->
        </div>
        <!-- Select Group End -->

        <!-- Product Detail Start -->
        <div class="product-detail section-p-t">
          <div class="product-detail-box">
            <h2 class="title-color">Modo de preparo</h2>
            <p class="content-color font-base"><?php echo $receitaArray['success'][0]['modoPreparo']; ?></p>
          </div>

         
          </div>
          <!-- Product Detail Accordian End -->
        </div>
        <!-- Product Detail End -->
      </section>
      <!-- Product Section Section End -->

      

      

      
    </main>
    <!-- Main End -->

    <!-- Footer Start -->
    <footer class="footer-wrap shop">
      <ul class="footer">
        <li class="footer-item">
          <div class="plus-minus">
            <i class="sub" data-feather="minus"></i>
            <input type="number" value="1" min="0" max="10" />
            <i class="add" data-feather="plus"></i>
          </div>
        </li>
        <li class="footer-item">
          <a href="#" class="font-md">Lista de compras <i data-feather="chevron-right"></i></a>
        </li>
      </ul>
    </footer>
    <!-- Footer End -->

    <!-- Action Share Grid Start -->
    <div class="action action-share offcanvas offcanvas-bottom" tabindex="-1" id="share-grid" aria-labelledby="share-grid">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Share</h5>
        <span data-bs-dismiss="offcanvas" aria-label="Close"><i data-feather="x"></i></span>
      </div>
      <div class="offcanvas-body small">
        <ul class="row filter-row g-3 g-lg-4 grid">
          <li class="col-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <div class="filter-col">
              <a href="javascript:void(0)">
                <span class="icon facebook">
                  <svg><use xlink:href="assets/icons/svg/social/sprite2.svg#facebook"></use></svg> </span
                >Facebook
              </a>
            </div>
          </li>
          <li class="col-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <div class="filter-col">
              <a href="javascript:void(0)">
                <span class="icon instagram">
                  <svg><use xlink:href="assets/icons/svg/social/sprite2.svg#instagram"></use></svg> </span
                >Instagram
              </a>
            </div>
          </li>
          <li class="col-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <div class="filter-col">
              <a href="javascript:void(0)">
                <span class="icon whatsapp">
                  <svg><use xlink:href="assets/icons/svg/social/sprite2.svg#whatsapp"></use></svg> </span
                >Whatsapp
              </a>
            </div>
          </li>
          <li class="col-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <div class="filter-col">
              <a href="javascript:void(0)">
                <span class="icon twitter">
                  <svg><use xlink:href="assets/icons/svg/social/sprite2.svg#twitter"></use></svg> </span
                >Twitter
              </a>
            </div>
          </li>
          <li class="col-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <div class="filter-col">
              <a href="javascript:void(0)">
                <span class="icon linkdin">
                  <svg><use xlink:href="assets/icons/svg/social/sprite2.svg#linkedin"></use></svg> </span
                >Linkedin
              </a>
            </div>
          </li>
          <li class="col-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <div class="filter-col">
              <a href="javascript:void(0)">
                <span class="icon google">
                  <svg><use xlink:href="assets/icons/svg/social/sprite2.svg#google-plus"></use></svg> </span
                >Google +
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- Action Share Grid End -->

    <!-- Offcanvass Select Quantity Filter Start -->
    <div class="offcanvas select-offcanvas offcanvas-bottom" tabindex="-1" id="quantity" aria-labelledby="quantity">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Select Quantity</h5>
      </div>

      <div class="offcanvas-body small">
        <ul class="row filter-row g-3">
          <li class="col-6">
            <div class="filter-col">
              500 g / $24.00<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>

          <li class="col-6">
            <div class="filter-col">
              700 g / $34.00<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>

          <li class="col-6 active">
            <div class="filter-col">
              100 g / $48.00<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>

          <li class="col-6">
            <div class="filter-col">
              1.5 Kg / $70.00 <span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>

          <li class="col-6">
            <div class="filter-col">
              2 Kg / $100.00<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>

          <li class="col-6">
            <div class="filter-col">
              5 Kg / $150.00<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
        </ul>
      </div>

      <div class="offcanvas-footer">
        <button class="btn-outline" data-bs-dismiss="offcanvas" aria-label="reset">Cancel</button>
        <button class="btn-solid" data-bs-dismiss="offcanvas" aria-label="Close">Apply</button>
      </div>
    </div>
    <!-- Offcanvass Select Quantity Filter End -->

    <!-- Offcanvass Select Time Filter Start -->
    <div class="offcanvas select-offcanvas offcanvas-bottom" tabindex="-1" id="time" aria-labelledby="time">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Delivery Time</h5>
      </div>
      <div class="offcanvas-body small">
        <ul class="row filter-row g-3">
          <li class="col-6">
            <div class="filter-col">
              7 Am<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
          <li class="col-6">
            <div class="filter-col">
              9 Am<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
          <li class="col-6 active">
            <div class="filter-col">
              11 Am<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
          <li class="col-6">
            <div class="filter-col">
              5 Pm<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
          <li class="col-6">
            <div class="filter-col">
              7 Pm<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
          <li class="col-6">
            <div class="filter-col">
              9 Pm<span class="check"><img src="assets/icons/svg/active.svg" alt="active" /></span>
            </div>
          </li>
        </ul>
      </div>
      <div class="offcanvas-footer">
        <button class="btn-outline" data-bs-dismiss="offcanvas" aria-label="reset">Cancel</button>
        <button class="btn-solid" data-bs-dismiss="offcanvas" aria-label="Close">Apply</button>
      </div>
    </div>
    <!-- Offcanvass Select Time Filter End -->

    <!-- Offcanvass Select Time Filter Start -->
    <div class="offcanvas all-review-offcanvas offcanvas-bottom" tabindex="-1" id="all-review" aria-labelledby="all-review">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">All Review</h5>
        <span data-bs-dismiss="offcanvas" aria-label="Close"><i data-feather="x"></i></span>
      </div>
      <div class="offcanvas-body small">
        <div class="review-box">
          <div class="media">
            <img src="assets/images/avatar/avatar.jpg" alt="avatar" />
            <div class="media-body">
              <h4 class="font-sm title-color">Andrea Joanne</h4>
              <div class="rating">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
            </div>
          </div>
          <p class="font-sm content-color">It's a really cute skirt! I didn't expect to feel so good in a polyester material. The print is slightly</p>
        </div>
        <div class="review-box">
          <div class="media">
            <img src="assets/images/avatar/avatar.jpg" alt="avatar" />
            <div class="media-body">
              <h4 class="font-sm title-color">Andrea Joanne</h4>
              <div class="rating">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
            </div>
          </div>
          <p class="font-sm content-color">It's a really cute skirt! I didn't expect to feel so good in a polyester material. The print is slightly</p>
        </div>
        <div class="review-box">
          <div class="media">
            <img src="assets/images/avatar/avatar.jpg" alt="avatar" />
            <div class="media-body">
              <h4 class="font-sm title-color">Andrea Joanne</h4>
              <div class="rating">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
            </div>
          </div>
          <p class="font-sm content-color">It's a really cute skirt! I didn't expect to feel so good in a polyester material. The print is slightly</p>
        </div>
        <div class="review-box">
          <div class="media">
            <img src="assets/images/avatar/avatar.jpg" alt="avatar" />
            <div class="media-body">
              <h4 class="font-sm title-color">Andrea Joanne</h4>
              <div class="rating">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
            </div>
          </div>
          <p class="font-sm content-color">It's a really cute skirt! I didn't expect to feel so good in a polyester material. The print is slightly</p>
        </div>
        <div class="review-box">
          <div class="media">
            <img src="assets/images/avatar/avatar.jpg" alt="avatar" />
            <div class="media-body">
              <h4 class="font-sm title-color">Andrea Joanne</h4>
              <div class="rating">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
            </div>
          </div>
          <p class="font-sm content-color">It's a really cute skirt! I didn't expect to feel so good in a polyester material. The print is slightly</p>
        </div>
        <div class="review-box">
          <div class="media">
            <img src="assets/images/avatar/avatar.jpg" alt="avatar" />
            <div class="media-body">
              <h4 class="font-sm title-color">Andrea Joanne</h4>
              <div class="rating">
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
                <i data-feather="star"></i>
              </div>
            </div>
          </div>
          <p class="font-sm content-color">It's a really cute skirt! I didn't expect to feel so good in a polyester material. The print is slightly</p>
        </div>
      </div>
    </div>
    <!-- Offcanvass Select Time Filter End -->

<?php include "footer-main.php" ?>

    </html>
<!-- Html End -->
<!--**********************************
    Scripts
***********************************-->
<script src="assets/js/jquery.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dz.carousel.js"></script><!-- Swiper -->
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script><!-- Swiper -->
    <script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script><!-- Swiper -->
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/custom.js"></script>



    <script>
        $(".stepper").TouchSpin();

        /**********************************************/
        /*sets favorite button for a user in a recipe */
        /**********************************************/
        function changeState(item, id) {
            //alert(item);
            $('#' + item).toggleClass('active');

            // update db
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxFavorites.php',
                data: {
                    action: "set",
                    recipeId: id,
                },

                success: function(data) {
                    //$('.postList').prepend(data);
                }
            });
        }


        /**********************************************/
        /* more recipes buttons modal *****************/
        /**********************************************/

        //setup before functions
        var typingTimer; //timer identifier
        var doneTypingInterval = 100; //time in ms
        var $input = $('#searchInput');

        //on keyup, start the countdown
        $input.on('keyup', function() {

            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function() {
            clearTimeout(typingTimer);
        });

        //user is "finished typing" do something
        function doneTyping() {

            var valor = document.getElementById("searchInput").value;
            var row = Number($('#row').val());
            var count = Number($('#postCount').val());
            var limit = 10;
            row = row + limit;
            $('#row').val(row);
            $("#loadBtn").val('Loading...');

            //queries to ajax file
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxfile.php?search',
                data: {
                    row: row,
                    search: valor
                },

                success: function(data) {
                    var rowCount = row + limit;
                    //$('.postList').append(data);
                    //$("#list10").empty();
                    $("li[id=list10]").remove();
                    $(".postList").empty().append(data);
                    if (rowCount >= count) {
                        $('#loadBtn').css("display", "none");
                    } else {
                        $("#loadBtn").val('Load More');
                    }
                }
            });
        }
    </script>