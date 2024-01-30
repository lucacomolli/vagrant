<?php
function compare_objects($obj_a, $obj_b) {
    return $obj_a->getId() - $obj_b->getId();
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card card-dark-no-hover border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <h1 class="text-center mb-5 fw-light"><i class="bi bi-music-note-list"></i> User's Band Manager <i class="bi bi-music-note-list"></i></h1>
                    <h3><?php echo $user->getName()?>'s Bands</h3>
                    <ul class="list-group mb-4" style="border: 1px solid white">
                        <?php foreach ($bands as $band): ?>
                            <li class="list-group-item card-dark d-flex align-items-center justify-content-between">
                                <?php echo $band->getName()?>
                                <a class="btn btn-danger float-end"
                                   href="<?php echo URL . 'administration/removeUserFromBand/' . $user->getId() . '/' . $band->getId() ?>">Remove user from this band</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <h3>Add user to a band</h3>
                    <form action="<?php echo URL . 'administration/addUserToBand'?>" method="post">
                        <input type="hidden" name="userId" value="<?php echo $user->getId()?>">
                        <div class="form-floating mb-3" id="sband">
                            <select required class="form-select card-dark-no-hover" name="bandId">
                                <option disabled selected value="-1">Click me to expand</option>
                                <optgroup label="Bands / Authors">
                                    <?php foreach (array_udiff(BandMapper::getAll(), $bands, 'compare_objects') as $band):?>
                                        <option value="<?php echo $band->getId() ?>"><?php echo $band->getName() ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <label for="sband">Select a Band or an Author</label>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Add to Band!">
                        <a class="btn btn-danger" href="<?php echo URL . 'administration'?>">Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>