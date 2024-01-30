<link rel="stylesheet" href="<?php echo URL . 'application/libs/styles/song-card.css'?>">
<h1 class="text-center">Your songs</h1>
<div class="sticky-top" style="top: 50px">
     <div class="d-flex justify-content-center mt-5">
         <form class="search-box" method="get">
             <?php if(isset($_GET['song'])): ?>
                 <input type="text" name="song" placeholder=" " value="<?php echo $_GET['song']?>"/>
             <?php else: ?>
                 <input type="text" name="song" placeholder=" "/>
             <?php endif; ?>
             <button type="reset" onclick="window.open('<?php echo URL . 'songs'?>', '_SELF')"></button>
         </form>
     </div>
 </div>
<div class="d-flex flex-column justify-content-center mt-5"><div class="container mt-5">
        <p class="text-center fs-5"><i class="bi bi-check-circle-fill"></i> Found <?php echo count($songs)?> result/s!</p>
        <div class="d-flex justify-content-center m-4">
            <a class="btn btn-dark" href="<?php echo URL . 'songs/addSong' ?>">Add a song</a>
        </div>
        <?php if(substr($msg, 0, 4) === "err_"): ?>
            <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-diamond-fill me-3"></i>
                <div>
                    <?php switch ($msg):
                        case "err_song_not_inserted": ?>
                            <span>The song was not inserted. Unknown error. Please contact the developers.</span>
                            <?php break; ?>
                        <?php endswitch; ?>
                </div>
                <a type="button" class="btn-close float-end" href="<?php echo URL . 'songs'?>" aria-label="Close"></a>
            </div>
        <?php elseif(substr($msg, 0, 4) ===  "succ"): ?>
            <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-3"></i>
                <div>
                    <?php switch ($msg):
                        case "succ_song_inserted": ?>
                            <span>Song added!</span>
                            <?php break; ?>
                        <?php endswitch; ?>
                </div>
                <a type="button" class="btn-close float-end" href="<?php echo URL . 'songs'?>" aria-label="Close"></a>
            </div>
        <?php endif; ?>
        <div class="d-flex flex-wrap justify-content-around">
            <?php foreach ($songs as $song): ?>
                <div class="nft" style="cursor: pointer" id="card_<?php echo $song->getId() ?>"
                     onclick="openSong('<?php echo URL . 'songs/view/' . $song->getId() ?>', 'card_<?php echo $song->getId()?>')">
                    <div class='main'>
                        <img class='tokenImage' src="<?php echo URL . $song->getImage() ?>" alt="AlbumArt" />
                        <h2 class="fs-3"><?php echo $song->getTitle() ?></h2>
                        <p class='description fs-5'><?php echo $song->getAuthor()?></p>
                        <p class='description'><?php echo $song->getAlbum()?></p>
                        <hr />
                        <div class="d-flex justify-content-between">
                            <p><?php echo $song->getYear() ?></p>
                            <p><?php echo $song->getGenre() ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p><?php echo $song->getBpm() ?>BPM</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    function openSong(url, id){
        document.getElementById(id).style.zIndex = "1000";
        document.getElementById(id).style.transition = "1s ease-in";
        document.getElementById(id).style.transform = "scale(1.4)";
        setTimeout(() => {
            window.open(url, '_SELF');
        }, 500);
    }
</script>