
<header>
    <div class="header_bot">
        <div class="container">
            <div class="row align-items-center">
                <div class= "col-lg-12 col-md-12">
                    <?php flash('logout_success'); ?>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="menu">
                        <div class="menu_title">
                            <h2 class="menu_toggle"> All categories</h2>
                        </div>
                        <div class="inner_menu">
                            <ul>
                                <li><a>Appliances</a></li>
                                <li><a>Audio & Stereo</a></li>
                                <li><a>Baby & Kids Stuff</a></li>
                                <li><a>Cameras, Camcorders & Studio Equipment</a></li>
                                <li><a>Cars</a></li>
                                <li><a>Clothes & Accessories</a></li>
                                <li><a>Home & Garden</a></li>
                                <li><a>Health & Beauty</a></li>
                                <li><a>Music,Films,Books & Games</a></li>
                                <li><a>Phones</a></li>
                                <li><a>More</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="sample">
                        <img src="<?php echo URLROOT;?>/images/sample.jpg" alt="sample">
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section>
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner_thumb">
                        <a href="#"><img src="<?php echo URLROOT;?>/images/banner1.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="products">
        <div class="container">
            <div class="row mt-4 pl-4 pr-4">
                <div class="col-lg-12">
                    <h3> <u> New product </u> </h3>
                </div>
                <div id="feature-cards" class="card-group animated fadeInRight">
                    <?php for ($x = 0; $x < sizeof($data['newProduct']); $x++): ?>
                        <div class="col-lg-4 mt-4 d-flex">
                            <div class="card d-flex w-100" id="featured-card">
                            <a href="<?php echo URLROOT.'/products/display/'.$data['newProduct'][$x]->pid?>">
                                <img class="card-img-top" src="<?php echo URLROOT.'/images/products'. $data['newProduct'][$x]->imagePath ?>" alt="Card image cap" style="object-fit:cover;height:200px">
                                <div class="card-body">
                                    <h5 class="card-title ml-auto"><?php echo $data['newProduct'][$x]->short_des ?>
                                        <span id="product<?php echo $x ?>">
                                            <div class="stars-outer"><div class="stars-inner"></div></div>
                                        </span>
                                    </h5>
                                <p class="card-text"><?php echo $data['newProduct'][$x]->long_des ?></p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                                </a>
                            </div>
                        </div>
                    <?php endfor;?>
                </div>
            </div>
        </div>
    </div>
    <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="banner_thumb">
                            <a href="#"><img src="<?php echo URLROOT?>/images/banner2.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php require APPROOT . '/views/includes/footer.php'; ?>

<script>
  document.addEventListener('DOMContentLoaded',getRatings());

function getRatings(){
    var jArray= <?php echo json_encode($data['average']); ?>;
    const ratings = {
        product0: jArray[0],
        product1: jArray[1],
        product2: jArray[2],
        product3: jArray[3],
        product4: jArray[4],
        product5: jArray[5],
    }

    const totalStars = 5.0;
    for(let rating in ratings){
        if (ratings[rating] != null) {
        let ratingBar = document.getElementById(`${rating}`).getElementsByClassName("stars-inner")[0];

        var starPercentage = (ratings[rating] / totalStars) * 100;
        // let starPercentageRounded = `${Math.round(starPercentage /10 ) * 10}%`;
        ratingBar.style.width = `${Math.round(starPercentage /10 ) * 10}%`;
        }
    }

}
</script>
