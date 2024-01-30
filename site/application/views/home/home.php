<?php
    if(session_status() != PHP_SESSION_ACTIVE)
    session_start();
?>
<div class="text-center">
    <h1 class="fs-1">
            Hi
        <?php
            $usr =  $_SESSION[S_USER];
            echo $usr->getName() . ' ' . $usr->getSurname() . '!';
        ?>
        <?php if($_SESSION[S_USER]->getIsAdmin() == 2): ?>
            <i><b>(You're an Admin)</b></i>
        <?php endif; ?>
    </h1>
    <br>
    <div class="container-lg">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php if (!empty($bands)): ?>
                <?php foreach ($bands as $band): ?>
                    <div class="col">
                        <div class="card card-dark h-100 card-hover-black text-hover-white">
                            <a href="<?php echo URL . "bands/view/" . $band->getId() ?>" class="card-text">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #000"><?php echo $band->getName() ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </div>
    </div>
</div>

