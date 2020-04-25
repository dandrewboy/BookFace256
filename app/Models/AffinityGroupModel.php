<?php
namespace App\Models;

class AffinityGroupModel
{
    private $groupID;
    private $name;
    private $ownerID;
    private $discription;

    public function __construct($groupID = -1, $name = "", $ownerID = -1, $discription = "")
    {
        $this->groupID = $groupID;
        $this->name = $name;
        $this->ownerID = $ownerID;
        $this->discription = $discription;
    }
    /**
     * @return mixed
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getOwnerID()
    {
        return $this->ownerID;
    }

    /**
     * @param mixed $groupID
     */
    public function setGroupID($groupID)
    {
        $this->groupID = $groupID;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $ownerID
     */
    public function setOwnerID($ownerID)
    {
        $this->ownerID = $ownerID;
    }
    /**
     * @return mixed
     */
    public function getDiscription()
    {
        return $this->discription;
    }

    /**
     * @param mixed $discription
     */
    public function setDiscription($discription)
    {
        $this->discription = $discription;
    }


    
}

