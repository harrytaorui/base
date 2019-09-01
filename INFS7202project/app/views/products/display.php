<div class="container col-lg-12 col-md-12">
    <div class="py-3 text-center row">
        <h1 class="mx-auto"><?php echo $data['short_des']?></h1>
        <a class="btn btn-link pr-4" role="button" href="<?php echo URLROOT;?>/pdf/download/<?php echo $data['pid'];?>" target="_blank">
            <i class="fa fa-print"></i> Print PDF
        </a>
    </div>

    <div class="col mb-3">
        <div class="row">
            <div class="col-lg-2 col-md-1 col-sm-0">
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 mb-3">
                <h5 class="row">Product Picture: </h5>
                <div class="m-auto">
                    <img src="<?php echo URLROOT.'/images/products'.$data['imagePath']?>" class="px-3 img-fluid" style="object-fit:cover;height: 200px; max-width: 90%;" alt="Product image">
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="row mb-3">
                    <h5 class="row">Uploader:</h5>
                    <p class="w-100 mh-80"><?php echo $data['uid'];?></p>
                </div>
                <div class="row mb-3">
                    <h5 class="row">Description:</h5>
                    <p class="w-100 mh-80"><?php echo $data['long_des'];?></p>
                </div>
                <div class="row mb-3">
                    <h5 class="row">Price:</h5>
                    <p class="w-100 mh-80">$<?php echo $data['price'];?></p>
                </div>
                <div class="row mb-3">
                    <h5 class="row">Quantity: </h5>
                    <span class="w-100"><?php echo $data['quantity'];?></span>
                </div>
            </div>


    </div>
</div>
        <hr/>

<div class="container comment_area">



    <h2 class="mx-auto mb-3">Comments</h2>

    <div id="commentsArea" class="col-lg-8 col-md-12 col-sm-12 mx-auto mb-3">

        <?php
            foreach($data['comments'] as $comment) {
                echo '<div class="card mb-3">
                        <div class="card-body">
                            <div class="stars-outer"><div class="stars-inner" style="width: '.($comment->rating*20).'%;"></div></div>
                            <p class="card-text">'.$comment->comment_description.'</p>
                            <h6 class="card-title">Author: '.$comment->username.'</h6>
                            <small class="card-subtitle text-muted">Date: '.$comment->date.'</small>
                        </div>
                    </div>';
            }
        ?>

    </div>


    <?php  if(isset($_SESSION['user_id'])) : ?>
    

        <!-- Comments submission form -->
        <div class="mb-3 col-8 mx-auto">
            <div class="row mb-2">
                <label for="comment">Leave a comment :</label>
                <textarea id="commentText" class="w-100 form-control" name="comment" rows="3" type="text" style="resize: none;"></textarea>
                <div class="invalid-feedback">Please enter a comment</div>
            </div>

            <div class="row mb-3">
                <label>Rating:</label>
                <div id="ratingRadios" class="col-lg-12 form-check form-control">
                    <label class="radio-inline">
                        <input id="rating1" type="radio" value="1" name="rating">1
                    </label>
                    <label class="radio-inline">
                        <input id="rating2" type="radio" value="2" name="rating">2
                    </label>
                    <label class="radio-inline">
                        <input id="rating3" type="radio" value="3" name="rating">3
                    </label>
                    <label class="radio-inline">
                        <input id="rating4" type="radio" value="4" name="rating">4
                    </label>
                    <label class="radio-inline">
                        <input id="rating5" type="radio" value="5" name="rating">5
                    </label>
                </div>
                <span class="invalid-feedback">Please enter a rating</span>
            </div>
            <button id="submitComment" type="submit" class="btn btn-success btn-block" onclick="saveComment(<?php echo $data['pid'] ?>)">Submit</button>
        </div>
    <?php  endif; ?>

</div>
</div>


