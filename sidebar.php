<!-- Sidebar Start -->
<a href="javascript:void(0)" class="overlay-sidebar"></a>
    <aside class="header-sidebar">
      <div class="wrap">
        <div class="user-panel">
          <div class="media">
            <a href="account.php"> <img src="assets/images/avatar/avatar.jpg" alt="avatar" /></a>
            <div class="media-body">
              <a href="account.php" class="title-color font-sm"
                ><?php echo $me['nome']; ?>
                <span class="content-color font-xs"><?php echo $me['email']; ?></span>
              </a>
            </div>
          </div>
        </div>

        <!-- Navigation Start -->
        <nav class="navigation">
          <ul>
            <li>
              <a href="index.php" class="nav-link title-color font-sm">
                <i class="iconly-Home icli"></i>
                <span>Home</span>
              </a>
              <a class="arrow" href="index.php"><i data-feather="chevron-right"></i></a>
            </li>

            <li>
              <a href="meals-preferences.php" class="nav-link title-color font-sm">
              <img src="assets/icons/preferences.png" alt="flag" />
                <span>Meals preferences</span>
              </a>
              <a class="arrow" href="meals-preferences.php"><i data-feather="chevron-right"></i></a>
            </li>

            <li>
              <a href="subscription.php" data-bs-toggle="offcanvas" data-bs-target="#language" aria-controls="language" class="nav-link title-color font-sm">
                <img src="assets/icons/per.png" alt="flag" />
                <span>Inscrição</span>
              </a>
              <a class="arrow" href="subscription.php"><i data-feather="chevron-right"></i></a>
            </li>

            <li>
              <a href="waterIntake.php" class="nav-link title-color font-sm">
              <img src="assets/icons/flame.png" alt="flag" />
                <span>Água</span>
              </a>
              <a class="arrow" href="waterIntake.php"><i data-feather="chevron-right"></i></a>
            </li>
            <li>
              <a href="weight-add.php" class="nav-link title-color font-sm">
              <img src="assets/icons/1.png" alt="flag" />
                <span>Peso</span>
              </a>
              <a class="arrow" href="weight-add.php"><i data-feather="chevron-right"></i></a>
            </li>
            <li>
              <a href="password-change.php" class="nav-link title-color font-sm">
                <i class="iconly-Lock icli"></i>
                <span>Senhas</span>
              </a>
              <a class="arrow" href="password-change.php"><i data-feather="chevron-right"></i></a>
            </li>
            <li>
              <a href="index.php?logout" class="nav-link title-color font-sm">
                <i class="iconly-Logout icli"></i>
                <span>Logout</span>
              </a>
              <a class="arrow" href="index.php?logout"><i data-feather="chevron-right"></i></a>
            </li>

          </ul>
          
        </nav>
        <!-- Navigation End -->
      </div>
      <div class="contact-us">
        <span class="title-color">Contact Support</span>
        <p class="content-color font-xs">If you have any problem,queries or questions feel free to reach out</p>
        <a href="javascript:void(0)" class="btn-solid"> Contact Us </a>
      </div>
    </aside>
    <!-- Sidebar End -->