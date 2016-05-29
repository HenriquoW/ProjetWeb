<?php

if($data['EquipePalmares']!="" && $data['CoursePalmares']!="" && $data['ParticipantPalmares']!="" && $data['Classement']!=""){
  $palmares =null;
  if($data['EquipePalmares']=="0"){
    $palmares = loadPalmares(array('Id_Course'=>$data['CoursePalmares'],"Id_Competiteur"=>$data['ParticipantPalmares']));
  }else{
    $palmares = loadPalmares(array('Id_Course'=>$data['CoursePalmares'],"Id_Equipe"=>$data['ParticipantPalmares']));
  }

  if($palmares!=null){
    $palmares->setClassement($data['Classement']);

    $palmares->save(true);
  }

}

 ?>
