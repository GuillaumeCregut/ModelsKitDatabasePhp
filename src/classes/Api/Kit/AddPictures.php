<?php

namespace Editiel98\Api\Kit;

use Editiel98\Manager\ModelManager;
use Editiel98\Router\ApiController;
use Exception;

class AddPictures extends ApiController
{
    public function manage()
    {
        if (!$this->isConnected) {
            http_response_code(401);
            die();
        }
        header('Content-Type: application/json');
        if (!isset($_POST['id']) || intval($_POST['id'] === 0)) {
            http_response_code(422);
            die();
        }
        $id = intval($_POST['id']);
        $files = [];
        foreach ($_FILES as $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                continue;
            }
            if ($file["type"] != 'image/jpeg' && $file["type"] != 'image/png') {
                continue;
            }
            if ($file["size"] > 500000) {
                continue;
            }
            $baseDir = $this->storeFile($file["tmp_name"], $file["type"], $id);
            if ($baseDir !== '')
                $files[] = $baseDir;
        }
        $response = [
            'files' => $files,
        ];
        echo json_encode($response);
    }

    private function storeFile(string $tempName, string $type, int $id): string
    {
        $filename = '';
        $baseDir = "assets/uploads/users/{$this->userId}/{$id}/";
        $ext = explode('/', $type)[1];
        $uploadDir = dirname(dirname(dirname(dirname(__DIR__)))) . '/public/';
        if (!is_dir($uploadDir . $baseDir)) {
            mkdir($uploadDir . $baseDir, 0777, true);
            $modelManager = new ModelManager($this->dbConnection);
            $modelManager->updatelinkModelUser($id, $this->userId, $baseDir);
        }
        $filename = $baseDir . uniqid();
        $filenameWithExt = $filename . '.' . $ext;
        $destFile = $uploadDir . $filenameWithExt;
        $resultFile = move_uploaded_file($tempName, $destFile);
        if (!$resultFile) {
            return '';
        }
        return $this->convertPicture($destFile, $filename, $ext, $uploadDir);
    }

    private function convertPicture(string $picture, string $filename, string $ext, string $destFolder): string
    {
        try {
            //Ouvre en mémoire l'image
            if ($ext === 'jpeg') {
                $img = imagecreatefromjpeg($picture);
            } else if ($ext === 'png') {
                $img = imagecreatefrompng($picture);
            }
            if (!$img) {
                return $filename  . '.' . $ext;
            }
            //Convertir en webp
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            //sauvegarde
            $fullName = $filename . '.webp';
            $fullPathFile = $destFolder . $fullName;
            $result = imagewebp($img, $fullPathFile, 80);
            imagedestroy($img);
            //Supprime le fichier originel si tout est OK
            if (file_exists($fullPathFile)  && $result) {
                unlink($picture);
                return $fullName;
            }   
            return $filename  . '.' . $ext;;
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . $e->getMessage(), true, 500);
        }
    }
}
