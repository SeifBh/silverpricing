<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>SilverPricing | se connecter</title>

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="/sites/all/modules/residence_mgmt/assets/css/dashforge.css">
    <link rel="stylesheet" href="/sites/all/modules/residence_mgmt/assets/css/dashforge.auth.css">
</head>

<body>

    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative">

                <div class="sign-wrapper">
                    <div class="wd-100p">
                        <h3 class="tx-color-01 mg-b-5">Se connecter</h3>
                        <?php print $messages; ?>

                        <form action="/user/login" method="post" id="user-login" accept-charset="UTF-8">
                            <div class="form-group">
                                <label>Utilisateur</label>
                                <input type="text" name="name" class="form-control" placeholder="utilisateur">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between mg-b-5">
                                    <label class="mg-b-0-f">Mot de passe</label>
                                </div>
                                <input type="password" name="pass" class="form-control" placeholder="Mot de passe">
                            </div>

                            <input type="hidden" name="form_build_id"
                                value="<?php echo 'form-' . drupal_random_key(); ?>" />
                            <input type="hidden" name="form_id" value="user_login">

                            <button type="submit" name="op" value="Log in" class="btn btn-brand-02 btn-block">Se
                                connecter</button>
                        </form>
                    </div>
                </div><!-- sign-wrapper -->
            </div><!-- media -->
        </div><!-- container -->
    </div><!-- content -->

</body>

</html>
