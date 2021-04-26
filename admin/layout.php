<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=2">
    <title><?= $title ?></title>
</head>
<body>
    <div id="wrapper">
        <header>
            header
        </header>
        <main>
            <?php if($info) echo "<p>$info</p>"; ?>
            <div>
                <a href="add.php">Добавить страницу</a>
            </div>
            <?= $content ?>
        </main>
        <footer>
            footer
        </footer>
    </div>
</body>
</html>