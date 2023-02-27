<?php
include_once "functions/mealsFunctions.php";
include_once "functions/generalFunctions.php";

/*********************************************************/
/** change meal period from modal 7 **********************/
/*********************************************************/

if (isset($_GET['changeMeal']) && $_GET['changeMeal'] == true) {
    changeMeal($_GET['recipeId'], $_GET['mealDay'], $_GET['changeMealPeriod'], $_GET['changeMealToId']);
}

//print_r($_SESSION);

/*********************************************************/
/** Personal information from session like meal plan *****/
/*********************************************************/
// turn into array
$planoArray = array();
$planoArray = json_decode($_SESSION['loggedAdmin']['me'], true);
// make 'plano json' also an array
$planoArrayJson = array();
$planoArrayJson = json_decode($planoArray['plano'], true);

/*********************************************************/
/** Fetchs for recipes in the bottom of page, 5 periods***/
/*********************************************************/

// finds which day of meal plan is today
$actualDay = actualPlanDayNumber();
$planDayStart = $planoArray['dataPlanoInicio'];
$planDayFinish = $planoArray['dataPlanoFinaliza'];



// retrieve length of actual plan in days for the calendar in the top of body
$sizeOfActualPlanInDays = sizeOfActualPlanInDays();

// query db
$periodsIds     = $planoArrayJson['cafe_da_manha'][$actualDay] . ',' . $planoArrayJson['lanche_da_manha'][$actualDay] . ',' . $planoArrayJson['almoco'][$actualDay] . ',' . $planoArrayJson['lanche_da_tarde'][$actualDay] . ',' . $planoArrayJson['jantar'][$actualDay];
$periods        = HTTPRequester::HTTPGet(API_URL . "Receitas/indexIngredients/" . $periodsIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$periodsArray   = json_decode((string)$periods, true);


// find id inside array for each period
$cafe_da_manha   = array_search('cafe_da_manha', array_column($periodsArray['success'], 'horario'));
$lanche_da_manha = array_search('lanche_da_manha', array_column($periodsArray['success'], 'horario'));
$almoco          = array_search('almoco', array_column($periodsArray['success'], 'horario'));
$lanche_da_tarde = array_search('lanche_da_tarde', array_column($periodsArray['success'], 'horario'));
$jantar          = array_search('jantar', array_column($periodsArray['success'], 'horario'));


/*********************************************************/
/** Retrieve order list for today only *******************/
/*********************************************************/
$orderList = array();
$salvaMedidas = array();
for ($x = 0; $x < count($periodsArray['success']); $x++) {

    // inserts all ingredients into an array
    for ($z = 0; $z < count($periodsArray['success'][$x]['ingredientes']); $z++) {
        $orderList[] .= $periodsArray['success'][$x]['ingredientes'][$z][0]['nome'];
        $medidas = json_decode($periodsArray['success'][$x]['medidas'], true);
    }

    // inserts all measures into an array
    for ($v = 0; $v < count($medidas); $v++) {
        $salvaMedidas[] .= $medidas[$v];
    }
}

// Unique ingredients
$unique = array_unique($orderList);
// Duplicates ingredients
$duplicates = array_diff_assoc($orderList, $unique);

/*********************************************************/
/** Retrieve order list for today only *******************/
/*********************************************************/

// add duplicated measures to unique ingredients so no dups are left
foreach ($unique as $key => $value) {
    foreach ($duplicates as $key2 => $value2) {
        if ($value == $value2) {
            // echo $value.' igual '.$value2;
            // echo ' a id do original e: '.$key;
            // echo 'a medida a ser somada e '.$salvaMedidas[$key2].' key '.$key2.'<br>';
            $salvaMedidas[$key] = $salvaMedidas[$key] + $salvaMedidas[$key2];
        }
    }
}

// remove duplicateds from measures array
foreach ($duplicates as $key => $value) {
    unset($salvaMedidas[$key]);
}

// reorders ingredients and measures arrays, ready to use in order/cart modal
$orderIngredientsFinals = array_values($unique);
$orderMeasuresFinals = array_values($salvaMedidas);
//$ordersCartCountBadge = count($orderIngredientsFinals);


/*********************************************************/
/** Recommended recipes, 10 total ************************/
/*********************************************************/
$recommendedRecipes        = HTTPRequester::HTTPGet(API_URL . "Receitas/recommendedRecipes/", array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$recommendedRecipesArray   = json_decode((string)$recommendedRecipes, true);

/*******************************************************************************/
/************************    Calculate daily intake   **************************/
/*******************************************************************************/

//$nowCalsTime = mealTimes();
//$calcIntakesFinal = calcIntakes($nowCalsTime, $planoArrayJson, 2);
$periodsToCalc = mealTimesGone();
$periodos = array("cafe_da_manha", "lanche_da_manha", "almoco", "lanche_da_tarde", "jantar");
$receitasIds = '';
$count = (5 - $periodsToCalc);

for ($x = 0; $x < $periodsToCalc; $x++) {

    $receitasIds .= $planoArrayJson[$periodos[$x]][$actualDay];
    $receitasIds .= ",";
    //echo '---'.$receitasIds.'---<br>';
}
$receitasIds = substr($receitasIds, 0, -1);
$calcIntakeTotal = HTTPRequester::HTTPGet(API_URL . "Receitas/dailyIntakeIndexIngredients/" . $receitasIds, array("getParam" => "foobar"), $_SESSION['loggedAdmin']['token']);
$calcIntakeTotalArray    = json_decode((string)$calcIntakeTotal, true);

// echo '<pre>';
// print_r($calcIntakeTotalArray);

/*******************************************************************************/
/************************    Calculate meals already taken end of page *********/
/*******************************************************************************/
$mealAlreadyTaken = mealTimesGone();


?>

<?php
include 'head.php';
?>

  <!-- Body Start -->
  <body>
  <?php include 'header.php'?>
    <!-- Skeleton loader Start -->
    <div class="skeleton-loader">
      <!--Main Start -->
      <div class="main-wrap index-page mb-xxl">
        <!-- Search Box Start -->
        <div class="search-box">
          <input class="form-control" disabled type="search" />
        </div>
        <!-- Search Box End -->
        <!-- Banner Section Start -->
        <div class="banner-section section-p-t ratio2_1">
          <div class="h-banner-slider">
            <div>
              <div class="banner-box">
                <div class="bg-img"></div>
              </div>
            </div>
            <div>
              <div class="banner-box">
                <div class="bg-img"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Banner Section End -->
        <!-- Buy from Recently Bought Start -->
        <div class="recently section-p-t">
          <div class="recently-wrap">
            <h3 class="font-md sk-hed"></h3>
            
            <ul class="recently-list">
              <li class="item">
                <div class="img"></div>
              </li>
              <li class="item"><div class="img"></div></li>
              <li class="item"><div class="img"></div></li>
              <li class="item"><div class="img"></div></li>
              <li class="item"><div class="img"></div></li>
              <li class="item"><div class="img"></div></li>
            </ul>
          </div>
        </div>
        <!-- Buy from Recently Bought End -->

        <!-- Shop By Category Start -->
        <div class="category section-p-t">
          <h3 class="font-sm"><span></span><span class="line"></span></h3>
          <div class="row gy-sm-4 gy-2">
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"></span>
              </div>
            </div>
            <div class="col-3">
              <div class="category-wrap">
                <div class="bg-shape"></div>
                <span class="font-xs title-color"> </span>
              </div>
            </div>
          </div>
        </div>
        <!-- Shop By Category End -->

        <!-- Say hello to Offers! Start -->
        <div class="offer-section section-p-t">
          <div class="offer">
            <div class="top-content">
              <div>
                <h4 class="title-color">Say hello to Offers!</h4>
                <p class="content-color">Best price ever of all the time</p>
              </div>
              <a href="javascript(0).html" class="font-xs font-theme">See all</a>
            </div>

            <div class="offer-wrap">
              <div class="product-list media">
                <a href="javascript(0).html"><img src="assets/images/product/8.png" alt="offer" /></a>
                <div class="media-body">
                  <a href="javascript(0).html" class="font-sm"> Assorted Capsicum Combo </a>
                  <span class="content-color font-xs">500g</span>
                  <span class="title-color font-sm">$25.00 <span class="badges-round bg-theme-theme font-xs">50% off</span></span>
                  <div class="plus-minus d-xs-none">
                    <i class="sub" data-feather="minus"></i>
                    <input type="number" value="1" min="0" max="10" />
                    <i class="add" data-feather="plus"></i>
                  </div>
                </div>
              </div>

              <div class="product-list media">
                <a href="javascript(0).html"><img src="assets/images/product/6.png" alt="offer" /></a>
                <div class="media-body">
                  <a href="javascript(0).html" class="font-sm"> Assorted Capsicum Combo </a>
                  <span class="content-color font-xs">500g</span>
                  <span class="title-color font-sm">$25.00 <span class="badges-round bg-theme-theme font-xs">50% off</span></span>
                  <div class="plus-minus d-xs-none">
                    <i class="sub" data-feather="minus"></i>
                    <input type="number" value="1" min="0" max="10" />
                    <i class="add" data-feather="plus"></i>
                  </div>
                </div>
              </div>

              <div class="product-list media">
                <a href="javascript(0).html"><img src="assets/images/product/7.png" alt="offer" /></a>
                <div class="media-body">
                  <a href="javascript(0).html" class="font-sm"> Assorted Capsicum Combo </a>
                  <span class="content-color font-xs">500g</span>
                  <span class="title-color font-sm">$25.00 <span class="badges-round bg-theme-theme font-xs">50% off</span></span>
                  <div class="plus-minus d-xs-none">
                    <i class="sub" data-feather="minus"></i>
                    <input type="number" value="1" min="0" max="10" />
                    <i class="add" data-feather="plus"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Say hello to Offers! End -->
      </div>
      <!--Main End -->
    </div>
    <!-- Skeleton loader End -->

    
    
    <?php include 'sidebar.php'?>
    

    <!-- Main Start -->
    <main class="main-wrap index-page mb-xxl">
      <!-- Search Box Start -->
      <div class="search-box">
        <i class="iconly-Search icli search"></i>
        <input class="form-control" type="search" placeholder="Search here..." />
        <i class="iconly-Voice icli mic"></i>
      </div>
      <!-- Search Box End -->

      <!-- Banner Section Start -->
      <section class="banner-section ratio2_1">
        <div class="h-banner-slider">
          <div>
            <div class="banner-box">
              <img src="assets/images/banner/home1.jpg" alt="banner" class="bg-img" />
              <div class="content-box">
                <h1 class="title-color font-md heading">Farm Fresh Veggies</h1>
                <p class="content-color font-sm">Get instant delivery</p>
                <a href="shop.php" class="btn-solid font-sm">Shop Now</a>
              </div>
            </div>
          </div>

          <div>
            <div class="banner-box">
              <img src="assets/images/banner/home1.jpg" alt="banner" class="bg-img" />
              <div class="content-box">
                <h1 class="title-color font-md heading">Farm Fresh Veggies</h1>
                <p class="content-color font-sm">Get instant delivery</p>
                <a href="shop.php" class="btn-solid font-sm">Shop Now</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Banner Section End -->

      

      <!-- Lowest Price 2 Start -->
      <section class="recently-viewed">
        <div class="top-content">
          <div>
            <h4 class="title-color">Recomendado</h4>
            <p class="font-xs content-color">Pay less, Get More</p>
          </div>
          <a href="search.php" class="font-xs font-theme">See all</a>
        </div>
        <div class="product-slider">
            <?php for ($x = 0; $x < sizeof($recommendedRecipesArray['success']); $x++) { ?>
          <div>
            <div class="product-card">
              <div class="img-wrap">
                <a href="meal-detail.php?id=<?= $recommendedRecipesArray['success'][$x]['id']; ?>">
                <img src="/uploads/receitas/<?php echo $recommendedRecipesArray['success'][$x]['foto']; ?>" class="img-fluid" alt="product" /> </a>
              </div>
              <div class="content-wrap">
                <a href="product.php" class="font-sm title-color"><?php echo $recommendedRecipesArray['success'][$x]['nome']; ?></a>
                <span class="content-color font-xs">500g</span>
                <span class="title-color font-sm plus-item"
                  >$25.00
                  <span class="plus-minus">
                    <i class="sub" data-feather="minus"></i>
                    <input class="val" type="number" value="1" min="1" max="10" />
                    <i class="add" data-feather="plus"></i>
                  </span>
                  <span class="plus-theme"><i data-feather="plus"></i> </span
                ></span>
              </div>
            </div>
          </div>

          <?php }?>
          </div>
        </div>
      </section>
      <!-- Lowest Price 2 End -->

      <!-- Say hello to Offers! Start -->
      <section class="offer-section pt-0">
        <div class="offer">
          <div class="top-content">
            <div>
              <h4 class="title-color">Say hello to Offers!</h4>
              <p class="content-color">Best price ever of all the time</p>
            </div>
            <a href="offer.php" class="font-theme">See all</a>
          </div>
          <?php
                // deals with favorites
                // turns into array so i can retrieve user id

                $sessionMe = json_decode($_SESSION['loggedAdmin']['me'], true);

                if (isset($sessionMe['favoritos']) && strlen($sessionMe['favoritos']) > 1) {
                    $favoritosArray = explode(',', $sessionMe['favoritos']);
                } else {
                    $favoritosArray = array();
                }

                ?>
                <?php
                
                // show meals that time has passed, so they are considered as finished
                $gonePeriods = array();
                $gonePeriods = ['cafe_da_manha', 'lanche_da_manha', 'almoco', 'lanche_da_tarde', 'jantar'];
                // $blockMealAlreadyTaken = 5 - $mealAlreadyTaken;
                for ($x = $mealAlreadyTaken; $x < 5; $x++) {
                ?>

          <div class="offer-wrap">
            <div class="product-list media">
              <a href="meal-detail.php?id=<?php echo  $periodsArray['success'][${$gonePeriods[$x]}]['id']; ?>">
                <img src="/uploads/receitas/<?php echo  $periodsArray['success'][${$gonePeriods[$x]}]['foto']; ?>" /></a>
              <div class="media-body">
              <a href="meal-detail.php?id=<?php echo  $periodsArray['success'][${$gonePeriods[$x]}]['id']; ?>">
                            <h6 class="mb-0"><?php echo  $periodsArray['success'][${$gonePeriods[$x]}]['nome']; ?></h6>
                        </a>
                <span class="content-color font-xs">$ 5.0</span>
                <span class="badges-round bg-theme-theme font-xs" ><?php echo  $periodsArray['success'][${$gonePeriods[$x]}]['gorduras']; ?>g de gordura</span>
                <div class="plus-minus d-xs-none">
                  <i class="sub" data-feather="minus"></i>
                  <input type="number" value="1" min="0" max="10" />
                  <i class="add" data-feather="plus"></i>
                </div>
              </div>
            </div>
            <?php } ?>
            
          </div>
        </div>
      </section>
      <!-- Say hello to Offers! End -->

      

      <!-- Question section Start -->
      <section class="question-section pt-0">
        
        <a href="category-wide.html" class="btn-solid" style="justify-content: center; border-radius: 2.75rem; display: block;text-align: center;width: 200px;margin: auto;">Browse Category</a>
      </section>
      <!-- Question section End -->
    </main>
    <!-- Main End -->

    <?php include 'footer-start.php'?>

    <?php include 'footer-main.php'?>
</html>
<script>
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
                $('.postList1000').prepend(data);
            }

        });
    }

    /**********************************************/
    /* Enviar sugestão e gostei             *******/
    /**********************************************/
    function sendFeedback(texto) {

        var valor = texto;
        // call from gostei or sugestao ?
        if (texto == 0) {
            // gostei
            var valor = 1;
        } else {
            var valor = document.getElementById("feedbackTextareaId").value;
        }
        // date
        var date = <?php date('Y-m-d H:i:s'); ?>

        // update db
        $.ajax({
            type: 'POST',
            url: '<?php echo API_URL . 'Feedback/store/'; ?>',
            data: {
                idUsuario: <?php echo $planoArray['id']; ?>,
                opiniao: valor,
                data: "2022-11-30 14:56:59"
            },

            success: function(data) {
                //$('.postList').prepend(data);
                //exampleModal5;
                $('#exampleModal5').modal('hide');
                $('#exampleModal4').modal('hide');
            }
        });
    }



    function showModal7Now(value, local) {
        $("#exampleModal6").modal('hide');
        openModal7AjaxCall(value, local);
        $("#exampleModal7").modal('show');
    }

    /*******************************************/
    /**shows first modal 6 to all meals periods*/
    /*******************************************/

    function showModal6All(valor, local) {

        $("#exampleModal6").modal('show');

        var valor = document.getElementById("searchInput").value;
        var row = Number($('#row').val());
        var count = Number($('#postCount').val());
        var limit = 10;
        row = row + limit;
        $('#row').val(row);
        $("#loadBtn").val('Loading...');

        if (local == 'cafe_da_manha') {
            var resu = 'cafe_da_manha';
            $('#searchInput').attr('name', 'search_cafe_da_manha');
        }
        if (local == 'lanche_da_manha') {
            var resu = 'lanche_da_manha';
            $('#searchInput').attr('name', 'search_lanche_da_manha');
        }
        if (local == 'almoco') {
            var resu = 'almoco';
            $('#searchInput').attr('name', 'search_almoco');
        }
        if (local == 'lanche_da_tarde') {
            var resu = 'lanche_da_tarde';
            $('#searchInput').attr('name', 'search_lanche_da_tarde');
        }
        if (local == 'jantar') {
            var resu = 'jantar';
            $('#searchInput').attr('name', 'search_jantar');
        }


        $.ajax({
            type: 'POST',
            url: 'ajax/ajaxfile.php?search&selectAnyColumn=' + resu + '&mealDay=<?php echo $actualDay; ?>',
            data: {
                row: row,
                search: "",
                selectAnyColumn: local,
            },

            success: function(data) {
                var rowCount = row + limit;
                //$('.postList').append(data);
                //$("#list10").empty();
                $("li[id=list10]").remove();
                $(".postList").empty().append(data);
                //$(".postList").append(data);
                if (rowCount >= count) {
                    $('#loadBtn').css("display", "none");
                } else {
                    $("#loadBtn").val('Load More');
                }
            }
        });
    }




    $(document).ready(function() {

        //alert(window.location.search.substr(1));

        //showModalNow();
        function showModalNow() {
            $("#exampleModal6").modal('show');
        }



        /*****************************************/
        /**  button 'ver mais' inside modal ******/
        /*****************************************/
        $(document).on('click', '#loadBtn', function() {
            var row = Number($('#row').val());
            var count = Number($('#postCount').val());
            var limit = 10;
            row = row + limit;
            $('#row').val(row);
            $("#loadBtn").val('Loading...');

            //scroll modal down
            var scroll = $('#exampleModal6');
            scroll.animate({
                scrollTop: scroll.prop("scrollHeight")
            }, 5000);

            //queries to ajax file
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxfile.php',
                data: 'row=' + row,
                success: function(data) {
                    var rowCount = row + limit;
                    $('.postList').append(data);
                    if (rowCount >= count) {
                        $('#loadBtn').css("display", "none");
                    } else {
                        $("#loadBtn").val('Load More');
                    }
                }
            });
        });
    });



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
        $('#row').val(row);
        $("#loadBtn").val('Loading...');

        var searchName = document.getElementById("searchInput").name;
        var resu = "";
        if (searchName == 'search_cafe_da_manha') {
            resu = 'cafe_da_manha';
        }

        if (searchName == 'search_lanche_da_manha') {
            resu = 'lanche_da_manha';
        }

        if (searchName == 'search_almoco') {
            resu = 'almoco';
        }

        if (searchName == 'search_lanche_da_tarde') {
            resu = 'lanche_da_tarde';
        }

        if (searchName == 'search_jantar') {
            resu = 'jantar';
        }


        //alert(resu);
        //queries to ajax file
        $.ajax({
            type: 'POST',
            url: 'ajax/ajaxfileSearchRecipes.php?search',
            data: {
                row: row,
                search: valor,
                horario: resu,
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



    /*****************************************/
    /** opens meals details             ******/
    /*****************************************/
    function openModal7AjaxCall(valor, local) {

        //var valor = document.getElementById("searchInput").value;
        var valor = valor;
        var row = Number($('#row').val());
        var count = Number($('#postCount').val());
        var limit = 10;
        row = row + limit;
        $('#row').val(row);
        $("#loadBtn").val('Loading...');
        var mealDay = <?php echo $actualDay; ?>;
        //queries to ajax file
        $.ajax({
            type: 'POST',
            url: 'ajax/ajaxfile2.php?search&mealDay=' + mealDay,
            data: {
                row: row,
                search: valor
            },

            success: function(data) {
                var rowCount = row + limit;
                //$('.postList').append(data);
                //$("#list10").empty();
                //$("li[id=list10]").remove();
                //$(".postListModal7").empty().append(data);
                $(".postListModal7").empty().append(data);
                if (rowCount >= count) {
                    $('#loadBtn').css("display", "none");
                } else {
                    $("#loadBtn").val('Load More');
                }
            }
        });
    }



    // slide swiper do calendario
    if (jQuery('.categorie-swiper').length > 0) {
        var swiper4 = new Swiper('.categorie-swiper', {
            speed: 1500,
            parallax: true,
            slidesPerView: "auto",
            spaceBetween: 15,
            loop: false,
        });
        swiper4.slideTo(<?php echo $actualDay - 1; ?>, false, false);

    }
</script>