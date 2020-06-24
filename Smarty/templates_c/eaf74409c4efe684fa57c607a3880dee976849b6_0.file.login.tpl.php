<?php
/* Smarty version 3.1.34-dev-7, created on 2020-06-24 15:14:00
  from 'C:\xampp\htdocs\AgenziaImmobiliare\Smarty\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5ef35198136de6_08239833',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eaf74409c4efe684fa57c607a3880dee976849b6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\AgenziaImmobiliare\\Smarty\\templates\\login.tpl',
      1 => 1593004430,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ef35198136de6_08239833 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Immobile17 | Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/img/icons/favicon_1.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smart/yvendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/css/main.css">

    <!--===============================================================================================-->
</head>
<body>

<span style="font-family: <?php echo $_smarty_tpl->tpl_vars['path']->value;?>
Smarty/fonts/themify.ttf; color: black; ">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
            <form class="login100-form validate-form flex-sb flex-w">
					<span class="login100-form-title p-b-32">

						Account Login

					</span>
                <form action="/Immobile17/Utente/Login" method="POST">
                <span class="txt1 p-b-11">
						Username
					</span>
                <div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
                    <input class="input100" type="text" name="username" >
                    <span class="focus-input100"></span>
                </div>

                <span class="txt1 p-b-11">
						Password
					</span>
                <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
                    <input class="input100" type="password" name="pass" >
                    <span class="focus-input100"></span>
                </div>

                <div class="flex-sb-m w-full p-b-48">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
                            Remember me
                        </label>
                    </div>

                    <div>
                        <a href="#" class="txt3">
                            Forgot Password?
                        </a>
                    </div>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="vendor/jquery/jquery-3.2.1.min.js"><?php echo '</script'; ?>
>
<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="vendor/animsition/js/animsition.min.js"><?php echo '</script'; ?>
>
<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="vendor/bootstrap/js/popper.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="vendor/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="vendor/select2/select2.min.js"><?php echo '</script'; ?>
>
<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="vendor/daterangepicker/moment.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="vendor/daterangepicker/daterangepicker.js"><?php echo '</script'; ?>
>
<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="vendor/countdowntime/countdowntime.js"><?php echo '</script'; ?>
>
<!--===============================================================================================-->
<?php echo '<script'; ?>
 src="js/main.js"><?php echo '</script'; ?>
>

</body>
</html><?php }
}