<?php require_once "../config.php";

function alert($msg, $url){
    echo 
"<script> 
  alert(".$msg.");
  window.location.href = ".$url.";
</script>";
};

// function select_from_db_where($table, $what, $where, $value){
//     if ($what == "*"){
//         //select everything
//         $query = "SELECT * FROM `$table` WHERE";

//         foreach ($where as $key => $value) {
//             $query .= " AND ".$key."=".$value;
//         };
//         $statement = $dbs->prepare($query);

//         foreach ($value as $placeholder => $placevalue) {
//             $statement->bindValue($placeholder, $placevalue);
//         };
//         $statement->execute();
//         $data = $statement->fetchAll(PDO::FETCH_ASSOC);
//         return $data;

//     }
// }
?>