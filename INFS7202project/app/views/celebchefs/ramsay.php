<div class="container">
    <h1 class="mx-auto text-center my-3"><?php echo $data['title']?></h1>
    <div class="row mb-3">
        <?php foreach($data['list'] as $key=>$value): ?>
            <div class="card col-5 my-2 mx-4">
                <img class="card-img-top preview-img img-thumbnail" style="object-fit:cover;height: 200px; max-width: 100%;" src="<?php echo $data['baseurl'].$value['src']; ?>" alt="missing image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $value['title']; ?></h5>
                    <p class="card-text"><?php echo $value['desc']; ?></p>
                    <a href="<?php echo $data['baseurl'] . $value['href']; ?>" target="_blank" class="btn btn-primary">Open recipe</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>