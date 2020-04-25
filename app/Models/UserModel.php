<?php
namespace App\Models;

class UserModel
{
    private $userID;
    private $firstname;
    private $lastname;
    private $credential;
    private $isActive;
    private $role;

 
    public function __construct($userId = -1, $firstname = "", $lastname = "", CredentialsModel $credential = null,bool $isActive = true, String $role= "")
    {
        $this->userID = $userId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->credential = $credential;
        $this->isActive = $isActive;
        $this->role = $role;
 
    }
    
    /**
     * @return string
     */
    public function getUserID()
    {
        return $this->userID;
    }
    
    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * @return \App\Models\CredentialsModel
     */
    public function getCredential()
    {
        return $this->credential;
    }
    
    public function getIsActive(){
        
        return $this->isActive;
    }
    
    public function getRole(){
        return $this->role;
    }
    
    /**
     * @param string $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
    
    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    
    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
   
    
    /**
     * @param \App\Models\CredentialsModel $credential
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
    }
    
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    

    
}

