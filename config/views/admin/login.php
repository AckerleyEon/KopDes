<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kopi Desa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        :root{
            --brown:#5c3d2e;
            --brown-light:#8b6347;
            --cream:#faf7f4;
            --sand:#f0e9e1;
            --ink:#1a1412;
            --muted:#9c8b82;
            --border:#e8ddd6;
        }

        body{

            min-height:100dvh;

            display:flex;
            align-items:center;
            justify-content:center;

            padding:32px 20px;

            overflow-x:hidden;
            overflow-y:auto;

            position:relative;

            background:
            linear-gradient(
                135deg,
                #faf7f4 0%,
                #f6f0eb 35%,
                #f3ece6 70%,
                #faf7f4 100%
            );

            background-attachment:fixed;

            font-family:'DM Sans',sans-serif;
        }

        

        .login-box{

            position:relative;
            z-index:2;

            width:100%;
            max-width:430px;

            margin:auto;

            background:rgba(255,255,255,0.78);

            backdrop-filter:blur(18px);

            border:1px solid rgba(255,255,255,0.6);

            border-radius:28px;

            padding:42px 34px;

            box-shadow:
                0 10px 40px rgba(92,61,46,0.08);

            animation:fadeUp .5s ease;
        }

        @keyframes fadeUp{
            from{
                opacity:0;
                transform:translateY(20px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        .brand{
            text-align:center;
            margin-bottom:30px;
        }

        .brand-small{
            font-size:0.75rem;
            letter-spacing:0.25em;
            color:var(--muted);
            text-transform:uppercase;
            margin-bottom:10px;
        }

        .brand h2{
            font-family:'Playfair Display',serif;
            font-size:2.2rem;
            font-weight:700;
            color:var(--brown);

            margin-bottom:8px;
        }

        .brand p{
            font-size:0.9rem;
            color:var(--muted);
            margin:0;
        }

        .form-label{
            font-size:0.82rem;
            font-weight:600;
            color:var(--ink);

            margin-bottom:8px;
        }

        .form-control{

            height:52px;

            border-radius:14px;

            border:1px solid var(--border);

            background:#fff;

            padding:0 16px;

            font-size:0.92rem;

            transition:all .25s ease;

            box-shadow:none !important;
        }

        .form-control:focus{

            border-color:var(--brown-light);

            box-shadow:
                0 0 0 4px rgba(92,61,46,0.08) !important;
        }

        .form-control::placeholder{
            color:#b6aaa2;
        }

        .show-pw-container{

            display:flex;
            align-items:center;
            gap:10px;

            margin-top:4px;
            margin-bottom:28px;

            font-size:0.82rem;

            color:var(--muted);
        }

        .show-pw-container input{
            width:16px;
            height:16px;
            accent-color:var(--brown);

            cursor:pointer;
        }

        .show-pw-container label{
            cursor:pointer;
            user-select:none;
        }

        .button-group{
            display:flex;
            gap:12px;
        }

        .btn-login{

            flex:2;

            height:52px;

            border:none;

            border-radius:14px;

            background:var(--brown);

            color:white;

            font-size:0.85rem;
            font-weight:700;

            letter-spacing:0.08em;
            text-transform:uppercase;

            transition:all .25s ease;
        }

        .btn-login:hover{

            background:var(--ink);

            transform:translateY(-2px);

            box-shadow:
                0 8px 20px rgba(92,61,46,0.18);
        }

        .btn-reset{

            flex:1;

            height:52px;

            border:none;

            border-radius:14px;

            background:#efe6df;

            color:var(--brown);

            font-size:0.85rem;
            font-weight:700;

            letter-spacing:0.08em;
            text-transform:uppercase;

            transition:all .25s ease;
        }

        .btn-reset:hover{

            background:#e5d7cd;

            transform:translateY(-2px);
        }

        /* Tablet */
        @media (max-width:768px){

            .login-box{
                max-width:100%;
            }

        }

        /* Mobile */
        @media (max-width:576px){

            body{
                padding:20px 16px;
            }

            .login-box{
                padding:34px 22px;
                border-radius:24px;
            }

            .brand h2{
                font-size:1.9rem;
            }

            .brand p{
                font-size:0.82rem;
                line-height:1.6;
            }

            .button-group{
                flex-direction:column;
            }

            .btn-login,
            .btn-reset{
                width:100%;
                padding:14px 12px;
            }

        }

        /* Short Height Device */
        @media (max-height:700px){

            body{
                align-items:flex-start;
            }

            .login-box{
                margin-top:40px;
                margin-bottom:40px;
            }

        }

    </style>
</head>
<body>

<div class="login-box">

    <div class="brand">
        <div class="brand-small">Admin Panel</div>
        <h2>Kopi Desa</h2>
        <p>Masuk untuk mengelola sistem café.</p>
    </div>

    <form action="index.php?page=login_aksi" method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>

            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Masukkan username"
                required
            >
        </div>

        <div class="mb-2">
            <label class="form-label">Password</label>

            <input
                type="password"
                name="password"
                id="passwordInput"
                class="form-control"
                placeholder="Masukkan password"
                required
            >
        </div>

        <div class="show-pw-container">

            <input
                type="checkbox"
                id="showPassword"
                onclick="togglePassword()"
            >

            <label for="showPassword">
                Tampilkan Password
            </label>

        </div>

        <div class="button-group">

            <button type="submit" class="btn-login">
                Login
            </button>

            <button type="reset" class="btn-reset">
                Reset
            </button>

        </div>

    </form>

</div>

<script>

    function togglePassword() {

        var x = document.getElementById("passwordInput");

        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

</script>

</body>
</html>