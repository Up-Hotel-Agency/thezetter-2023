<?php
function mysqlReady(){
    $WORDPRESS_DB_HOST = getenv('WORDPRESS_DB_HOST') ? getenv('WORDPRESS_DB_HOST') : 'mysql';
    $WORDPRESS_DB_USER = getenv('WORDPRESS_DB_USER') ? getenv('WORDPRESS_DB_USER') : 'root';
    $WORDPRESS_DB_PASSWORD = getenv('WORDPRESS_DB_PASSWORD') ? getenv('WORDPRESS_DB_PASSWORD') : '';
    $WORDPRESS_DB_NAME = getenv('WORDPRESS_DB_NAME') ? getenv('WORDPRESS_DB_NAME') : 'wordpress';

    # yup, wordpress still mysqli not PDO
    # var_dump($WORDPRESS_DB_HOST,$WORDPRESS_DB_USER,$WORDPRESS_DB_PASSWORD,$WORDPRESS_DB_NAME);
    $mysqli = @new mysqli($WORDPRESS_DB_HOST,$WORDPRESS_DB_USER,$WORDPRESS_DB_PASSWORD,$WORDPRESS_DB_NAME);

    # need to see the error?
    # var_dump($mysqli->connect_error);
    return !($mysqli->connect_errno);
}

$tries = 0;

while(1){
    if(mysqlReady()){
        exit(0);
    }else{
        $limit = 120;
        if($tries > $limit){
            fwrite(STDERR, "MySQL didn't start after ${limit}s, probably broken\n");
            exit (1);
        }

        echo "DB not ready yet\n";
        $tries++;
        sleep(1);
    };
}
?>
