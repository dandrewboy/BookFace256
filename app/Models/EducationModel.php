<?php
namespace App\Models;

class EducationModel implements \JsonSerializable
{
    private $educationID;
    private $school;
    private $level;
    private $date;
    private $userID;

    public function __construct($educationID = -1, $school = "", $level = "", $date = "", $userID = -1)
    {
        $this->educationID = $educationID;
        $this->school = $school;
        $this->level = $level;
        $this->date = $date;
        $this->userID = $userID;
    }
    /**
     * @return mixed
     */
    public function getEducationID()
    {
        return $this->educationID;
    }

    /**
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $educationID
     */
    public function setEducationID($educationID)
    {
        $this->educationID = $educationID;
    }

    /**
     * @param string $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
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

