<?php
  include_once __DIR__ . '/../Model/database.php';

    function create($id){
        try {
            $result = createAccount();
            if ($result) {
                DeleteDb('newusers', $id);
                return ['success' => true, 'message' => 'Compte créé avec succès.'];
            }
            throw new Exception("Échec de la création du compte.");
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }
    function login(){
        // ces trois lignes pour afficher l erreur  de mot de passe ou email
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        session_start();
        seConnecte();
    }  


    function edit() {
        $id = !empty($_POST['id']) ? htmlspecialchars($_POST['id']) : null;
        $firstName = !empty($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
        $lastName = !empty($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
        $birthdate = !empty($_POST['birthdate']) ? htmlspecialchars(trim($_POST['birthdate'])) : null;
        $cin = !empty($_POST['cin']) ? htmlspecialchars(trim($_POST['cin'])) : null;
        $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
        $speciality = !empty($_POST['speciality']) ? htmlspecialchars(trim($_POST['speciality'])) : null;
        $departement = !empty($_POST['departement']) ? htmlspecialchars($_POST['departement']) : null;
        $roles = validateRoles($_POST['roles']);

        try {
            $result = EditUser($id, $firstName, $lastName, $birthdate, $cin, $email, $speciality, $departement, $roles);
            if ($result === true || $result === "User updated successfully.") {
                return ['success' => true, 'message' => 'Utilisateur modifié avec succès.'];
            } else {
                throw new Exception($result);
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function delete($id){
        try {
            $result = DeleteDb('utilisateurs', $id);
            $roleResult = DeleteRoleFromDB($id);
            if ($result && $roleResult) {
                return ['success' => true, 'message' => 'Utilisateur supprimé avec succès.'];
            } else {
                throw new Exception("Échec de la suppression de l'utilisateur ou des rôles.");
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function insertNewUser(){
        $firstName = !empty($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
        $lastName = !empty($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
        $birthdate = !empty($_POST['birthdate']) ? htmlspecialchars(trim($_POST['birthdate'])) : null;
        $cin = !empty($_POST['cin']) ? htmlspecialchars(trim($_POST['cin'])) : null;
        $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
        $speciality = !empty($_POST['speciality']) ? htmlspecialchars(trim($_POST['speciality'])) : null;

        try {
            $result=insertUser($firstName,$lastName,$birthdate,$cin,$email,$speciality);

            if ($result === true) {
                session_start();
                $_SESSION['signup_message'] = "Attendez la validation de votre compte!";

                header('location: Views/login.php');
                exit();
              }else{
                  throw new Exception($result);
                }
      }catch (Exception $e) {
          echo "An error occurred: " . $e->getMessage();
      }
    }

    function deleteTempUser($id){
        try {
            $result = DeleteDb('newusers', $id);
            if ($result === true || $result === "User deleted successfully.") {
                return ['success' => true, 'message' => 'Utilisateur temporaire supprimé.'];
            } else {
                throw new Exception($result);
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function changePassword() {
        $new_password = !empty($_POST['new_password']) ? htmlspecialchars(trim($_POST['new_password'])) : null;
        if ($new_password) {
            try {
                if (NewPassword($new_password)) {
                    unset($_SESSION['force_password_change']);
                    return ['success' => true, 'message' => 'Mot de passe changé avec succès.'];
                } else {
                    throw new Exception("Échec du changement de mot de passe.");
                }
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => 'Veuillez entrer un nouveau mot de passe.'];
        }
    }

    function insertTempUnit($userId, $unitId, $demande){
        try {
            $result = changeTable('INSERT INTO tempunits (id_prof,id_unit,demande) VALUES (?,?,?);', [$userId, $unitId, $demande]);
            if ($result === true) {
                return ['success' => true, 'message' => 'Demande envoyée avec succès.'];
            } else {
                throw new Exception($result);
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function addUnit_prof(){
        $unitId = !empty($_POST['unit']) ? htmlspecialchars(trim($_POST['unit'])) : null;
        $profId = !empty($_POST['prof']) ? htmlspecialchars(trim($_POST['prof'])) : null;
        $annee = !empty($_POST['Au']) ? htmlspecialchars(trim($_POST['Au'])) : null;

        try {
            $hours = GetFromDb('SELECT * FROM volumehorraire WHERE id_unit=?;', $unitId, false);
            $result = changeTable('INSERT INTO professeur (id_professeur,id_unit,Volume_horr,anneeUniversitaire) VALUES (?,?,?,?);', [$profId, $unitId, $hours['VolumeTotal'], $annee]);
            if ($result === true) {
                $update = changeTable('UPDATE units SET statut=? WHERE id=?;', [1, $unitId]);
                if ($update === true) {
                    $history=changeTable('INSERT INTO historiques (id_utilisateur,id_unite,annee) VALUES (?,?,?);', [$profId, $unitId, $annee]);
                    if ($history === true) {
                            return ['success' => true, 'message' => 'Unité affectée au professeur.'];
                    } else {
                        throw new Exception($history);
                    }
                } else {
                    throw new Exception($update);
                }
            } else {
                throw new Exception($result);
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function validate_choice_action($id_prof, $id_unit, $anne){
        try {
            $hours = GetFromDb('SELECT * FROM volumehorraire WHERE id_unit=?;', $id_unit, false);
            $result = changeTable('INSERT INTO professeur (id_professeur,id_unit,Volume_horr,anneeUniversitaire) VALUES (?,?,?,?);', [$id_prof, $id_unit, $hours['VolumeTotal'], $anne]);
            if ($result === true) {
                $update = changeTable('UPDATE units SET statut=? WHERE id=?;', [1, $id_unit]);
                if ($update === true) {
                    $delete = changeTable('DELETE FROM tempunits WHERE id_prof=? AND id_unit=?;', [$id_prof, $id_unit]);
                    if ($delete === true) {
                        $history=changeTable('INSERT INTO historiques (id_utilisateur,id_unite,annee) VALUES (?,?,?);', [$id_prof, $id_unit, $anne]);
                        if ($history === true) {
                            return ['success' => true, 'message' => 'Choix validé avec succès.'];
                        } else {
                            throw new Exception($history);
                        }
                    } else {
                        throw new Exception($delete);
                    }
                } else {
                    throw new Exception($update);
                }
            } else {
                throw new Exception($result);
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function refuse_choice_action($id_prof, $id_unit){
        try {
            $delete = changeTable('DELETE FROM tempunits WHERE id_prof=? AND id_unit=?;', [$id_prof, $id_unit]);
            if ($delete === true) {
                return ['success' => true, 'message' => 'Choix refusé et supprimé.'];
            } else {
                throw new Exception($delete);
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function addUnit($filiere_id, $dept_id) {
        $codeModule = isset($_POST['code_module']) ? htmlspecialchars($_POST['code_module']) : null;
        $intitule = isset($_POST['intitule']) ? htmlspecialchars($_POST['intitule']) : null;
        $speciality = isset($_POST['speciality']) ? htmlspecialchars($_POST['speciality']) : null;
        $credits = isset($_POST['credits']) ? htmlspecialchars($_POST['credits']) : null;
        $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : null;
        $CM = isset($_POST['CM']) ? htmlspecialchars($_POST['CM']) : null;
        $TD = isset($_POST['TD']) ? htmlspecialchars($_POST['TD']) : null;
        $TP = isset($_POST['TP']) ? htmlspecialchars($_POST['TP']) : null;
        $autre = isset($_POST['autre']) ? htmlspecialchars($_POST['autre']) : null;
        $evaluation = isset($_POST['evaluation']) ? htmlspecialchars($_POST['evaluation']) : null;

        try {
            $unit_id = insertUnit($codeModule, $intitule, $semestre, $credits, $speciality, $dept_id, $filiere_id);
            if ($unit_id != -1) {
                $result = changeTable('INSERT INTO volumehorraire (id_unit,Cours,TD,TP,Autre,Evaluation) VALUES(?,?,?,?,?,?);', [$unit_id, $CM, $TD, $TP, $autre, $evaluation]);
                if ($result === true) {
                    return ['success' => true, 'message' => 'Unité ajoutée avec succès!'];
                }
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Erreur inconnue'];
    }

    function CreerVacataire($dept_id, $fil_id){
        try {
            if (AddVacataire($dept_id, $fil_id)) {
                return ['success' => true, 'message' => 'Vacataire créé avec succès.'];
            } else {
                throw new Exception("Échec de la création du vacataire.");
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

    function getFiliere(){
        if(!isset($_GET['department_id'])){
          echo json_encode([]);
          exit;
        }
        
        $id_departement=htmlspecialchars($_GET['department_id']);
        $filieres=GetFromDb('SELECT * FROM filieres WHERE id_departement=? ;',$id_departement);

        echo json_encode($filieres);
    }



    
 /*             cc                                                cc                */


function countUnreadNotifications($id_utilisateur) {
    $count=CounterValues('SELECT COUNT(*) FROM notification WHERE id_utilisateur =? AND is_read = 0',$id_utilisateur);
    return $count;
}

function markAsRead($id_notification) {
    changeTable('UPDATE notifications SET is_read = 1 WHERE id = ?',$id_notification);
}

function getNotifications($id_utilisateur) {
    $notification = GetFromDb('SELECT * FROM notifications WHERE id_utilisateur = ? ORDER BY created_at DESC',$id_utilisateur);
    return $notification;
}

function envoyerNotification($id_utilisateur, $message,$title) {
    changeTable('INSERT INTO notifications (id_utilisateur, message, title) VALUES (?,?,?);',[$id_utilisateur, $message, $title]);
}







