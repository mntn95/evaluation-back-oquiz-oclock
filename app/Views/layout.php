
<!doctype html>
<html lang="en">
    <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $basePath.DIRECTORY_SEPARATOR ?>assets/css/style.css">
    </head>
    <body class="ml-3">
    <!-- Insertions des partials/contenus -->
    <?= $this->insert('partials/nav') ?>
    <?=$this->section('content')?>
    <hr>
    <footer>
        <div class="copyrights m-4">
            <p class="text-center"><small>&copy; Copyright 2018 - Mathieu N</small></p>
        </div>
    </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="<?= $basePath.DIRECTORY_SEPARATOR ?>assets/js/app.js"></script>
    </body>
</html>
