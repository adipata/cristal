<?php
include ("NumBucket.php");

function getNumber(NumBucket $b)
{
    $binmax=strlen(decbin($b->max));
    for($i=0;$i<$b->total;$i++){
        $nf=-1;
        while($nf<0 && $nf>-100) {
            $nb = getBits($binmax);
            $n = bindec($nb);
            if($n>=$b->min && $n<=$b->max){
                advancePointer($binmax);
                $nf=$n;
            } else {
                advancePointer(1);
                $nf--;
            }
        }
        $b->numbers[]=$nf;
    }
}

function getBits($n){
    global $bitArrayPointer;
    global $bitArray;
    $s="";
    $p=$bitArrayPointer;
    for($i=0;$i<$n;$i++){
        $s.=$bitArray[$p];
        $p++;
        if($p>=sizeof($bitArray)){
            $p=$bitArrayPointer;
        }
    }
    return $s;
}

function advancePointer($n){
    global $bitArrayPointer;
    global $bitArray;

    for($i=0;$i<$n;$i++){
        $bitArrayPointer++;
        if($bitArrayPointer>=sizeof($bitArray)){
            $bitArrayPointer=0;
        }
    }
}

$bitArray = array();
$bitArrayPointer=0;

$byteArray=null;
$hexString="N/A";

if(isset($_GET["format"]) && isset($_GET["data"])){
    switch ($_GET["format"]){
        case "bin":
            foreach (str_split($_GET["data"]) as $bit) {
                $bitArray[]=$bit;
            }
            break;
        case "hex":
            $byteArray=unpack("C*",hex2bin($_GET["data"]));
            $hexString = array_reduce($byteArray, function ($carry, $byte) {
                return $carry . str_pad(dechex($byte), 2, "0", STR_PAD_LEFT);
            }, "");
            foreach ($byteArray as $byte) {
                $bits = str_split(decbin($byte));
                foreach ($bits as $bit) {
                    $bitArray[]=$bit;
                }
            }
            break;
    }
    $format=$_GET["format"];
}

//$fileContents = file_get_contents("RandomNumbers");
//$byteArray = unpack("C*", $fileContents);





/** @var NumBucket[] $numBuckets */
$numBuckets=array();
array_push($numBuckets,
    new NumBucket(1,50,5),
    new NumBucket(1, 12, 2),
    new NumBucket(1,49,5),
    new NumBucket(1,10,1)
);

foreach($numBuckets as $b){
    getNumber($b);
}

?>
<html>
    <head>
        <title>Cristal</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: "Reddit Mono", monospace;
                font-optical-sizing: auto;
                font-weight: <weight>;
                font-style: normal;
                color: chartreuse;
                background: black;
            }
        </style>
    </head>
    <body>
        <pre>
       _
       \`*-.
        )  _`-.
       .  : `. .
       : _   '  \
       ; *` _.   `*-._
       `-.-'          `-.
         ;       `       `.
         :.       .        \
         . \  .   :   .-'   .
         '  `+.;  ;  '      :
         :  '  |    ;       ;-.
         ; '   : :`-:     _.`* ;
      .*' /  .*' ; .*`- +'  `*'
      `*-*   `*-*  `*-*'
        </pre>

    <p><?=sizeof($bitArray)?> : <?=$hexString?></p>
    <p>
        <?php
        foreach ($bitArray as $value) {
            echo $value;
        }
        ?>
    </p>
    <p>
        <?php foreach($numBuckets as $b){ ?>

        <div><b><?=$b->min?>:<?=$b->max?> <?=sizeof($b->numbers)?></b></div>
        <div>
            <?php foreach($b->numbers as $n) { ?>
                <?=$n?>,
            <?php } ?>
        </div>

        <?php } ?>
    </p>
    </body>
</html>
