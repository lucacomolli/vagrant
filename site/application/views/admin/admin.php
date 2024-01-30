<div class="container w-50 m-auto">
    <h1 class="text-center">Administration area</h1>
    <br>
    <br>
    <?php if(substr($msg, 0, 4) === "err_"): ?>
        <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-diamond-fill me-3"></i>
            <div>
                <?php switch ($msg):
                    case "err_select_band": ?>
                        <span>Please select a valid band!</span>
                    <?php break; ?>
                    <?php case "err_usr_not_deleted_yourself": ?>
                        <span>You can't delete yourself!</span>
                    <?php break; ?>
                    <?php case "err_usr_not_created": ?>
                        <span>Error, user not created! Please contact a developer!</span>
                    <?php break; ?>
                    <?php case "err_band_not_created": ?>
                        <span>Error, band not created! Please contact a developer!</span>
                    <?php break; ?>
                    <?php case "err_invalid_band_or_user": ?>
                        <span>The band or user that you have selected is not valid.</span>
                        <?php break; ?>
                <?php endswitch; ?>
            </div>
            <a type="button" class="btn-close float-end" href="<?php echo URL . 'administration'?>" aria-label="Close"></a>
        </div>
    <?php elseif(substr($msg, 0, 4) ===  "succ"): ?>
        <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-3"></i>
            <div>
                <?php switch ($msg):
                    case "succ_usrband_added": ?>
                        <span>User added to the Band!</span>
                    <?php break; ?>
                    <?php case "succ_usr_created": ?>
                        <span>User created!</span>
                    <?php break; ?>
                    <?php case "succ_band_created": ?>
                        <span>Band created!</span>
                    <?php break; ?>
                    <?php case "succ_song_deleted": ?>
                        <span>Song deleted!</span>
                    <?php break; ?>
                    <?php case "succ_band_deleted": ?>
                        <span>Band deleted!</span>
                    <?php break; ?>
                    <?php case "succ_usr_deleted": ?>
                        <span>User deleted!</span>
                    <?php break; ?>
                    <?php case "succ_usr_removed_from_band": ?>
                        <span>User removed from band!</span>
                    <?php break; ?>
                <?php endswitch; ?>
            </div>
            <a type="button" class="btn-close float-end" href="<?php echo URL . 'administration'?>" aria-label="Close"></a>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-center mb-2">
        <h2 class="text-center">Users</h2>
        <pre>     </pre>
        <a href="<?php echo URL . 'administration/add/' . ADD_USER?>" class="btn btn-dark">Add a User</a>
    </div>
    <table class="table table-dark align-middle">
        <thead>
            <tr>
                <th scope="col"><i class="bi bi-key"></i></th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Email</th>
                <th scope="col">Auth Level</th>
                <th scope="col" style="text-align: right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->getId() ?></td>
                    <td><?php echo $user->getName() ?></td>
                    <td><?php echo $user->getSurname() ?></td>
                    <td><?php echo $user->getEmail() ?></td>
                    <td><?php echo $user->getIsAdmin() == 1 ? 'Admin' : 'User' ?></td>
                    <td style="text-align: right">
                        <a href="<?php echo URL . 'administration/userBands/' . $user->getId()?>" class="btn btn-secondary">User's band manager</a>
                        <a href="<?php echo URL . 'administration/delete/' . DELETE_USER . '/' . $user->getId()?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <div class="d-flex justify-content-center mb-2">
        <h2 class="text-center">Bands</h2>
        <pre>     </pre>
        <a href="<?php echo URL . 'administration/add/' . ADD_BAND?>" class="btn btn-dark">Add a Band</a>
    </div>
    <table class="table table-dark align-middle">
        <thead>
        <tr>
            <th scope="col"><i class="bi bi-key"></i></th>
            <th scope="col">Name</th>
            <th scope="col" style="text-align: right">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bands as $band): ?>
            <tr>
                <td><?php echo $band->getId() ?></td>
                <td><?php echo $band->getName() ?></td>
                <td style="text-align: right">
                    <a href="<?php echo URL . 'administration/delete/' . DELETE_BAND . '/' . $band->getId()?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <div class="d-flex justify-content-center mb-2">
        <h2 class="text-center">Songs</h2>
    </div>
    <table class="table table-dark align-middle">
        <thead>
        <tr>
            <th scope="col">Band</th>
            <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        <?php if($bands != null): ?>
            <?php foreach ($bands as $band): ?>
                <tr>
                    <td><?php echo $band->getName() ?></td>
                    <td>
                        <ul>
                            <?php if(array_key_exists($band->getId(), $songs)): ?>
                                <?php foreach($songs[$band->getId()] as $song): ?>
                                    <li style="list-style-type: none">
                                        <?php echo $song->getTitle()?>
                                        <a href="<?php echo URL . 'administration/delete/' . DELETE_SONG . '/' . $song->getId()?>" class="btn btn-danger float-end"><i class="bi bi-x-circle-fill"></i></a>
                                    </li>
                                    <br>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>