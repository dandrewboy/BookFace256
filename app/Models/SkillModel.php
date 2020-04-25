<?php
namespace App\Models;

class SkillModel implements \JsonSerializable
{
    private $skillID;
    private $title;
    private $description;
    private $userID;

    public function __construct($skillID = -1, $title = "", $description = "", $userId = -1)
    {
        $this->skillID = $skillID;
        $this->title = $title;
        $this->description = $description;
        $this->userID = $userId;
    }
    /**
     * @return mixed
     */
    public function getSkillID()
    {
        return $this->skillID;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $skillID
     */
    public function setSkillID($skillID)
    {
        $this->skillID = $skillID;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }



    
}

