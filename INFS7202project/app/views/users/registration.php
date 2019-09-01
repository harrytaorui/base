
<div class="customer_login">
    <div class="container">
        <div class="row">
            <div class= "col-lg-12 col-md-12">
                <?php flash('register_success'); ?>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="account_form login">
                    <h2>login</h2>
                    <form id="loginform" method="POST" action="<?php echo URLROOT; ?>/users/login" >
                        <p>   
                            <label for="user_name">Username<span>*</span></label>
                            <input id="user_name" name = "user_name" type="text" 
                            value="<?php if(isset($_COOKIE["username"])) {
                                    echo $_COOKIE["username"];}?>">
                        </p>
                        <p>   
                          <label for="pass_word">Password <span>*</span></label>
                          <input id="pass_word" name = "pass_word" type="password">
                        </p>
                        <p>
                            <label for="captcha">Please Enter the Captcha Text</label>
                            <img src="<?php echo URLROOT; ?>/captcha.php" alt="CAPTCHA" class="captcha-image" style="margin: 5px;"><i class="fas fa-redo refresh-captcha"></i>
                            <br>
                            <input type="text" id="captcha" name="captcha_challenge">
                        </p>
                        <div>
                          <?php flash('login_failed'); ?>
                        </div>   
                        <div class="login_submit">
                            <button id="login" type="submit">login</button>
                            <label for="remember">
                                <input id="remember" name = "remember" type="checkbox" <?php if(isset($_COOKIE["username"])) {echo "checked";} else {echo "unchecked";}?>>
                                Remember me
                            </label>
                            <a href="#">Forget your password?</a>
                        </div>
                    </form>
                 </div>    
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="account_form register">
                    <h2>Signup</h2>
                    <form id="signupform" name='signupform' method = "POST" action="<?php echo URLROOT; ?>/users/registration">
                        <p>   
                            <label  for="username">Create a username (4 or more characters)<span>*</span></label>
                            <input id="username" name = "username" type="text" placeholder="Create a username">
                            <div id = "checking_name"></div>
                         </p>
                         <p>   
                            <label  for="email">Enter your email address<span>*</span></label>
                            <input id="email" name = "email" type="email" placeholder="Enter a valid email address">
                            <div id = "checking_email"></div>
                         </p>
                         <p>   
                            <label  for="password">Create a Password<span>*</span></label>
                            <input id="password" name = "password" type="password" placeholder="please create a password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            <div id = "checking_password" style="margin-bottom: 5px;"></div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                <span class="sr-only">70% Complete</span>
                                </div>
                            </div>
                         </p>
                         <p>   
                            <label  for="conpass">Confirm your Password<span>*</span></label>
                            <input id="conpass" name = "conpass" type="password" placeholder="please confirm your password">
                         </p>                                     
                        <div class="login_submit">
                            <button id="signup" type="submit" value = "submit">Signup</button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>    
</div>

<script type="text/javascript">
  var refreshButton = document.querySelector(".refresh-captcha");
  refreshButton.onclick = function() {
    document.querySelector(".captcha-image").src = '<?php echo URLROOT; ?>/captcha.php?' + Date.now();
  }
</script>