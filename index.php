<?php
    // Tinglao para el API
    $config = json_decode(file_get_contents('config.json'), true);
    if (!isset($config['publicKey'], $config['privateKey'])) {
        die("Error: Claves API no encontradas en config.json");
    }

    $publicKey = $config['publicKey'];
    $privateKey = $config['privateKey'];
    $ts = time();
    $hash = md5($ts . $privateKey . $publicKey); 
    $url = "https://gateway.marvel.com/v1/public/comics?ts={$ts}&apikey={$publicKey}&hash={$hash}";

    $response = file_get_contents($url);
    $data = json_decode($response, true); 
    $comics = $data['data']['results'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel API - Cómics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        footer {
            color: #666;
            font-size: 0.8rem;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-dark text-light">

    <div class="container py-5">
        <h1 class="text-center mb-4">📚 Cómics de Marvel</h1>
        
        <div class="row">
            <?php if (!empty($comics)): ?>
                <?php foreach ($comics as $comic): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-secondary text-light">
                            <img src="<?= $comic['thumbnail']['path'] . '.' . $comic['thumbnail']['extension'] ?>" class="card-img-top" alt="<?= $comic['title'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $comic['title'] ?></h5>
                                <p class="card-text"><?= substr($comic['description'] ?? "Sin descripción", 0, 100) . "..." ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No se encontraron cómics.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Ángel Redondo Pliego - Tarea DWES 09</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
