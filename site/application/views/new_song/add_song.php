<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card card-dark-no-hover border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <h1 class="text-center mb-5 fw-light"><i class="bi bi-music-note-list"></i> New Song <i class="bi bi-music-note-list"></i></h1>
                    <?php if(str_starts_with($error, "err_")): ?>
                        <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                            <i style="color: black !important;" class="bi bi-exclamation-diamond-fill me-3"></i>
                            <div>
                                <?php switch ($error):
                                    case "err_fillall": ?>
                                        <span style="color: black !important;">Please fill all fields</span>
                                        <?php break; ?>
                                    <?php case "err_numericfields": ?>
                                        <span style="color: black !important;">Please write numbers in numeric fields, not strings!</span>
                                        <?php break; ?>
                                    <?php case "err_audiomissing": ?>
                                        <span style="color: black !important;">Please add also the MP3 file of the new song!</span>
                                        <?php break; ?>
                                    <?php case "err_videomissing": ?>
                                        <span style="color: black !important;">Please add also the MP4 file of the new song!</span>
                                        <?php break; ?>
                                    <?php case "err_artworkmissing": ?>
                                        <span style="color: black !important;">Please add also the artwork PNG file of the new song!</span>
                                        <?php break; ?>
                                    <?php case "err_upload_unknown": ?>
                                        <span style="color: black !important;">Un unknown error occurred during file upload. Please retry.</span>
                                        <?php break; ?>
                                    <?php case "err_mediamismatch": ?>
                                        <span style="color: black !important;">Please check that your files are MP3, MP4 or PNG!</span>
                                        <?php break; ?>
                                    <?php case "err_fileexists": ?>
                                        <span style="color: black !important;">A file already exists. Please rename all files!</span>
                                        <?php break; ?>
                                    <?php case "err_filetoolarge": ?>
                                        <span style="color: black !important;">One or more files are too large. Max: 10MB!</span>
                                        <?php break; ?>
                                    <?php endswitch; ?>
                            </div>
                            <a style="color: black !important;" type="button" class="btn-close float-end" href="<?php echo URL . 'songs/addSong'?>" aria-label="Close"></a>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo URL . 'songs/uploadSong'?>" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" id="sname" name="songName" placeholder="">
                            <label for="sname">Song Title</label>
                        </div>
                        <div class="form-floating mb-3" id="sband">
                            <select required class="form-select card-dark-no-hover" name="songBand">
                                <option disabled selected value="-1">Click me to expand</option>
                                <optgroup label="Bands / Authors">
                                    <?php foreach ($bands as $band):?>
                                        <option value="<?php echo $band->getId() ?>"><?php echo $band->getName() ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <label for="sband">Select a Band or an Author</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="number" class="form-control card-dark-no-hover" id="syear" name="songYear" placeholder="">
                            <label for="syear">Year</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" id="salbum" name="songAlbum" placeholder="">
                            <label for="salbum">Album</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" id="sdesc" name="songDesc" placeholder="">
                            <label for="sdesc">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea required style="height: 200px" class="form-control card-dark-no-hover" id="stext" name="songText" placeholder=""></textarea>
                            <label for="stext">Text</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="number" class="form-control card-dark-no-hover" id="sbpm" name="songBpm" placeholder="">
                            <label for="sbpm">BPM</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" id="sgenre" name="songGenre" placeholder="">
                            <label for="sgenre">Genre(s)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" id="sinstruments" name="songInstruments" placeholder="">
                            <label for="sinstruments">Instruments</label>
                        </div>
                        <br>
                        <hr class="my-4">
                        <br>
                        <div class="form-floating mb-3">
                            <p>Audio (MP3 only MAX 100MB)</p>
                            <input required accept=".mp3" type="file" class="form-control card-dark-no-hover" id="saudio" name="songAudio" placeholder="">
                        </div>
                        <br>
                        <div class="form-floating mb-3">
                            <p>Video (MP4 only MAX 100MB)</p>
                            <input required accept=".mp4" type="file" class="form-control card-dark-no-hover" id="svideo" name="songVideo" placeholder="">
                        </div>
                        <br>
                        <div class="form-floating mb-3">
                            <p>Album Artwork (PNG only MAX 100MB)</p>
                            <input required accept=".png" type="file" class="form-control card-dark-no-hover" id="svideo" name="songArtwork" placeholder="">
                        </div>
                        <hr class="my-4">
                        <input class="btn btn-primary" type="submit" value="Add Song!">
                        <a class="btn btn-danger" href="<?php echo URL . 'songs'?>">Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>