<?php
require_once "inc/header.php";
Db::changePageToLogin();
?>
<!--Profile Form-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2"><?php include_once "inc/sidebar.php" ?></div>
        <div class="col-xl-10">
            <div id="profile">
                <div class="row align-items-center justify-content-around my-4 my-lg-5">
                    <div class="col-lg-8">
                        <div class="content-body">
                            <div id="message"></div>
                            <form action="" id="profile-form">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">نام کاربری</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="username" name="username"
                                               value="<?php echo $_SESSION["user"]["user_username"] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">ایمیل کاربر</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="Email" name="Email"
                                               value="<?php echo $_SESSION["user"]["user_email"] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">نقش کاربر</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="role" name="role" readonly
                                               value="<?php echo $_SESSION["user"]["user_type"] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">جنسیت کاربر</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="gender" readonly name="gender"
                                               value="<?php echo $_SESSION["user"]["user_gender"] ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <img src="images/background-two-right.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'inc/footer.php' ?>