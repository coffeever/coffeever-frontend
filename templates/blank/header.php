<?php if($route->printHeader): ?>
<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="utf-8">
    <title><?php echo isset($pageData["title"]) ? $pageData["title"] : 'Aicad Business School'; ?></title>
    <script>NNN='<?php echo makeNonce(INDEX); ?>';</script>
</head>
<body>
<?php endif;?>