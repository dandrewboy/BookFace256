<?php
namespace App\Models;

class CredentialsModel
{
    private $username;
    private $password;

    public function __construct($username = "", $password = "")
    {
        $this->username = $username;
        $this->password = $password;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}

