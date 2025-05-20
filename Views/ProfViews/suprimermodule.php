

<?php      /*
   require_once __DIR__ . '/../../Controller/controller.php';

   session_start();
   if (!isset($_SESSION['role'])&&!isset($_SESSION['id'])) {
       header("Location: /webProject/Views/login.php");
       exit();
   }

    $id_unite = isset($_GET['id_unite']) ? intval($_GET['id_unite']) : null;
    $id_prof = $_SESSION['id'];


$result=changeTable('DELETE FROM professeur WHERE id_professeur=? AND id_unit=? ;',[$id_prof,$id_unite]);
                    if($result){
                            header('location: '.$_SERVER['HTTP_REFERER'].'&success=1');  
                            exit();
                    }else{
                            throw new Exception($result);
                    }
                    
*/

                    

require_once __DIR__ . '/../../Controller/controller.php';
session_start();

if (!isset($_SESSION['role']) && !isset($_SESSION['id'])) {
    header("Location: /webProject/Views/login.php");
    exit();
}

$id_unite = isset($_GET['id_unite']) ? intval($_GET['id_unite']) : null;
$id_prof = $_SESSION['id'];

$result = changeTable('DELETE FROM professeur WHERE id_professeur=? AND id_unit=? ;', [$id_prof, $id_unite]);

if($result){
    $statut = changeTable('UPDATE units SET statut = 0 WHERE id = ?;',$id_unite);
    if($statut){
    $_SESSION['AddMessage'] = [
        'success' => true,
        'message' => 'Module supprimé avec succès !'
    ];
} 
}else {
    $_SESSION['AddMessage'] = [
        'success' => false,
        'message' => 'Erreur lors de la suppression du module.'
    ];
}



header('Location: '.$_SERVER['HTTP_REFERER']);
exit();
?>

















