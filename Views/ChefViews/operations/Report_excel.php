<?php 
   require_once __DIR__ . '/../../../Controller/controller.php';
   require_once __DIR__ . '/../../operations/exportAction.php'; 
   require_once __DIR__ . '/../../operations/exportActionMulti.php'; 

   session_start();
   if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }
    
   
    
    $user=GetFromDb("SELECT * FROM utilisateurs WHERE id=? ;",$_SESSION['id'],false);

    $title=$user['firstName'].' '.$user['lastName'];
    $userName=$user['firstName'].' '.$user['lastName'];
    $department = GetFromDb("SELECT * FROM departement WHERE id=? ;",$user['id_departement'],false);


    //hadchi ta3 data d rapport : 
        $fil_id = !empty($_POST['filiere']) ? $_POST['filiere'] : null;
        $semestre = !empty($_POST['semestre']) ? $_POST['semestre'] : null;
        $annee = !empty($_POST['Au']) ? $_POST['Au'] : null;
        $type = !empty($_POST['type']) ? $_POST['type'] : 'all';

        $query='SELECT p.id_professeur,p.id_unit FROM professeur p 
                JOIN units t ON p.id_unit = t.id WHERE p.anneeUniversitaire=? AND t.departement_id=? AND 1=1';


        $param=[$annee,$user['id_departement']];

        if($fil_id){
                $query.=' AND t.id_filiere=?';
                $param[]=$fil_id;
            }

        if($semestre){
                $query.=' AND t.semestre=?';
                $param[]=$semestre;
            }

        $RepportData=GetFromDb($query,$param);

      $minHours=100;    
      
      switch ($type) {
        case 1:
            $data=[['Code Module','Intitulé','Filière','Semestre','Responsable','Année Univ.']];
            foreach ($RepportData as $row){
                $unit=GetFromDb('SELECT * FROM units WHERE id=?;',$row['id_unit'],false);
                $prof = GetFromDb('SELECT * FROM utilisateurs WHERE id=?;',$row['id_professeur'],false);
                $filiere = GetFromDb('SELECT * FROM filieres WHERE id=?', $unit['id_filiere'],false);
                $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=? ;',[$row['id_professeur'],$row['id_unit']]);

                $profName = $prof['firstName'].' '.$prof['lastName'];

                $data[] = [$unit['code_module'],$unit['intitule'],$filiere['label'],$unit['semestre'],$profName,$annee];
            }
            exportTableToExcel($data, 'Rapport_unites_enseignement_'.$department['acronym'].'.xlsx');
            break;
        case 2:
            $data=[['Nom','Prénom','Departement','Nb.UEs Enseigné','Année Univ.','Volume Horraire Total']];
    
            foreach ($RepportData as $index => $row){
                $prof=GetFromDb('SELECT * FROM utilisateurs WHERE id=? AND 	id_departement=? ;',[$row['id_professeur'],$user['id_departement']],false);
                $nbrUnits=CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;',$row['id_professeur']);  
                $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $row['id_professeur']);
                $volume_horr= !empty($vol_horr)?$vol_horr:0;
                $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=? ;',[$row['id_professeur'],$row['id_unit']]);
                  if ($volume_horr < $minHours) {
                        $highlightedRows[] = $index + 1;
                    }
                            
                $data[] = [$prof['lastName'],$prof['firstName'],$department['departement_name'],$nbrUnits,$annee,$volume_horr];
            }
            exportTableToExcel($data, 'Rapport_enseignant_'.$department['acronym'].'.xlsx','Professeurs',$highlightedRows);
            break;
        default :
           $Sheet1 = [['Nom','Prénom','Departement','Nb.UEs Enseigné','Année Univ.','Volume Horraire Total']];
        $highlightedRowsSheet1 = [];

        foreach ($RepportData as $index => $row) {
            $prof = GetFromDb('SELECT * FROM utilisateurs WHERE id=? AND id_departement=?;', [$row['id_professeur'], $user['id_departement']], false);
            $nbrUnits = CounterValues('SELECT COUNT(*) FROM professeur WHERE id_professeur=?;', $row['id_professeur']);  
            $vol_horr = CounterValues('SELECT SUM(Volume_horr) AS total_volume FROM professeur WHERE id_professeur = ?;', $row['id_professeur']);
            $volume_horr = !empty($vol_horr) ? $vol_horr : 0;
            $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=?;', [$row['id_professeur'], $row['id_unit']]);

            if ($volume_horr < $minHours) {
                $highlightedRowsSheet1[] = $index + 1;
            }

            $Sheet1[] = [$prof['lastName'], $prof['firstName'], $department['departement_name'], $nbrUnits, $annee, $volume_horr];
        }

        $Sheet2 = [['Code Module','Intitulé','Filière','Semestre','Responsable','Année Univ.']];
        foreach ($RepportData as $row) {
            $unit = GetFromDb('SELECT * FROM units WHERE id=?;', $row['id_unit'], false);
            $prof = GetFromDb('SELECT * FROM utilisateurs WHERE id=?;', $row['id_professeur'], false);
            $filiere = GetFromDb('SELECT * FROM filieres WHERE id=?', $unit['id_filiere'], false);
            $annee = CounterValues('SELECT anneeUniversitaire FROM professeur WHERE id_professeur=? AND id_unit=?;', [$row['id_professeur'], $row['id_unit']]);
            
            $profName = $prof['firstName'] . ' ' . $prof['lastName'];
            $Sheet2[] = [$unit['code_module'], $unit['intitule'], $filiere['label'], $unit['semestre'], $profName, $annee];
        }

        $data = [
            [
                'title' => 'Professeurs',
                'data' => $Sheet1
            ],
            [
                'title' => 'UEs',
                'data' => $Sheet2
            ]
        ];

        $highlightedRowsPerSheet = [
            $highlightedRowsSheet1, 
            []
        ];

        exportMultipleTablesToExcel($data, 'Rapport_Complet_'.$department['acronym'].'.xlsx', $highlightedRowsPerSheet);

            break;           
       

      }



?>