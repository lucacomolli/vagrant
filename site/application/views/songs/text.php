<h1 class="text-center"><?php echo $band . ', ' . $song->getTitle()?> | <b><?php echo $song->getBpm()?> BPM</b></h1>
<p class="text-center">Instruments: <?php echo $song->getInstruments() ?></p>
<hr class="w-50 m-auto mt-4">
<div class="col-lg-3 col-md-4 col-sm-6 mx-auto text-justify">
    <p>
        <?php
        $text = preg_split('/\n|\r\n/', $song->getText());
        $notes = explode("[LN_END]", SongMapper::getNotes($songId));
        $idx = 0;
        ?>
        <?php if($action == "addnotes"): ?>
            <form class="d-print-none" method="post" action="<?php echo URL . 'songs/saveNotes/' . $songId ?>">
                <?php foreach ($text as $line): ?>
                    <p><?php echo $line ?></p>
                    <input class="form-control card-dark" value="<?php echo $notes[$idx] ?? "" ?>" name="note_<?php echo $idx?>" type="text" style="width: 100%; color: white">
                    <?php $idx++ ?>
                <?php endforeach; ?>
                <input class="btn btn-dark mt-3" type="submit" value="Save notes">
            </form>
        <?php elseif($action == "viewnotes"): ?>
            <div class="d-flex justify-content-around sticky-top mb-5 d-print-none" style="z-index: 0">
                <a class="btn btn-dark mt-4" href="<?php echo URL . 'songs/view/' . $songId ?>"><i class="bi bi-arrow-left"></i> Go Back</a>
                <a class="btn btn-dark mt-4" href="<?php echo URL . 'songs/text/' . $songId . '/addnotes'?>">Add notes</a>
                <a class="btn btn-dark mt-4" href="<?php echo URL . 'songs/text/' . $songId?>">Hide notes</a>
                <button class="btn btn-dark mt-4" onclick="window.print()">Print with notes</button>
            </div>
            <?php foreach ($text as $line): ?>
                <p><?php echo $line ?></p>
                <p class="text-secondary"><?php echo $notes[$idx] ?? "" ?></p>
                <?php $idx++ ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="d-flex justify-content-around sticky-top mb-5 d-print-none" style="z-index: 0">
                <a class="btn btn-dark mt-4" href="<?php echo URL . 'songs/view/' . $songId ?>"><i class="bi bi-arrow-left"></i> Go Back</a>
                <a class="btn btn-dark mt-4" href="<?php echo URL . 'songs/text/' . $songId . '/addnotes'?>">Add notes</a>
                <a class="btn btn-dark mt-4" href="<?php echo URL . 'songs/text/' . $songId . '/viewnotes'?>">View notes</a>
                <button class="btn btn-dark mt-4" onclick="window.print()">Print without notes </button>
            </div>
            <?php foreach ($text as $line): ?>
                <p><?php echo $line ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </p>
</div>
