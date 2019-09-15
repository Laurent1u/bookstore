<?php
require_once './config.php';

if($page) {
    //php page
    include(tepCheckPath(PATH_PHP . $page . '.php'));
} else {
    include(tepCheckPath(PATH_PHP . '/book_list.php'));
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo DIR_CSS . 'style.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css"/>
    <title>Book Store</title>
</head>
<body>
<div class="container">
    <div class="header">
        <?php require_once './header.php'; ?>
    </div>
    <?php
    if ($page) {
        include tepCheckPath(PATH_HTML . $page . '.php');
    } else {
        include tepCheckPath(PATH_HTML . 'book_list.php');
    }
    ?>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo DIR_JS . 'helper.js'; ?>"></script>
</body>
</html>