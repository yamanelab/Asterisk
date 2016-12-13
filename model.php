<?php

define("JSON_PATH", dirname(__FILE__) . "/member_data.json");

class Model
{
    private $database;
    private $ids = array();

    function __construct() {
        $database = new Database();
        $this->loadJson();
    }

    public function getMemberList()
    {
        return $this->ids;
    }

    public function getMemberDetail($id)
    {
        return $this->database->member[$id];
    }

    public function updateMember($id, $member) {
        $this->database->member[$id] = $member;
        $this->saveJson();
    }

    public function addMember($id, $member) {
        $this->database->member[$id] = $member;
        $this->saveJson();	
    }

    public function removeMember($id) {
        unset($this->database->member[$id]);
        $this->saveJson();
    }

    function loadJson() {
        // ファイルが無いなら、ロードしない
        if(!file_exists(JSON_PATH)) return;

        // jsonロード
        $lowData = file_get_contents(JSON_PATH);
        $_members = json_decode($lowData)->member;

        $this->database = new Database();
        foreach($_members as $member) {
            $this->database->member[$member->id] = new Member(
                $member->id,
                $member->name,
                $member->image,
                $member->comment,
                $member->status,
                $member->modified_date
            );
        }

        foreach($this->database->member as $member) {
            $this->ids[] = $member->id;
        }
    }

    function saveJson() {
        $fp = fopen(JSON_PATH, "w");
        fwrite($fp, json_encode($this->database));
        fclose($fp);
    }
}

class DataBase
{
	public $member = array();
}

class Member
{
    public $id;
    public $name;
    public $image;
    public $comment;
    public $status;
    public $modified_date;

    function __construct($_id = "", $_name = "", $_image = "", $_comment = "", $_status = "", $_modified_date = "") {
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