<link rel="stylesheet" href="<?php echo URL . 'application/libs/styles/song-megacard.css'?>">
<div class="container-fluid text-center">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <br>
            <div class="nft" id="nft" style="transform: scale(.9); transition: .5s ease-out">
                <div class='main'>
                    <img class='tokenImage' src="<?php echo URL . $song->getImage() ?>" alt="AlbumArt" />
                    <div class="side">
                        <h2 class="fs-1"><?php echo $song->getTitle() ?></h2>
                        <p class='description fs-5'><?php echo $song->getAuthor()?></p>
                        <p class='description'><?php echo $song->getAlbum()?></p>
                        <hr />
                        <div class="d-flex justify-content-evenly">
                            <p><?php echo $song->getYear() ?></p>
                            <p><?php echo $song->getGenre() ?></p>
                            <p><?php echo $song->getBpm() ?>BPM</p>
                        </div>
                        <hr />
                        <p><?php echo $song->getDescription() ?></p>
                        <hr />
                        <a class="btn btn-dark mt-3" href="<?php echo URL . 'songs/' ?>"><i class="bi bi-arrow-left"></i><br>Go Back</a>
                        <a class="btn btn-dark mt-3"" href="<?php echo URL . 'songs/text/' . $songId ?>"><i class="bi bi-eye"></i><br>See the text</a>
                        <a class="btn btn-dark mt-3"" href="<?php echo URL . 'songs/listen/' . $songId ?>"><i class="bi bi-vinyl"></i><br>Listen to this song</a>
                        <a class="btn btn-dark mt-3"" href="<?php echo URL . 'songs/video/' . $songId ?>"><i class="bi bi-play-circle"></i><br>Watch the video</a>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
<script>
    document.body.onload = function (){
        let container = document.getElementById('nft');
        container.style.transform = "scale(1)";
    };

</script>