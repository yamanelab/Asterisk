<?php

include "model.php";

$members = array();

$model = new Model();
$ids = $model->getMemberList();
foreach($ids as $id) {
	$m = $model->getMemberDetail($id);
	$members[] = $m;
}

function getNameAndStatus($member) {
	echo $member->name."@".$member->status;
}

function getImage($member) {
	echo $member->image;
}

function getMemo($member) {
	echo $member->comment;
}

?>
