<?php
namespace App\Models;

class JobHistoryModel implements \JsonSerializable
{
    private $historyID;
    private $title;
    private $company;
    private $date;
    private $userID;

    public function __construct($historyID = -1, $title = "", $company = "", $date = "", $userID = -1)
    {
        $this->historyID = $historyID;
        $this->title = $title;
        $this->company = $company;
        $this->date = $date;
        $this->userID = $userID;
    }
    /**
     * @return mixed
     */
    public function getHistoryID()
    {
        return $this->historyID;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $historyID
     */
    public function setHistoryID($historyID)
    {
        $this->historyID = $historyID;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->user_userID;
    }

    /**
     * @param mixed $user_userID
     */
    public function setUserID($user_userID)
    {
        $this->user_userID = $user_userID;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }



    
}

