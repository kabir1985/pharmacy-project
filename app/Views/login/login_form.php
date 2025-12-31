<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - POS Inventory</title>
     <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>POS Inventory</h1>
    </div>

    <div class="login-box">
      <form class="login-form" id="loginForm">
        <?= csrf_field() ?>
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i> SIGN IN</h3>

        <div class="form-group">
          <label class="control-label">USERNAME</label>
          <input class="form-control" type="text" name="username" placeholder="User Name" autofocus>
        </div>

        <div class="form-group">
          <label class="control-label">PASSWORD</label>
          <input class="form-control" type="password"  name="password" placeholder="Password">
        </div>

        <div class="form-group btn-container">
          <button  type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-sign-in fa-lg fa-fw"></i> SIGN IN
          </button>
        </div>
        <div id="msg" style="color:red; margin-top:10px;"></div>
      </form>
    </div>
  </section>

   <script>
$(document).ready(function(){
    $("#loginForm").on("submit", function(e){
        e.preventDefault();

        $.ajax({
            url: "<?= site_url('login/auth') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                console.log(res);

                if(res.status === "success"){
                    window.location.href = res.redirect;
                } else {
                    $("#msg").text(res.msg);
                }
            },
            error: function(xhr){
                console.log(xhr.responseText);
                $("#msg").text("Server error or invalid JSON response.");
            }
        });
    });
});
</script>

</body>
</html>
