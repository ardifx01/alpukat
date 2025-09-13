<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password | ALPUKAT</title>
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

      /* Input palette – konsisten dg login/register */
      --input-bg:#f9fbff;
      --input-bd:#e3e7ff;
      --input-bd-focus:#c9d2ff;
      --input-text:#111;
      --placeholder:#a9b6cc;
      --placeholder-focus:#c3ccda;

      --danger:#b42318;
      --success:#1f8f50;
    }
    html,body{height:100%; margin:0;}
    body{background:#10205e; font-family:system-ui, -apple-system, Segoe UI, Roboto, sans-serif;}

    /* ===== FULL HERO SECTION ===== */
    .hero{
      position:relative;
      display:flex; align-items:center; justify-content:center;
      padding:48px 16px;
      min-height:100vh;
      background:linear-gradient(135deg,var(--hero-a) 0%, var(--hero-b) 60%, var(--hero-c) 100%);
      color:var(--text);
      overflow:hidden;
    }
    .decor{position:absolute;border-radius:999px;background:rgba(255,255,255,.08);pointer-events:none}
    .decor-1{right:-60px;top:-60px;width:240px;height:240px}
    .decor-2{left:-70px;bottom:-70px;width:300px;height:300px;background:rgba(255,255,255,.06)}

    .wrap{width:100%;max-width:520px;z-index:1}
    .title{margin:0 0 .35rem 0;font-weight:800;font-size:2rem;text-align:center}
    .subtitle{margin:0 0 1.2rem 0;text-align:center;opacity:.95}

    .status{
      background:#e9fff3; color:var(--success);
      border:1px solid #c7f1db; border-radius:10px;
      padding:.75rem .9rem; margin-bottom:1rem;
    }
    .error{
      color:var(--danger); background:#fff; border-radius:10px;
      padding:.5rem .65rem; margin-top:.4rem; border:1px solid #ffd3d6;
    }

    .form{display:flex;flex-direction:column;gap:14px}
    .form-label{font-weight:600;color:#eef1ff}

    /* Input – konsisten */
    .form-input{
      width:100%; margin-top:6px;
      padding:12px 14px; border-radius:12px; font-size:1rem;
      background:var(--input-bg) !important;
      border:1px solid var(--input-bd);
      color:var(--input-text) !important;
      caret-color:var(--input-text);
    }
    .form-input::placeholder{color:var(--placeholder); opacity:1}
    .form-input::-webkit-input-placeholder{color:var(--placeholder)}
    .form-input:-ms-input-placeholder{color:var(--placeholder)}
    .form-input:focus{
      outline:none; background:#fff !important; border-color:var(--input-bd-focus);
      color:var(--input-text) !important;
    }
    .form-input:focus::placeholder{color:var(--placeholder-focus)}
    .form-input:focus::-webkit-input-placeholder{color:var(--placeholder-focus)}
    .form-input:focus:-ms-input-placeholder{color:var(--placeholder-focus)}
    input.form-input:-webkit-autofill{
      -webkit-text-fill-color:var(--input-text) !important;
      transition: background-color 9999s ease-in-out 0s;
      box-shadow:0 0 0 1000px #fff inset;
    }

    .btn-primary{
      background:#23349E; color:#fff; font-weight:700;
      padding:12px; border:none; border-radius:14px; cursor:pointer; width:100%;
    }
    .btn-primary:hover{background:#1a2877}

    .link-white{color:#fff; text-decoration:underline; font-weight:600}
    .back{color:#eef1ff; text-align:center; margin-top:.6rem}
  </style>
</head>
<body>

<section class="hero">
  <span class="decor decor-1"></span>
  <span class="decor decor-2"></span>

  <div class="wrap">
    <header class="text-center">
      <h1 class="title">Lupa Password</h1>
      <p class="subtitle">
        Masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
      </p>
    </header>

    {{-- Session Status --}}
    @if (session('status'))
      <div class="status">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="form" novalidate>
      @csrf

      {{-- Email --}}
      <div>
        <x-input-label for="email" :value="__('Email')" class="form-label" />
        <x-text-input id="email" class="form-input"
                      type="email" name="email" :value="old('email')" required autofocus
                      autocomplete="username" placeholder="Masukkan Alamat Email" />
        <x-input-error :messages="$errors->get('email')" class="error" />
      </div>

      {{-- Button --}}
      <button type="submit" class="btn-primary">
        Kirim Tautan Reset Password
      </button>

      <p class="back">
        Kembali ke <a href="{{ route('login') }}" class="link-white">Login</a>
      </p>
    </form>
  </div>
</section>

</body>
</html>
