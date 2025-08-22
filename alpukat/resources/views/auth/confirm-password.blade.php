<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Password | ALPUKAT</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root{
      --hero-a:#1f2a7a;
      --hero-b:#4456d1;
      --hero-c:#7e8af0;
      --text:#fff;

      /* theme input — SERAGAM dengan login & register */
      --input-bg:#f9fbff;
      --input-bd:#e3e7ff;
      --input-bd-focus:#c9d2ff;
      --input-text:#111;
      --placeholder:#a9b6cc;
      --placeholder-focus:#c3ccda;

      --danger:#b42318;
    }
    html,body{height:100%; margin:0;}
    body{background:#10205e; font-family:system-ui, -apple-system, Segoe UI, Roboto, sans-serif;}

    /* ===== FULL HERO ===== */
    .hero{
      position:relative;
      display:flex; align-items:center; justify-content:center;
      min-height:100vh; padding:48px 16px;
      background:linear-gradient(135deg,var(--hero-a) 0%, var(--hero-b) 60%, var(--hero-c) 100%);
      color:var(--text); overflow:hidden;
    }
    .decor{position:absolute;border-radius:999px;background:rgba(255,255,255,.08);pointer-events:none}
    .decor-1{right:-60px;top:-60px;width:240px;height:240px}
    .decor-2{left:-70px;bottom:-70px;width:300px;height:300px;background:rgba(255,255,255,.06)}

    .wrap{width:100%;max-width:440px;z-index:1}
    .title{margin:0 0 .35rem 0;font-weight:800;font-size:2rem;text-align:center}
    .subtitle{margin:0 0 1.25rem 0;text-align:center;opacity:.95}

    .form{display:flex;flex-direction:column;gap:14px}
    .form-label{font-weight:600;color:#eef1ff}
    .form-input{
      width:100%; margin-top:6px;
      padding:12px 14px; border-radius:12px; font-size:1rem;
      background:var(--input-bg) !important; border:1px solid var(--input-bd);
      color:var(--input-text) !important; caret-color:var(--input-text);
    }
    .form-input::placeholder{color:var(--placeholder); opacity:1}
    .form-input:focus{
      outline:none; background:#fff !important; border-color:var(--input-bd-focus);
      color:var(--input-text) !important;
    }
    .form-input:focus::placeholder{color:var(--placeholder-focus)}
    /* Autofill consistency */
    input.form-input:-webkit-autofill{
      -webkit-text-fill-color:var(--input-text) !important;
      transition: background-color 9999s ease-in-out 0s;
      box-shadow:0 0 0 1000px #fff inset;
    }

    .form-error{color:var(--danger); background:#fff; border-radius:8px; padding:6px 8px; margin-top:6px}

    .btn-primary{
      background:#23349E; color:#fff; font-weight:700;
      padding:12px; border:none; border-radius:14px; cursor:pointer; width:100%;
    }
    .btn-primary:hover{background:#1a2877}

    .actions{display:flex; gap:10px; align-items:center; justify-content:flex-end; margin-top:6px}
    .link-muted{color:#eef1ff; text-decoration:underline}
  </style>
</head>
<body>
  <section class="hero">
    <span class="decor decor-1"></span>
    <span class="decor decor-2"></span>

    <div class="wrap">
      <header class="text-center">
        <h1 class="title">Konfirmasi Password</h1>
        <p class="subtitle">
          Ini adalah area aman. Masukkan password Anda untuk melanjutkan.
        </p>
      </header>

      <form method="POST" action="{{ route('password.confirm') }}" class="form" novalidate>
        @csrf

        {{-- Password --}}
        <div>
          <x-input-label for="password" :value="__('Password')" class="form-label" />
          <x-text-input id="password" class="form-input"
                        type="password" name="password" required
                        autocomplete="current-password" placeholder="Masukkan Password Anda" />
          <x-input-error :messages="$errors->get('password')" class="form-error" />
        </div>

        {{-- Actions --}}
        <div class="actions">
          <button type="submit" class="btn-primary">Konfirmasi</button>
        </div>
      </form>
    </div>
  </section>
</body>
</html>
