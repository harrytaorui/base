<div class="row">

    <?php require_once APPROOT.'/views/includes/sidenav.php'; ?>

    <!-- Create Product Form Area -->
    <div class="container col-lg-8 col-md-10 col-sm-12">
        <div class="py-3 text-center">
            <h1>Edit Product</h1>
        </div>
        <form class="col" action="<?php echo URLROOT;?>/Products/edit/<?php echo $data['pid'];?>" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-5">
                    <label for="imgPreview">Product Picture: </label>
                    <img src="<?php echo URLROOT.'/images/products'.$data['imagePath'];?>" alt="image missing" style="object-fit:cover;height:200px;width:90%;">
                    <small class="" style="color: #dc3545;"><?php echo $data['img_error'] ?></small>
                </div>
                <div class="col-7">
                    <div class="row form-group">
                        <label for="ProductName">Product Name:</label>
                        <input name="ProductName" type="text" class="form-control <?php echo (!empty($data['ProductName_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['short_des']?>">
                        <span class="invalid-feedback"><?php echo $data['ProductName_error'] ?></span>
                    </div>
                    <div class="row form-group">
                        <label for="desc">Description:</label>
                        <textarea name="desc" rows="4" class="form-control <?php echo (!empty($data['description_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['long_des']?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_error'] ?></span>
                    </div>
                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="col form-group form-inline">
                    <label for="quantity" class="pr-2">Quantity: </label>
                    <input name="quantity" type="number" placeholder="Please enter quantity" class="w-50 form-control form-control-sm <?php echo (!empty($data['quantity_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['quantity']?>">
                    <span class="invalid-feedback"><?php echo $data['quantity_error'] ?></span>
                </div>
                <div class="col form-group form-inline">
                    <label for="price" class="pr-2">Price: </label>
                    <input name="price" type="number" step="0.01" class="w-50 form-control form-control-sm <?php echo (!empty($data['price_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['price']?>">
                    <span class="invalid-feedback"><?php echo $data['price_error'] ?></span>
                </div>
            </div>
            <hr/>
            <div class="row">
                <button class="btn btn-success btn-lg ml-auto mb-5" type="submit">Save</button>
            </div>
        </form>
    </div>


</div>
