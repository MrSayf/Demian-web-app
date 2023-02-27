<?php
session_start();
include_once "admin/adm/conexao/conexao.php";
include_once "head.php";
include_once "functions/cookies.php";

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

  <!-- Body Start -->
  <body>
  <!-- Header Start -->
  <header class="header">
      <div class="logo-wrap">
        <a href="index.php"><i class="iconly-Arrow-Left-Square icli"></i></a>
        <h1 class="title-color font-md">Search Recipes</h1>
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
      <div class="main-wrap search-page mb-xxl">
        <!-- Search Box Start -->
        <div class="search-box">
          <input class="form-control" type="search" disabled />
        </div>
        <!-- Search Box End -->

        <!-- Recent Search Section Start -->
        <div class="recent-search section-p-t">
          <h2 class="font-md title-color fw-600 title-mb">Recently Search</h2>
          <ul class="custom-scroll-hidden">
            <li class="font-sm title-color"><span></span></li>
            <li class="font-sm title-color"><span></span></li>
            <li class="font-sm title-color"><span></span></li>
            <li class="font-sm title-color"><span></span></li>
            
          </ul>
        </div>
        <!-- Recent Search Section End -->

        <!-- Trending Category Section Start -->
        <div class="trending section-p-t">
          <h2 class="font-md title-color fw-600 title-mb">Trending category</h2>
          <div class="row g-3">
            <div class="col-3">
              <a href="category-wide.php" class="category bg-theme-blue border-blue">
                <div class="img"></div>
              </a>
            </div>

            <div class="col-3">
              <a href="category-wide.php" class="category bg-theme-yellow border-yellow">
                <div class="img"></div>
              </a>
            </div>

            <div class="col-3">
              <a href="category-wide.php" class="category bg-theme-orange border-orange">
                <div class="img"></div>
              </a>
            </div>

            <div class="col-3">
              <a href="category-wide.php" class="category bg-theme-pink border-pink">
                <div class="img"></div>
              </a>
            </div>
          </div>
        </div>
        <!-- Trending Category Section End -->

        <!-- Recent Search Section Start -->
        <div class="trending-products section-p-t">
          <h3 class="font-md title-color fw-600 title-mb">Trending Products</h3>

          <div class="product-wrap">
            <!-- Product Start -->
            <div class="product-list media">
              <div class="link">
                <div class="img"></div>
              </div>
              <div class="media-body">
                <a href="javascript:void(0)" class="font-sm"> Assorted Capsicum Combo </a>
                <span class="content-color font-xs">500g</span>
                <span class="title-color font-sm"><span> $25.00</span> </span>
              </div>
            </div>
            <!-- Product End -->

            <!-- Product Start -->
            <div class="product-list media">
              <div class="link">
                <div class="img"></div>
              </div>
              <div class="media-body">
                <a href="javascript:void(0)" class="font-sm"> Assorted Capsicum Combo </a>
                <span class="content-color font-xs">500g</span>
                <span class="title-color font-sm"><span> $25.00</span> </span>
              </div>
            </div>
            <!-- Product End -->
          </div>
        </div>
        <!-- Recent Search Section End -->
      </div>
      <!-- Main End -->
    </div>
    <!-- Skeleton loader End -->

    

    <?php include 'sidebar.php'?>
      

    <!-- Main Start -->
    <main class="main-wrap search-page mb-xxl">
      <!-- Search Box Start -->
      <div class="search-box">
        <i class="iconly-Search icli search"></i>
        <input class="form-control" type="search" placeholder="Search here..." />
        <i class="iconly-Voice icli mic"></i>
      </div>
      <!-- Search Box End -->

      <!-- Recent Search Section Start -->
      <section class="recent-search pb-0">
        <h1 class="font-md title-color fw-600 title-mb">Recently Search</h1>
        <ul class="custom-scroll-hidden">
          <li class="font-sm title-color" role="group" aria-label="1 / 6" style="margin-right: 10px;">
            <a href="javascript:void(0);" id="periodSelection1" name="tudo" class="tag-btn active">
            <div class="active-status"></div>
            Tudo
              </a>
          </li>
          <li class="font-sm title-color" role="group" aria-label="2 / 6" style="margin-right: 10px;">
            <a href="javascript:void(0);" id="periodSelection1" name="cafe_da_manha" class="tag-btn active">
            <div class="active-status"></div>
            Café da manhã
              </a>
          </li>
          <li class="font-sm title-color" role="group" aria-label="3 / 6" style="margin-right: 10px;">
            <a href="javascript:void(0);" id="periodSelection1" name="lanche_da_manha" class="tag-btn active">
            <div class="active-status"></div>
            Lanche da manhã
              </a>
          </li>
          <li class="font-sm title-color" role="group" aria-label="4 / 6" style="margin-right: 10px;">
            <a href="javascript:void(0);" id="periodSelection1" name="almoco" class="tag-btn active">
            <div class="active-status"></div>
            Almoco
              </a>
          </li>
          <li class="font-sm title-color" role="group" aria-label="5 / 6" style="margin-right: 10px;">
            <a href="javascript:void(0);" id="periodSelection1" name="lanche_da_tarde" class="tag-btn active">
            <div class="active-status"></div>
            Lanche da tarde
              </a>
          </li>
          <li class="font-sm title-color" role="group" aria-label="6 / 6" style="margin-right: 10px;">
            <a href="javascript:void(0);" id="periodSelection1" name="jantar" class="tag-btn active">
            <div class="active-status"></div>
            Jantar
              </a>
          </li>
          <li class="font-sm title-color" role="group" aria-label="2 / 6">
            <a href="javascript:void(0);" id="periodSelection1" name="favoritesButton" class="tag-btn active">
            <div class="active-status"></div>
            Favoritos
              </a>
          </li>
         
        </ul>
      </section>
      <!-- Recent Search Section End -->

      <div class="container pt-0">
                <!-- Masseges List -->
                <ul class="dz-list message-list">
                    <div class="postList">
                    </div>
                </ul>

                <?php
                $receitasCount      = HTTPRequester::HTTPGet(API_URL ."Receitas/receitasCount/", array("getParam" => "foobar"),$_SESSION['loggedAdmin']['token']);
                $receitasCountArray = json_decode((string)$receitasCount, true);
                ?>

                <div class="loadmore">
                    <input type="hidden" id="row" value="0">
                    <input type="hidden" id="postCount" value="<?php echo $receitasCountArray['success'][0]['allcount']; ?>">
                </div>

                <!-- btn scrollTop btn-primary btn-rounded px-3 chat-btn -->
                <a onclick="doneClickingPeriods('periodSelection0')" id="loadBtn2" href="#" class="btn  btn-primary btn-rounded px-3 chat-btn "><i class="fa-solid fa-plus me-2"></i> mais </a>
            </div>
        </div>
        <!-- Page Content End-->

      
    </main>
    <!-- Main End -->

    <?php include 'footer-start.php'?>

    <?php include 'footer-main.php'?>
