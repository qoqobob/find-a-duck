<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }
        body {
            width: 100%;
            height: 100vh;
        }
        .ducks-container{
            margin: 100px auto 0px auto;
            width: 80vh;
            max-width: 80%;
        }
        .row-ducks-container{
            display:flex;
        }
        a {
            text-decoration: none;
            color: white;
        }
        img{
            display:block;
            width: 100%;
            aspect-ratio: 1 / 0.85;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
        }
        .score{
            margin: 10px auto 0px auto;
            width: 80vh;
            max-width: 80%;
        }
        button {
            border: none;
            background-color: #2596be;
            padding: 10px 20px;
            border-radius: 10px;
        }
        button:active{
            scale: 0.9; 
        }
    </style>
    <title>Ducks</title>
</head>
<body>
    <div class="ducks-container">
        <?php      
        $ducksPics = array(
            "<img src='eend_vreemd.jpg'>",
            "<img src='eend_blauw.jpg'>",
            "<img src='eend_geel.jpg'>",
            "<img src='eend_groen.jpg'>",
            "<img src='eend_rood.jpg'>"            
        );
        function echoDucks($size) {
            global $ducksPics;
            echo "<style>
            a{
                width: ".(100/$size)."%;
            }
            </style>";
            $strangeDuckRow=rand(0,($size-1));
            $strangeDuckColumn=rand(0,($size-1));
            for ($i=0; $i < $size; $i++) { 
                echo "<div class='row-ducks-container'>";
                for ($j=0; $j < $size; $j++) { 
                    if (($j!=$strangeDuckColumn) || ($i!=$strangeDuckRow)){
                        $randomNumber = rand(1,4);
                        echo "<a href='ducks.php'>";
                        echo $ducksPics[$randomNumber];
                        echo "</a>";
                    } else {
                        $_SESSION['hash'] = hash('crc32b', ($strangeDuckRow."".$strangeDuckColumn));
                        echo "<a href='ducks.php?".$_SESSION['hash']."'>";
                        echo $ducksPics[0];
                        echo "</a>";
                    }               
                }
                echo "</div>";
            }
        };
        session_start();
        if(isset($_GET['reset'])){
            unset($_GET['reset']);
            $_SESSION['size']=1;
            $_SESSION['miss']=0;
            $_SESSION['hit']=0;
            header("Location: ducks.php");
        }
        if (!isset($_SESSION['size'])) {
            $_SESSION['size']=1;
        }        
        if(isset($_GET[$_SESSION['hash']])){
            unset($_GET[$_SESSION['hash']]);
            unset($_SESSION['hash']);
            $_SESSION['size']= $_SESSION['size'] * 2;
            $_SESSION['hit']++;
            echoDucks($_SESSION['size']);           
        } else {
            if ($_SESSION['size']>1){
               $_SESSION['size']= $_SESSION['size'] / 2;
               $_SESSION['miss']++;
            }         
            echoDucks($_SESSION['size']);
        }       
        ?>
    </div>
    <div class="score">
    <?php   
        if (!isset($_SESSION['miss'])) {
            $_SESSION['miss']=0;
        } 
        if (!isset($_SESSION['hit'])) {
            $_SESSION['hit']=0;
        } 
        echo "Hits: ".$_SESSION['hit']."<br>";
        echo "Misses: ".$_SESSION['miss']."<br>";
        echo "Total plays: ".$_SESSION['miss']+$_SESSION['hit']."<br>";
        echo "<button><a href='ducks.php?reset'>Reset</a></button>";

    ?>
    </div>
</body>
</html>
