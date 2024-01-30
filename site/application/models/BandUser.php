<?php

class BandUser
{
    private $bandId;
    private $userId;

    /**
     * @param $bandId
     * @param $userId
     */
    public function __construct($bandId, $userId)
    {
        $this->bandId = $bandId;
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getBandId()
    {
        return $this->bandId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }




}