<div class="jumbotron">
    <h1><?php echo $data['title']?></h1>

    <p class='lead'> APPROOT: <?php echo APPROOT;?></p>
    <p class='lead'> URLROOT: <?php echo  URLROOT;?></p>

    <a class="btn btn-primary" href="<?php echo URLROOT; ?>/home" role="button">Home</a>

    <h3>Users: </h3>
    <ul class="list-group">
        <?php foreach($data['users'] as $user) : ?>
            <li class="list-group-item w-50"><?php echo $user->user_name; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
