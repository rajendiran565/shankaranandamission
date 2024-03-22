<?php
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');


$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();

$events = array();
$sql = "select * from events";
$db->sql($sql);
$res = $db->getResult();
//var_dump($res);die;
$num_rows = $db->numRows($res);
if($num_rows > 0){ 
    foreach($res as $row){
        $id = $row['id'];
        $img = !empty($row['image'])?$row['image']:'';
        $edate = !empty($row['event_date'])?date('d F Y',strtotime($row['event_date'])):'';
        $etime = !empty($row['event_time'])?$row['event_time']:'';
        $place = !empty($row['place'])?$row['place']:'';
        $description = !empty($row['description'])?$row['description']:'';
        $desc = '<img src="'.ADMAIN_URL.$img.'" width="100%" class="event-img"><p class="location-txt1"><i class="fa fa-calendar-o"></i> '.$edate.'</p><p class="location-txt1"><i class="fa fa-clock-o"></i> '.$etime.'</p><p class="location-txt1"><i class="fa fa-map-marker"></i> '.$place.'</p><p class="evnt-txt1"> '.$description.'</p><div class="modal-footer"><a href="event_details.php?id='.$id.'" target="_blank" class="btn btn-primary">View Details</a></div>';
        $event = array(
            'title' => $row['title'],
            'description' => $desc, 
            'start' => $row['event_date'],
            'time' => $row['event_time'],
            'className' => 'fc-bg-deepskyblue', 
            'location' => 'text',
            'icon' => 'calendar'
        );
        array_push($events, $event);
    }
}
echo json_encode($events);
?>