</html>
<!-- Html End -->

<script>
            /**********************************************/
            /*sets favorite button for a user in a recipe */
            /**********************************************/
            function changeState(item, id) {
                
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
                        //alert('success');
                        //alert(horario);
                        //var rowCount = row + limit;
                        $('.postList').prepend(data);
                        //$("#list10").empty();
                    }
                });
            }



            /**********************************************/
            /*sets favorite button for a user in a recipe */
            /**********************************************/
            function listFavorites(item, id) {

                // alert("listar favoritos");
                $('#' + item).toggleClass('active');
                var row = Number($('#row').val());
                var count = Number($('#postCount').val());
                var limit = 10;
                row = 0;

                // update db
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ajaxOnlyFavorites.php',
                    data: {
                        action: "set",
                        recipeId: id,
                        row: row,
                    },

                    success: function(data) {

                        $('#row').val(0);
                        $("li[id=list10]").remove();
                        $(".postList").empty().append(data);

                    }
                });
            }


            /*****************************************/
            /*shows recipes when first opens the page*/
            /*****************************************/
            $(document).ready(function() {
                doneClickingPeriods('periodSelection0');
            });


            /*****************************************/
            /**After clicking inside periods buttons**/
            /*****************************************/
            var $inputPeriod = $('#periodSelection0');
            $inputPeriod.on('click', function() {
                doneClickingPeriods('periodSelection0');
            });

            var $inputPeriod = $('#periodSelection1');
            $inputPeriod.on('click', function() {
                doneClickingPeriods('periodSelection1');
            });

            var $inputPeriod = $('#periodSelection2');
            $inputPeriod.on('click', function() {
                doneClickingPeriods('periodSelection2');
            });

            var $inputPeriod = $('#periodSelection3');
            $inputPeriod.on('click', function() {
                doneClickingPeriods('periodSelection3');
            });

            var $inputPeriod = $('#periodSelection4');
            $inputPeriod.on('click', function() {
                doneClickingPeriods('periodSelection4');
            });

            var $inputPeriod = $('#periodSelection5');
            $inputPeriod.on('click', function() {
                doneClickingPeriods('periodSelection5');
            });

            //user clicked in period button
            function doneClickingPeriods(period) {

                var horario = document.getElementById(period).name;
                //alert(horario);

                //alert(valor);
                var row = Number($('#row').val());
                var count = Number($('#postCount').val());
                var limit = 10;
                row = row + limit;

                //$("#loadBtn2").val('Loading...');

                if (horario == 'tudo') {
                    $('#loadBtn2').css("display", "block");
                    $('#row').val(row);
                    var url = "ajax/ajaxfileSearchRecipesFixed.php?searchTudo";
                } else {
                    $('#loadBtn2').css("display", "none");
                    row = 0;
                    $('#row').val(row);
                    var url = "ajax/ajaxfileSearchRecipesFixed.php?searchPeriod";
                }

                //queries to ajax file
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        searchPeriod: "",
                        horario: horario,
                        row: row,
                    },

                    success: function(data) {
                        //alert(horario);
                        var rowCount = row + limit;
                        //$('.postList').append(data);
                        //$("#list10").empty();



                        // if row > 10 means it's the load more button, so append without erasing anything                        
                        if (horario == "tudo") {
                            //$("li[id=list10]").remove();
                            if (row > 10) {
                                //window.scrollTo(0, document.querySelector(".dz-list").scrollHeight * 10);

                                $('html, body').stop().animate({
                                    scrollTop: $('html, body')[0].scrollHeight
                                }, 800);
                               
                                $(".postList").append(data);
                            } else {
                                $("li[id=list10]").remove();
                                $(".postList").empty().append(data);
                            }

                        } else {
                            // periods button, erase then append
                            $("li[id=list10]").remove();
                            $(".postList").empty().append(data);
                        }


                        if (rowCount >= count) {
                            $('#loadBtn2').css("display", "none");
                        } else {
                            $("#loadBtn2").val('Load More');
                        }
                    }
                });
            }



            /*****************************************/
            /**After typing inside search input ******/
            /*****************************************/

            //setup before functions
            var typingTimer; //timer identifier
            var doneTypingInterval = 100; //time in ms

            var $input = $('#searchInput');
            //$('input').attr('name', 'yourNewname');
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

                //alert(document.getElementById("searchInput").name);

                //alert(valor);
                var row = Number($('#row').val());
                var count = Number($('#postCount').val());
                var limit = 10;
                row = row + limit;
                //$('#row').val(row);
                $('#row').val(0);
                //$("#loadBtn").val('Loading...');
                row = 0;
                //var searchName = document.getElementById("searchInput").name;
                var horario = "";
                var resu = "";

                //queries to ajax file
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ajaxfileSearchRecipesFixed.php?search',
                    data: {
                        search: valor,
                        horario: horario,
                        row: 0,
                    },

                    success: function(data) {
                        //var rowCount = row + limit;
                        //$('.postList').append(data);
                        //$("#list10").empty();
                        $("li[id=list10]").remove();
                        $(".postList").empty().append(data);
                        $('#loadBtn2').css("display", "none");
                        // if (rowCount >= count) {

                        //     $('#loadBtn').css("display", "none");
                        // } else {

                        //     $("#loadBtn").val('Load More');
                        // }
                    }
                });
            }
        </script>
