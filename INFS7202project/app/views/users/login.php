<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <?php flash('register_success'); ?>
      <h2>Login</h2>
      <form action="<?php echo URLROOT; ?>/users/login" method="POST">
        <!-- Username/Email field -->
        <div class="form-group">
          <label for="username_email">Username/Email:</label>
          <div class="col-lg-10">
            <div class="input-group">
              <span class="signup_icon"><i class="fas fa-envelope"></i></span>
              <input type="text" name="username_email" placeholder="Enter your email" class="form-control 
                  <?php echo (!empty($data['username_email_error'])) ? 'is-invalid' : ''; ?>"  
                  value="<?php echo $data['username_email']?>"/>
              <span class="invalid-feedback"><?php echo $data['username_email_error'] ?></span>
              <div class="elem-group">
                  <label for="captcha">Please Enter the Captcha Text</label>
                  <img src="<?php echo URLROOT; ?>/captcha" alt="CAPTCHA" class="captcha-image"><i class="fas fa-redo refresh-captcha"></i>
                  <br>
                  <input type="text" id="captcha" name="captcha_challenge" pattern="[A-Z]{6}">
              </div>
            </div>
          </div>
        </div>

        <!-- Password field -->
        <div class="form-group">
          <label for="password">Password:</label>
          <div class="col-lg-10">
            <div class="input-group">
              <span class="signup_icon"><i class="fas fa-lock"></i></span>
              <input type="password" name="password" placeholder="Enter your password" class="form-control 
                  <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" 
                  value="<?php echo $data['password']?>"/>
              <span class="invalid-feedback"><?php echo $data['password_error']?></span>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col">
            <input type="submit" value="Login" class="btn btn-success btn-block">
          </div>
          <div class="col">
            <a href="<?php echo URLROOT; ?>/users/registration" class="btn btn-light btn-block">No account? Register</a>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
