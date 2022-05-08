<?php require_once "include.php" ?>
<!doctype html>
<html lang="en">
<?php include_once "head.php" ?>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between w-100 position-fixed fixed-top">
        <a class="navbar-brand" href="#"><img style="width: 180px" src="images/hospital-logo.png"
                                              alt="hospital-logo"></a>
        <a class="" href="#" id="bar"><img src="images/menu.png"></a>
        <?php if (isset($_SESSION["user"]) and !empty($_SESSION["user"])) echo "<a href='logout.php'>خروج</a>"; ?>
    </nav>
</header>
<script>
    $(function () {
        $("#bar").on("click", function () {
            $("#navbar-custom").toggleClass("active")
        })
    })
</script>