<?php

const JSON_PATH = "member_data.json";

class Model
{
    
    private $members;
    private $ids;

    function __construct() {
        // 手で作る
        /*$this->members = array(
            "hamayan" => new Member("hamayan", "濱屋光喜", "image", "コメント", "在席", "1993/04/24 00:00:00")
        );*/

        // jsonで読む
        $lowData = file_get_contents(JSON_PATH);
        $_members = json_decode($lowData);

        $this->members = array();
        foreach($_members as $member) {
            $this->members[$member->id] = new Member(
                $member->id,
                $member->name,
                $member->image,
                $member->comment,
                $member->status,
                $member->modified_date
            );
        }

        $this->ids = array();
        foreach($this->members as $member) {
            $this->ids[] = $member->id;
        }
    }

    public function getMemberList()
    {
        return $this->ids;
    }

    public function getMemberDetail($id)
    {
        return $this->members[$id];
    }

    public function updateMember($id, $member) {
        $this->members[$id] = $member;
        $this->saveJson();
    }

    public function addMember($id, $member) {
        $this->members[$id] = $member;
        $this->saveJson();
    }

    public function removeMember($id) {
        unset($this->members[$id]);
        $this->saveJson();
    }

    function saveJson() {
        $fp = fopen(JSON_PATH, "w");
        fwrite($fp, json_encode($this->members));
        fclose($fp);
    }
}

class Member
{
    public $id;
    public $name;
    public $image;
    public $comment;
    public $status;
    public $modified_date;

    function __construct($_id, $_name, $_image, $_comment, $_status, $_modified_date) {
        $this->id = $_id;
        $this->name = $_name;
        $this->image = $_image;
        $this->comment = $_comment;
        $this->status = $_status;
        $this->modified_date = $_modified_date;
    }

    function __toString() {
        return "Member { $this->id, $this->name, $this->image, $this->comment, $this->status, $this->modified_date }";
    }
}