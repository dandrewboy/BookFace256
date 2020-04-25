<?php
namespace App\Models;


class ProfileModel implements \JsonSerializable
{
    private $profileID;
    private $email;
    private $phonenumber;
    private $address;
    
    private $jobhistory;
    private $skills;
    private $education;
    
    public function __construct($profileID = -1, $email ="", $phonenumber = "",$jobhistory="",$skills="",$education="")
    {
        $this->profileID = $profileID;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->jobhistory = $jobhistory;
        $this->skills = $skills;
        $this->education= $education;
        
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
    
    
    
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @param string $phonenumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }
    
    
    /**
     * @return mixed
     */
    public function getProfileID()
    {
        return $this->profileID;
    }
    
    /**
     * @param mixed $profileID
     */
    public function setProfileID($profileID)
    {
        $this->profileID = $profileID;
    }
    
    /**
     * @return string
     */
    public function getJobhistory()
    {
        return $this->jobhistory;
    }
    
    /**
     * @param mixed $jobhistory
     */
    public function setJobhistory($jobhistory)
    {
        $this->jobhistory = $jobhistory;
    }
    
    /**
     * @return string
     */
    public function getSkills()
    {
        return $this->skills;
    }
    
    /**
     * @param string $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }
    
    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }
    
    /**
     * @param string $education
     */
    public function setEducation($education)
    {
        $this->education = $education;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    
    
    
    
    
    
}