<?php

class Song
{
    private $id,
        $title,
        $author,
        $year,
        $description,
        $audio,
        $video,
        $image,
        $album,
        $text,
        $bpm,
        $genre,
        $type,
        $instruments,
        $notes,
        $bandId;

    /**
     * @param $id
     * @param $title
     * @param $author
     * @param $year
     * @param $description
     * @param $audio
     * @param $video
     * @param $image
     * @param $album
     * @param $text
     * @param $bpm
     * @param $genre
     * @param $type
     * @param $instruments
     * @param $notes
     * @param $bandId
     */
    public function __construct($id, $title, $author, $year, $description, $audio, $video, $image, $album, $text, $bpm, $genre, $type, $instruments, $notes, $bandId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->description = $description;
        $this->audio = $audio;
        $this->video = $video;
        $this->image = $image;
        $this->album = $album;
        $this->text = $text;
        $this->bpm = $bpm;
        $this->genre = $genre;
        $this->type = $type;
        $this->instruments = $instruments;
        $this->notes = $notes;
        $this->bandId = $bandId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return mixed
     */
    public function getBandId()
    {
        return $this->bandId;
    }



}