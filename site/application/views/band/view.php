<div class="container-fluid text-center">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <br>
            <div class="p-3 rounded-4 card-dark-no-hover text-white">
                <h1>Band / <?php echo $band->getName() ?></h1>
            </div>
            <br>
            <br>
            <div  class="col-10 col-lg-6 d-block m-auto">
                <div class="p-3 rounded-4 card-dark-no-hover text-white d-flex flex-column justify-content-center">
                    <h2>Members</h2>
                    <ul class="list-group" style="border: 1px solid white; border-bottom: none">
                        <?php foreach ($members as $user): ?>
                            <li class="list-group-item card-dark" style="border-bottom: 1px solid white">
                                <?php echo $user->getName()?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <br>
                <br>
                <div class="p-3 rounded-4 card-dark-no-hover text-white d-flex flex-column justify-content-center">
                    <h2>Songs</h2>
                    <ul class="list-group" style="border: 1px solid white; border-bottom: none">
                        <?php foreach ($songs as $song): ?>
                            <li class="list-group-item card-dark" style="border-bottom: 1px solid white">
                                <a href="<?php echo URL . 'songs/view/' . $song->getId() ?>"><?php echo $song->getTitle()?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>