<?php
require('../config.php');
require('../class.php');

$src = "Hukumonline.com";
$api_link = "src/hukumonline.php";
$loginUrl   = "https://www.hukumonline.com/berita/utama";

$grep = new Grabweb();
libxml_use_internal_errors(true);
$grep->getPage($loginUrl);
$data = $grep->htmlResult; 

$dom = new DOMDocument();
$dom->loadHTML($data);

$konten = new DOMXpath($dom);
$article = $konten->query("//*[@type='application/ld+json']");
$articles = json_decode($article[0]->nodeValue,1); 

$dataset = array();
if(isset($articles['itemListElement']) && $articles['itemListElement']) {
    foreach($articles['itemListElement'] as $isi) {

        $time = strtotime($isi['datePublished']);
        $dateInLocal = date("d F Y H:i:s", $time);
        $datetimer   = date("YmdHis", $time);

                    $dataset[]  = array("title"     => strip_tags($isi['headline']),
                                        "src"       => "Hukumonline.com",
                                        "thumb"     => $isi['image'],
                                        "link"      => $isi['url'],
                                        "date"      => $dateInLocal,
                                        "id"        => $datetimer,
                                        );
    }
}

$filecontrol = "HUKUMONLINE";
$grep->save($filecontrol,json_encode($dataset));

    header('Content-Type: application/json');
    $output = array("dataset"   => $dataset,
                    "raw"       => "",
                    //"preview"   => $dom->saveHTML(),
                    "preview"   => "",
                    "api_link"  => "<a href='$api_link' target='_blank'>Disini</a>",
                    );
    echo json_encode($output);
?>