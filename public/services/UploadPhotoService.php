<?php
declare(strict_types=1);

class UploadPhotoService
{
    private string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getUploadedPhotoPath(): string
    {
        $fileName = $_FILES['photo']['name'];
        $localPhotoPath = 'resources/uploaded/image/' . $this->name;
        move_uploaded_file($_FILES['photo']['tmp_name'], $localPhotoPath);
        return $localPhotoPath;
    }
}