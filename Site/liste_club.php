<?PHP
	//require_once('BDD/class_bdd.php');
	//echo json_encode(BDD::getInstance()->getManager("club")->getList());
	$test = array(array("id"=> 1, "nom"=>"sed"),array("id"=> 2, "nom"=>"bla"));
	echo json_encode($test);
?>