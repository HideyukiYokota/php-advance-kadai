<?PHP
$dsn = 'mysql:dbname=php_db;host=localhost;charset=utf8mb4';
$user = 'root';
$password = '';
        ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>PHP-DB作成</title>
</head>

<body>
    <p>
        <!-- ジャンルテーブル作成 -->
        <?PHP
        try {
            $pdo = new PDO($dsn, $user, $password);


            $sql = 'CREATE TABLE IF NOT EXISTS genres (
               id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
               genre_code INT(11) NOT NULL UNIQUE,
               genre_name VARCHAR(50) NOT NULL             
           )';

            $pdo->query($sql);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        // インデックスを作成する
        try {
            $sql = 'ALTER TABLE genres ADD INDEX idx_genre_code (genre_code)';
            $pdo->query($sql);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        // ブックステーブル作成
        try {
            $pdo = new PDO($dsn, $user, $password);

            $sql = 'CREATE TABLE IF NOT EXISTS books (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                book_code INT(11) NOT NULL,
                book_name VARCHAR(60) NOT NULL,
                price INT(11) NOT NULL,
                stock_quantity INT(11) NOT NULL,
                genre_code INT(11),
                update_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (genre_code) REFERENCES genres (genre_code)
            )';

            $pdo->query($sql);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }


        // サンプルデータインポート 
        try {
            $pdo = new PDO($dsn, $user, $password);
          


            $sql = "LOAD DATA INFILE 'genres_table_dummy.csv' INTO TABLE genres FIELDS TERMINATED BY ','
                    ";

            $pdo->query($sql);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        try {
            $pdo = new PDO($dsn, $user, $password);

            $sql = 'LOAD DATA INFILE "books_table_dummy.csv" INTO TABLE books FIELDS TERMINATED BY ","
                    ';
            $pdo->query($sql);
            echo "DB作成に成功しました";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }


        ?>
    </p>
</body>

</html>