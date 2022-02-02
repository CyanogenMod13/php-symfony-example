<?php declare(strict_types=1); ?>

<?php
    include 'services/UploadPhotoService.php';
    $service = new UploadPhotoService('myPhoto');
?>

<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <p>Uploaded photo:</p>
            <div><img src="<?php echo $service->getUploadedPhotoPath(); ?>" alt="photo"/></div>
        </div>
    </body>
</html>

