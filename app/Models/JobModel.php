<?php
namespace App\Models;

class JobModel implements \JsonSerializable
{
    private $jobID;
    private $company;
    private $position;
    private $description;
    
    /**
     * Constructor for Job Model
     * No returns are made
     */  
    public function __construct($jobID = -1, $comapny = "", $position = "", $description = "")
    {
        $this->jobID = $jobID;
        $this->company = $comapny;
        $this->position = $position;
        $this->description = $description;
    }
    /** jobID getter
     * @return int jobID
     */
    public function getJobID()
    {
        return $this->jobID;
    }

    /**company getter
     * @return String company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**position getter
     * @return String position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**description getter
     * @return String descritpion
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**jobID setter
     * @param mixed $jobID
     */
    public function setJobID($jobID)
    {
        $this->jobID = $jobID;
    }

    /**company setter
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**position setter
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**description setter
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


    
}

