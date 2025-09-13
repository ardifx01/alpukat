<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Email | ALPUKAT</title>
  <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      integrity="sha384-..." crossorigin="anonymous">
  <link rel="shortcut icon" href="{{ asset('images/logo_kepri.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root{
      --hero-a:#1f2a7a;
      --hero-b:#4456d1;
      --hero-c:#7e8af0;
      --text:#fff;

      --input-bg:#f9fbff;
      --input-bd:#e3e7ff;
      --input-bd-focus:#c9d2ff;
      --input-text:#111;

      --success:#1f8f51;
      --success-bg:#eaf8f0;

      --danger:#b42318;
      --muted:#eef1ff;
      --btn:#23349E;
      --btn-hover:#1a2877;
    }

    html,body{height:100%; margin:0;}
    body{background:#10205e; font-family:system-ui, -apple-system, Segoe UI, Roboto, sans-serif;}

    /* HERO */
    .hero{
      position:relative; display:flex; align-items:center; justify-content:center;
      min-height:100vh; padding:48px 16px;
      background:linear-gradient(135deg,var(--hero-a) 0%, var(--hero-b) 60%, var(--hero-c) 100%);
      color:var(--text); overflow:hidden;
    }
    .decor{position:absolute;border-radius:999px;background:rgba(255,255,255,.08);pointer-events:none}
    .decor-1{right:-60px;top:-60px;width:240px;height:240px}
    .decor-2{left:-80px;bottom:-80px;width:300px;height:300px;background:rgba(255,255,255,.06)}

    .wrap{width:100%;max-width:560px;z-index:1}
    .title{margin:0 0 .25rem 0;font-weight:800;font-size:2rem;text-align:center}
    .subtitle{margin:0 0 1.25rem 0;text-align:center;opacity:.95}

    .card{
      background:rgba(255,255,255,.1);
      border:1px solid rgba(255,255,255,.18);
      border-radius:16px;
      padding:18px;
      backdrop-filter: blur(6px);
    }
    .msg{background:#fff; color:#273044; border-radius:12px; padding:14px 16px; font-size:.95rem}
    .msg-success{background:var(--success-bg); color:var(--success); border:1px solid #cfeedd}

    .actions{display:flex; gap:10px; flex-wrap:wrap; justify-content:space-between; align-items:center; margin-top:14px}

    .btn{
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
      padding:11px 16px; border-radius:12px; font-weight:700; cursor:pointer; border:none;
      text-decoration:none; transition:.15s; font-size:.95rem;
    }
    .btn-primary{background:var(--btn); color:#fff;}
    .btn-primary:hover{background:var(--btn-hover)}
    .btn-outline{background:transparent; color:#fff; border:1px solid rgba(255,255,255,.6)}
    .btn-outline:hover{background:rgba(255,255,255,.12)}

    .muted{color:var(--muted)}
  </style>
</head>
<body>
<section class="hero">
  <span class="decor decor-1"></span>
  <span class="decor decor-2"></span>

  <div class="wrap">
    <header class="text-center">
      <h1 class="title">Verifikasi Email</h1>
      <p class="subtitle">Kami telah mengirim tautan verifikasi ke alamat email Anda.</p>
    </header>

    <div class="card">
      <div class="msg">
        Terima kasih telah mendaftar! Sebelum mulai menggunakan ALPUKAT, silakan verifikasi alamat email Anda
        melalui tautan yang baru saja kami kirim. Jika belum menerima email, Anda bisa meminta kiriman ulang.
      </div>

      @if (session('status') == 'verification-link-sent')
        <div class="msg msg-success" style="margin-top:10px;">
          Tautan verifikasi baru telah kami kirim ke email yang Anda gunakan saat pendaftaran.
        </div>
      @endif

      <div class="actions">
        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-paper-plane"></i> Kirim Ulang Email Verifikasi
          </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline">
            <i class="fa fa-sign-out-alt"></i> Keluar
          </button>
        </form>
      </div>

      <p class="muted" style="margin-top:12px; font-size:.9rem;">
        Pastikan juga memeriksa folder <b>Spam/Junk</b> jika email verifikasi belum terlihat.
      </p>
    </div>
  </div>
</section>
</body>
</html>
