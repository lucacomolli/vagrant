<style>
    div.main {
        width: 100%;
        height: 92vh;
    }

    div.video-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    video {
        display: block;
        max-width: 80%;
        max-height: 80%;
    }
</style>

<div class="main">
    <div class="video-wrapper">
        <video autoplay controls>
            <source src="<?php echo URL . $song->getVideo() ?>" type="video/mp4">
        </video>
    </div>
</div>