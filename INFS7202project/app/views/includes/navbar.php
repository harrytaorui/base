<nav>
  <div class="header_top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6">
          <div class="welcome_text">
            <p>Welcome to BuyIt, an electronical platform for second hand deal </p>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="top_right text-right">
            <ul>
              <?php if(isset($_SESSION['username'])) : ?>
                <li><a href="<?php echo URLROOT; ?>/account">
                  <p><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['username']; ?></p></a>
                  </li>
                <li><a href="<?php echo URLROOT; ?>/users/logout">
                     <span class="glyphicon glyphicon-log-out"></span>Logout</a>
                </li>
              <?php else : ?>
                <li><a href="<?php echo URLROOT; ?>/users/registration">Sign up</a></li>
                <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header_bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-4 col-md-5">
          <div class="logo">
              <a href="<?php echo URLROOT; ?>/home"><img src="<?php echo URLROOT; ?>/images/logo3.png" alt="buyit"></a>
          </div>
        </div>
        <div class="col-lg-8 col-md-7">
          <div class="search_bar">
            <form action="<?php echo URLROOT;?>/Search" method="get">
                <input placeholder="I'm looking for..." type="text">
                <button type="submit"><i class="ion-ios-search-strong"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
