<div class="container">

  <div class="row pt-4">

    <h1 class="col-lg-12 text-center">Search for Products</h1>

    <!-- Search bar -->
    <div class="col-lg-12">

    <form action="<?php echo URLROOT;?>/search" method="GET">
        <div class="input-group mb-3">
            <input id="search-bar" name="query" type="text" class="form-control" placeholder="Search for..." value="<?php echo $data['query'] ?>">
            <button type="submit"><i class="ion-ios-search-strong"></i></button>
        </div>
    </form>
  </div>
  <div class="col-lg-12">
    <p>Suggestions: <span id="hint"></span></p>
  </div>
  </div>
    <h3>Search results :</h3>
    <!-- Display output of search -->
    <div class="list-group" id="search-items">
        <?php
            foreach($data['Products'] as $item) {
                echo '<a class="list-group-item list-group-item-action flex-column mb-3" href="'.URLROOT.'/Products/display/'. $item->pid .'">
                <div class="row">
                    <div class="">
                        <img class="preview-img img-thumbnail" style="object-fit:cover;height: 200px; max-width: 90%;" src="'.URLROOT.'/images/products'.$item->imagePath.'" alt="Preview: '. $item->imagePath .'">
                    </div>
                    <div class="col">
                        <div class="d-flex w-100 justify-content-between">
                            <h4>' . $item->short_des .'</h4>
                        </div>
                        <p>' . $item->long_des . '</p>
                    </div>
                </div></a>';
            }
        ?>
    </div>



</div>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/search/search.css">
