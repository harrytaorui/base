<div class="container-fluid">
<div class="row content">

<?php require_once APPROOT.'/views/includes/sidenav.php'; ?>
    <div class="col-lg-6">

      <h3 class="text-center"><u> Edit Profile</u></h3>
      <div class="col-lg-12">
      <?php flash('update_success'); ?>
      <?php flash('verify_success'); ?>
      <?php flash('verify_fail'); ?>
      </div>

      <form class = "editProfile" action="<?php echo URLROOT; ?>/account/edit" method="POST">     

          <p>   
            <label class= "col-lg-12" for="user_name">Username<span>*</span></label>
            <div class="col-lg-12">
              <input type="text" name="username" value="<?php echo $data['username'] ?>"/>
            </div>
         </p>

         <p>   
            <label class= "col-lg-12" for="pass_word">Email <span>*</span></label>
            <div class="col-lg-12">
              <input type="text" name="email" value="<?php echo $data['email'] ?>"/>
            </div>
         </p>


        <p>   
            <label class= "col-lg-12" for="pass_word">Email Verification <span>*</span></label>
            <div class="col-lg-12">
            <a class="text-center mt-auto btn btn-primary <?php echo $data['activated']==1? "disabled": ""; ?>" data-toggle="modal" data-target="#exampleModal" href="#"><?php echo $data['activated']==1? "Email Verified!": "Verify your email"; ?></a>
            </div>
        </p>


        <div class="col-lg-12 mt-3 text-right">
          <button type="submit" class="btn btn-primary mr-4" value="validateLogin"> Save </button>
        </div>
      </form>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="<?php echo URLROOT; ?>/account/verify" method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Email Verification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-lg-12">Enter your verification code</label>
                  <div class="col-lg-12">
                    <div class="input-group">
                      <input type="number" name="verify_code" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" id="nextBtn" class="btn btn-primary">Verify</button>

              </div>
            </div>
          </form>
        </div>
        </div>

        <?php
        ?>

    </div>
  </div>
</div>
</div>
