<?php
$image = URL . $song->getImage();
$audio = URL . $song->getAudio();
?>
<link rel="stylesheet" href="<?php echo URL . 'application/libs/styles/music-player.css'?>">
<link rel="icon" type="image/x-icon" href="<?php echo $image?>">
<style>
    .vinyl{
        background-image: url("<?php echo URL . 'application/libs/images/vinyl.png'?>");
    }

    .album-art{
        <?php if(str_contains($image, ".png")): ?>
            background-image: url("<?php echo $image?>");
        <?php else: ?>
            background-image: url("<?php echo URL . 'application/libs/images/music.jpg'?>");
        <?php endif; ?>
    }

    canvas{
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        filter: blur(100px);
        transition: 1.25s cubic-bezier(.52,.2,.33,1);
        opacity: 0;
    }


    @media screen and (max-width: 621px){
        .music-body{
        <?php if(str_contains($image, ".png")): ?>
            background-image: url("<?php echo $image?>");
        <?php else: ?>
            background-image: url("<?php echo URL . 'application/libs/images/music.jpg'?>");
        <?php endif; ?>
        }
    }
</style>
<div class="loader d-flex align-items-center justify-content-center h-75" id="loader">
    <div class="p-5 background bg-dark rounded-5 text-white">
        <h1>Audio Player is now loading...</h1>
        <h4>Please wait</h4>
    </div>
</div>
<div class="main-container" style="display: none" id="player">
    <div class="music-body"></div>
    <div class="music-player-container is-playing">
        <div class="music-player">
            <div class="player-content-container">
                <h1 class="artist-name"><?php echo $song->getTitle() ?></h1><!--  /.track-title -->
                <i><h2 class="album-title"><?php echo $song->getAlbum() ?></h2></i><!--  /.album-title -->
                <h2 class="song-title"><?php echo $song->getAuthor() . ', ' . $song->getYear() ?></h2><!--  /.song-title -->
                <div class="music-player-controls">
                    <div class="control-play is-playing" id="play_icons" onclick="playToggle()">
                        <i class="bi bi-play-fill" style="display: none"></i>
                        <i class="bi bi-pause-circle-fill" style="display: block"></i>
                    </div><!--  /.control-play -->
                </div><!--  /.music-player-controls -->
            </div><!--  /.player-content-container -->
        </div><!--  /.music-player -->

        <div class="album">
            <div class="album-art" id="cover_art"></div><!--  /.album-art -->
            <div class="vinyl"></div><!--  /.vinyl -->
        </div><!--  /.album-art -->
    </div><!--  /.music-player -->
</div>

<audio src="<?php echo $audio?>" hidden="hidden" id="audioplayer"></audio>
<script src="<?php echo URL . 'application/libs/colorthief/color_thief.js'?>"></script>
<script>

    let ctx;
    let backCanvas;
    let palette;
    const colorThief = new ColorThief();
    let circles = [];
    let imgElement;

    document.addEventListener("DOMContentLoaded", function() {

        // Pause/Play functionality
        var playButton = document.querySelector('.control-play');
        var album = document.querySelector('.album');
        navigator.mediaSession.metadata = new MediaMetadata({
            title: "<?php echo $song->getTitle() ?>",
            artist: "<?php echo $song->getAuthor() ?>",
            album: "<?php echo $song->getAlbum() ?>",
            artwork: [
                {
                    src: "<?php echo $image?>",
                    sizes: "96x96",
                    type: "image/png"
                },
                {
                    src: "<?php echo $image?>",
                    sizes: "128x128",
                    type: "image/png"
                },
                {
                    src: "<?php echo $image?>",
                    sizes: "192x192",
                    type: "image/png"
                },
                {
                    src: "<?php echo $image?>",
                    sizes: "256x256",
                    type: "image/png"
                },
                {
                    src: "<?php echo $image?>",
                    sizes: "512x512",
                    type: "image/png"
                },
                {
                    src: "<?php echo $image?>",
                    sizes: "1024x1024",
                    type: "image/png"
                }
            ]
        });
    });

    imgElement = new Image();
    imgElement.src = "<?php echo $image?>";
    imgElement.onload = initBackground;

    window.onresize = function (){
        backCanvas.width = window.innerWidth;
        backCanvas.height = window.innerHeight;
    };

    setInterval(() => {
        document.querySelector("canvas").style.opacity = "0";
        setTimeout(() => {
            document.querySelector("canvas").remove();
            initBackground();
        }, 1250);
    }, 60000);

    function initBackground(){
        document.getElementById('player').style.display = "block";
        document.getElementById('loader').style.opacity = "0";
        palette = colorThief.getPalette(imgElement, Math.floor(Math.random() * 20) + 10);
        backCanvas = document.createElement('canvas');
        ctx = backCanvas.getContext('2d');
        backCanvas.width = window.innerWidth;
        backCanvas.height = window.innerHeight;
        document.body.appendChild(backCanvas);
        init();
        animate();
        setTimeout(() => {
            document.querySelector("canvas").style.opacity = "100%";
        }, 10);
    }

    function playToggle(){
        var musicPlayerContainer = document.querySelector('.music-player-container');
        musicPlayerContainer.classList.toggle('is-playing');
        if(musicPlayerContainer.classList.contains('is-playing')){
            document.getElementById('play_icons').children[0].style.display = "none";
            document.getElementById('play_icons').children[1].style.display = "block";
            playSong();
        }else{
            document.getElementById('play_icons').children[0].style.display = "block";
            document.getElementById('play_icons').children[1].style.display = "none";
            pauseSong();
        }
    }

    function playSong(){
        document.getElementById('audioplayer').play();
    }

    function pauseSong(){
        document.getElementById('audioplayer').pause();
    }

    function Circle() {
        this.x = Math.random() * backCanvas.width;
        this.y = Math.random() * backCanvas.height;
        this.dx = (Math.random() - 0.5) * 10;
        this.dy = (Math.random() - 0.5) * 10;
        this.radius = backCanvas.width / 8;
        this.color = palette[Math.floor(Math.random() * palette.length)];

        this.draw = function() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
            ctx.fillStyle = rgbToHex(this.color);
            ctx.fill();
        }

        this.update = function() {
            if (this.x + this.radius > backCanvas.width || this.x - this.radius < 0) {
                this.dx = -this.dx;
            }

            if (this.y + this.radius > backCanvas.height || this.y - this.radius < 0) {
                this.dy = -this.dy;
            }

            this.x += this.dx / 5;
            this.y += this.dy / 5;

            this.draw();
        }
    }

    function init() {
        circles = [];

        for (let i = 0; i < Math.floor(Math.random() * 100) + 75; i++) {
            circles.push(new Circle());
        }
    }

    function animate() {
        ctx.fillRect(0, 0, backCanvas.width, backCanvas.height);

        for (let i = 0; i < circles.length; i++) {
            circles[i].update();
        }

        requestAnimationFrame(animate);
    }

    function rgbToHex(rgb) {
        let hex = "#";
        for (let i = 0; i < 3; i++) {
            let component = rgb[i].toString(16);
            if (component.length === 1) {
                component = "0" + component;
            }
            hex += component;
        }
        return hex;
    }

    playToggle();

</script>