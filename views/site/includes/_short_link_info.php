<?php

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use yii\helpers\Url;

$shortLink = Url::to(['site/redirect-url', 'short_url' => $model->short_link]);
$fullShortLink = Yii::$app->params['siteUrl'] . $shortLink;
$qrCode = QrCode::create($fullShortLink)
    ->setEncoding(new Encoding('UTF-8'))
    ->setSize(150)
    ->setMargin(10);

$pngWriter = new PngWriter();
$result = $pngWriter->write($qrCode);

$imageData = $result->getString();
$dataUri = 'data:image/png;base64,' . base64_encode($imageData);
?>


<h4 class="text-center">Вот ваша короткая ссылка: <a class=" text-warning" href="<?= $fullShortLink ?>"><?= $shortLink ?></a></h4>
<img class="d-block mx-auto pt-3" src="<?= $dataUri ?>" alt="QR Code">
