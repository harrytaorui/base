<div class="container-fluid">

<div class="row content">

    <?php require_once APPROOT.'/views/includes/sidenav.php'; ?>

    <div class="col-lg-8">
      <div class="row">
        <div class="col-lg-10 text-center"  >
            <h3> <u> My Products </u> </h3>

            <?php flash('delete_success');?>
            <?php flash('upload_success');?>
        </div>
      </div>

      <div class="row">

        <?php foreach($data['products'] as $product): ?>
          <div class="col-lg-5 mt-3 mb-3 text-center d-flex">
            <div class="card" style="width: 25rem;">
              <img class="card-img-top" src="<?php echo URLROOT.'/images/products/'.$product['imagePath'];?>" alt="Card image cap" style="object-fit:cover;height:200px;">
              <div class="card-body">
                <h5 class="card-title"><?php echo $product['short_des'];?></h5>
                <p class="card-text"><?php echo $product['long_des'];?></p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <a href="<?php echo URLROOT.'/products/edit/'. $product['pid'];?>" class="card-link">edit</a>
                  <a href="<?php echo URLROOT.'/account/index?delete='. $product['pid'];?>" class="card-link">delete</a>
                </li>
              </ul>
            </div>
          </div>
        <?php endforeach;?>

      </div>
    </div>
    </div>

  </div>
</div>
