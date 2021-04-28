<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title><?= $title ?></title>
</head>
<body>
    <div id="wrapper">
        <header>
            <?php //include 'elems/header.php' ?>
        </header>
        <main>
            <?php if (isset($blog)) echo $blog; ?>
            <?php if (isset($content)) echo $content; ?>
        </main>
        <footer>
            <?php include 'elems/footer.php' ?>
        </footer>
    </div>
</body>
</html>