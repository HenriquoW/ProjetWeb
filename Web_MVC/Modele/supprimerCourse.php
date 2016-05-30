<?php

$course = loadCourse(array("Id"=>$data['Course']));

$course->delete();

unset($course);

?>
