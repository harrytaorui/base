
<div class="container pb-4 mb-4">
  <h1 class="text-center p-4">Submit Enquiries </h1>
  <?php flash('email_success');?>
	<form action="<?php echo URLROOT; ?>/home/about" method="POST">
		<div class="form-group">
			<label>Subject:</label>
			<input type="text" name="subject" class="form-control <?php echo (!empty($data['subject_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['subject']?>">
      <span class="invalid-feedback"><?php echo $data['subject_error'] ?></span>
    </div>
		<div class="form-group">
			<label>Message:</label>
      <textarea type="text" name="body" class="form-control <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']?></textarea>
      <span class="invalid-feedback"><?php echo $data['body_error'] ?></span>
    </div>
    <div class="form-group">
			<label>Your E-mail:</label>
      <input type="text" name="replyTo" class="form-control <?php echo (!empty($data['replyTo_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['replyTo']?>">
      <span class="invalid-feedback"><?php echo $data['replyTo_error'] ?></span>
		</div>
		<input type="submit" value="Send" class="btn btn-success btn-block">
	</form>
</div>

<div class="container pb-4">
  <div class="row">
    <div class="col-12">
      <h1 class="text-center p-4">Our office :</h1>
    </div>
    <div class="col-12">
      <h3 class="text-center">The Recipes Project</h3>
      <h3 class="text-center">130 William St, Brisbane City</h3>
      <h3 class="text-center">QLD, 4000</h3>
      <h3 class="text-center">Mon - Fri : 9:00AM - 5:00PM </h3>
    </div>
  </div>

</div>
<div id="map"></div>


<script>
      function initMap() {
        var brisbane = {lat: -27.470125, lng: 153.021072};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: brisbane
        });
        var marker = new google.maps.Marker({
          position: brisbane,
          map: map
        });
      }
</script>
<!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwz6vxPaoNFbI1bVZ04QPHYaezuc176tE&callback=initMap">
</script> -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo APIKEY_MAPS; ?>&callback=initMap">
</script>
