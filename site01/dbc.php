<?php

function dbc(){
    $host = "localhost";
    $dbname = "sousaku";
    $user = "root";
    $pass = "root";

    $dns = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try{
        $pdo = new PDO($dns, $user, $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

        return $pdo;

    } catch(PDOException $e) {
        exit($e->getMessage());
    }
}

/**
 * ファイルデータを保存
 * @param string $filename ファイル名
 * @param string $saveDb_path 保存先のパス
 * @return bool $result
*/
function filesave($fileName, $saveDb_path){
    $result = false;

    $sql = "INSERT INTO file_table (file_name, file_path) VALUES (?, ?)";

    try {
        $stmt = dbc()->prepare($sql);
        $stmt->bindValue(1, $fileName);
        $stmt->bindValue(2, $saveDb_path);
        $result = $stmt->execute();

        return $result;

    } catch(\Exception $e) {
        echo $e->getMessage();
        return $result;
    }

}

/**
 * ファイルデータを取得
 * @return array $filedata
 */
function getAllFile(){
    $sql = "SELECT * FROM file_table";

    $fileData = dbc() -> query($sql);

    return $fileData;
}

?>