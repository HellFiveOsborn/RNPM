<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Arquivos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .bg-dark-95 {
            background-color: rgba(var(--bs-dark-rgb), 0.95) !important;
        }
    </style>
</head>

<body class="bg-dark-95 text-light">
    <div class="container mt-4">
        <h1>Lista de Arquivos</h1>
        <div class="card bg-dark border-success mb-3">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <strong>Arquivo</strong>
                    <strong>Data/Permissão</strong>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    $dir = './'; // Diretório atual
                    $files = scandir($dir); // Lista os arquivos do diretório

                    foreach ($files as $file) {
                        if ($file === '.' || $file === '..') continue; // Ignora as entradas "." e ".."

                        $fileInfo = stat($dir . $file);
                        $creationTime = date('d/m/Y H:i:s', $fileInfo['ctime']);
                        $permissions = substr(sprintf('%o', $fileInfo['mode']), -4);

                        echo '<li class="list-group-item  border-success bg-dark text-light d-flex justify-content-between align-items-center">';
                        echo $file;
                        echo '<div>Perm: ' . $permissions . ' | Criado: ' . $creationTime . '</div>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script>
        const popover = new bootstrap.Popover('.hover', {});
    </script>
</body>

</html>