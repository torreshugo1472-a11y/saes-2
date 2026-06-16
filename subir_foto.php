<?php
session_start();
require 'conexion.php';
require_once 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'alumno') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $archivo = $_FILES['foto']['tmp_name'];
    $nombre_archivo = $_FILES['foto']['name'];
    
    $connectionString = "DefaultEndpointsProtocol=https;AccountName=saes2storage;AccountKey=V9hl2oI+eeg5crY60Bz37aNQam3K8y4ZWDWOFmx8zyeG/QdMEEIBj8bi7HyJ0SY/nymAcVyRNUtf+AStA5nRNA==;EndpointSuffix=core.windows.net";
    $containerName = "foto-perfil"; 

    try {
        $blobClient = BlobRestProxy::createBlobService($connectionString);
        $nombreUnico = uniqid() . "-" . basename($nombre_archivo);
        $content = fopen($archivo, "r");
        $blobClient->createBlockBlob($containerName, $nombreUnico, $content);
        
        $urlFoto = "https://saes2storage.blob.core.windows.net/" . $containerName . "/" . $nombreUnico;
        
        $stmt = $conexion->prepare("UPDATE Usuarios SET foto_perfil = :foto WHERE id_usuario = :id");
        $stmt->execute([':foto' => $urlFoto, ':id' => $id_usuario]);
        
        echo "<link rel='stylesheet' href='style.css'>";
        echo "<div style='text-align: center; margin-top: 50px;'>";
        echo "<h3>✅ ¡Foto subida a la nube de Azure con éxito!</h3><br>";
        echo "<a href='alumno.php'><button>Regresar a mi perfil</button></a>";
        echo "</div>";
        
    } catch(Exception $e) {
        echo "<link rel='stylesheet' href='style.css'>";
        echo "<div style='text-align: center; margin-top: 50px;'>";
        echo "<h3>❌ Error: </h3><p>" . htmlspecialchars($e->getMessage()) . "</p><br>";
        echo "<a href='alumno.php'><button>Regresar a mi perfil</button></a>";
        echo "</div>";
    }
}
?>