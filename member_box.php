<?php
date_default_timezone_set('Asia/Tokyo');

include "model.php";
const DATE_JSON = "./data/date.json";

$members = array();

$model = new Model();
$ids = $model->getMemberList();
foreach($ids as $id) {
    $m = $model->getMemberDetail($id);
    $members[] = $m;
}

// 3日以内に更新があるかどうかのチェック
function checkUpdate($member) {
    $timestamp = strtotime("-3 day");
    $lastUpdateTime = strtotime($member->modified_date);
    if( $lastUpdateTime - $timestamp < 0 ) {
        return false;
    }
    return true;
}

function getMemberBox($member) {
    echo "\t\t<td>\n";
    if (checkUpdate($member)) {
        echo "\t\t<div class=\"member-holder\">\n";
    } else {
        echo "\t\t<div class=\"member-holder non-update\">\n";
    }
    if ($member->class == normal) {
        echo "\t\t\t<div class=\"member-view ".$member->status."-color\" >\n";
    } else {
        echo "\t\t\t<div class=\"member-view ".$member->status."-status ".$member->class."-class\" >\n";
    }
    echo "\t\t\t\t<div class=\"member-state\">\n";
    echo "\t\t\t\t\t\t<span>".$member->name."@".$member->status."</span>\n";
    echo "\t\t\t\t</div>\n";
    echo "\t\t\t\t<div class=\"member-field\">\n";
    echo "\t\t\t\t\t\t<form method=\"post\" action=\"json_edit.php\">\n";
    echo "\t\t\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"".$member->id."\" >\n";
    echo "\t\t\t\t\t\t\t<input type=\"image\" name=\"submit\" width=\"80px\" height=\"40px\" style=\"border:solid 5px #FFFFFF\" src=\"".$member->image."\" >\n";
    echo "\t\t\t\t\t\t\t<div class=\"member-info\">\n";
    echo "\t\t\t\t\t\t\t\t<input type=\"submit\" value=\"".$member->comment."\">\n";
    echo "\t\t\t\t\t\t\t</div>\n";  
    echo "\t\t\t\t\t\t</form>\n";
    echo "\t\t\t\t\t</div>\n";
    echo "\t\t\t\t</div>\n";
    echo "\t\t\t</div>\n";
    echo "\t\t</div>\n";
    echo "\t\t</td>\n";
}

function getAllMembersTable($members, $border) {
    echo "<tr>\n";
    $count = 0;
    foreach ($members as $member) {
        getMemberBox($member);
        $count++; 
        
        // $border人ごとに段落            
        if ($count % $border == 0)  echo "\t\t</tr><tr>\n";
    }    
    echo "\t\t</tr>";
}

/**
 * 1ヶ月ごとにメンバーのクラスを更新し、出勤数をリセット
 */
function update($members, $model)
{
    $date_json = json_decode(file_get_contents(DATE_JSON));

    if( $date_json->month != date('m') ) {
        $date_json->month = date('m');

        foreach( $members as $member ) {
            if( $member->count >= 20 ) {
                $member->class = "gold";
            } elseif ( $member->count >= 10 ) {
                $member->class = "silver";
            } else {
                $member->class = "normal";
            }
            $member->count = 0;

            $model->updateMember($member->id, $member);
        }

        file_put_contents(DATE_JSON, json_encode($date_json));
    }
}

?>
