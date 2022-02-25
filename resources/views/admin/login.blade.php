<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
</head>
<style>
    @import "https://use.fontawesome.com/releases/v5.5.0/css/all.css";

    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background: url("{{url('public/upload')}}/login.jpg") no-repeat;
        background-size: cover;
    }
    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #fff;
  opacity: 0.6; /* Firefox */
}

    .login-box {
        width: 280px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
    }

    .login-box h1 {
        float: left;
        font-size: 40px;
        border-bottom: 6px solid #4caf50;
        margin-bottom: 50px;
        padding: 13px 0;
    }

    .textbox {
        width: 100%;
        overflow: hidden;
        font-size: 20px;
        padding: 8px 0;
        margin: 8px 0;
        border-bottom: 1px solid #4caf50;
    }

    .textbox i {
        width: 26px;
        float: left;
        text-align: center;
    }

    .textbox input {
        border: none;
        outline: none;
        background: none;
        color: white;
        font-size: 18px;
        width: 80%;
        float: left;
        margin: 0 10px;
    }

    .btn {
        width: 100%;
        background: none;
        border: 2px solid #4caf50;
        color: white;
        padding: 5px;
        font-size: 18px;
        cursor: pointer;
        margin: 12px 0;
    }
</style>

<body>
    <form action="" method="post" id="login">
        @csrf
        <div class="login-box">
            <h1>Đăng nhập</h1>
            <div class="textbox">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Tên đăng nhập" autocomplete="off">
            </div>

            <div class="textbox">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Mật khẩu" autocomplete="off">
            </div>

            <input type="submit" class="btn btn-submit" value="Đăng nhập">
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.all.min.js"></script>
    <script>
        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#login").serialize();
            $.ajax({
                url: "{{route('signin')}}",
                type: "POST",
                data: data,
                success: function(res) {
                    if (res.status == false) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        });
                    }
                    if (res.status == true) {
                        window.location = "{{route('admin.index')}}"
                    }
                }
            })
        })
    </script>
</body>

</html>