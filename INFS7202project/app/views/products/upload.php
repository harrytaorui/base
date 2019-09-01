<div class="row">

    <?php require_once APPROOT.'/views/includes/sidenav.php'; ?>

    <div class="container col-lg-8 col-md-10 col-sm-12 border-left">

        <div class="py-3 text-center col-12">
            <h1>Upload product you want to sell</h1>
        </div>

        <form class="col" action="<?php echo URLROOT; ?>/Products/upload" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <label class="image_upload" for="imgPreview">Product Picture:
                    <div class="previewPic m-auto">
                        <input id="imgPreview" name="imgPreview" type="file" accept="image/jpeg, image/png">
                    </div>
                     </label>
                    <small class="" style="color: #dc3545;"><?php echo $data['img_error'] ?></small>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mr-4">
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
                <button class="btn btn-success btn-lg mb-5 col-8" type="submit">Save</button>
            </div>
        </form>
    </div>


</div>


<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/recipes/create.css">
