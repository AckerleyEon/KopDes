<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Kopi Desa - Welcome</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html,
        body{
            width:100%;
            height:100%;
            overflow:hidden;
            font-family:'Poppins',sans-serif;
            background:#000;
        }

        body{
            position:relative;
        }

        .hero{
            position:relative;

            width:100%;
            height:100vh;

            display:flex;
            align-items:center;
            justify-content:center;

            overflow:hidden;
        }

        /* Background */
        .hero-bg{
            position:absolute;
            inset:0;

            background:
                linear-gradient(
                    180deg,
                    rgba(35, 25, 17, 0.45),
                    rgba(41, 36, 28, 0.78)
                ),
                url('assets/images/bg-cafe.jpg');

            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;

            transform:scale(1.05);
        }

        /* Glow */
        .hero::before{
            content:"";

            position:absolute;
            top:-200px;
            right:-120px;

            width:500px;
            height:500px;

            background:rgba(255,255,255,0.05);

            filter:blur(120px);

            border-radius:50%;

            z-index:1;
        }

        .hero::after{
            content:"";

            position:absolute;
            bottom:-250px;
            left:-120px;

            width:500px;
            height:500px;

            background:rgba(111,78,55,0.25);

            filter:blur(120px);

            border-radius:50%;

            z-index:1;
        }

        .content{
            position:relative;
            z-index:3;

            width:100%;
            max-width:950px;

            padding:24px;

            text-align:center;
            color:white;
        }

        .top-badge{
            
            display:inline-flex;
            align-items:center;
            gap:10px;

            padding:10px 18px;

            border-radius:999px;

            background:rgba(255,255,255,0.08);

            border:1px solid rgba(255,255,255,0.1);

            backdrop-filter:blur(12px);

            margin-bottom:30px;

            font-size:0.85rem;
            font-weight:500;

            color:rgba(255,255,255,0.85);

            box-shadow:
                0 4px 20px rgba(0,0,0,0.15);
        }

        .hero-title{
            font-family: 'Playfair Display', serif;
            font-size:clamp(3rem, 9vw, 7rem);

            font-weight:700;

            line-height:1;

            letter-spacing:6px;

            margin-bottom:20px;

            text-shadow:
                0 8px 30px rgba(0,0,0,0.35);
        }

        .hero-subtitle{
            width:100%;
            max-width:650px;

            margin:0 auto;

            font-size:clamp(0.95rem, 2vw, 1.1rem);

            line-height:1.9;

            color:rgba(255,255,255,0.72);

            font-weight:300;
        }

        .button-group{
            margin-top:45px;

            display:flex;
            align-items:center;
            justify-content:center;

            gap:16px;

            flex-wrap:wrap;
        }

        .btn-menu{
            min-width:200px;

            padding:16px 34px;

            border-radius:999px;

            border:none;

            text-decoration:none;

            background:white;
            color:#111;

            font-weight:600;

            transition:all .35s ease;

            box-shadow:
                0 10px 35px rgba(0,0,0,0.3);
        }

        .btn-menu:hover{
            transform:
                translateY(-4px)
                scale(1.02);

            color:#000;

            background:#f2f2f2;
        }

        .btn-secondary-custom{
            min-width:200px;

            padding:16px 34px;

            border-radius:999px;

            text-decoration:none;

            color:white;

            border:1px solid rgba(255,255,255,0.15);

            background:rgba(255,255,255,0.06);

            backdrop-filter:blur(10px);

            transition:all .35s ease;
        }

        .btn-secondary-custom:hover{
            background:rgba(255,255,255,0.12);

            color:white;

            transform:translateY(-4px);
        }

        .bottom-text{
            position:absolute;

            bottom:28px;
            left:50%;

            transform:translateX(-50%);

            z-index:5;

            color:rgba(255,255,255,0.5);

            font-size:0.82rem;

            letter-spacing:2px;
        }

        @media (max-width:768px){

            .content{
                padding:20px;
            }

            .hero-title{
                letter-spacing:3px;
            }

            .hero-subtitle{
                line-height:1.8;
            }

            .button-group{
                margin-top:35px;
            }

            .btn-menu,
            .btn-secondary-custom{
                width:100%;
                max-width:280px;
            }

        }

    </style>
</head>

<body>

    <section class="hero">

        <div class="hero-bg"></div>

        <div class="content">

            <?php if(isset($_SESSION['no_meja'])): ?>
                <div class="top-badge">
                    Selamat Datang Customer di Meja <?= $_SESSION['no_meja'] ?? '0' ?>
                </div>
            <?php endif; ?>

            <h1 class="hero-title">
                KOPI DESA
            </h1>

            <p class="hero-subtitle">
                Tempat dimana aroma kopi, suasana hangat,
                dan cerita sederhana bertemu dalam satu pengalaman
                yang nyaman dan berkesan.
            </p>

            <div class="button-group">

                <a
                    href="index.php?page=menu"
                    class="btn-menu"
                >
                    Lihat Menu
                </a>

            </div>

        </div>

        <div class="bottom-text">
            EST. 2026
        </div>

    </section>

</body>
</html>