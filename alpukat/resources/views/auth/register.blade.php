<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar | ALPUKAT</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root{
      --hero-a:#1f2a7a; --hero-b:#4456d1; --hero-c:#7e8af0; --text:#fff;
      --input-bg:#f9fbff; --input-bd:#e3e7ff; --input-bd-focus:#c9d2ff;
      --input-text:#111; --placeholder:#a9b6cc; --placeholder-focus:#c3ccda;
      --btn:#23349E; --btn-hover:#1a2877; --danger:#b42318;
    }
    html,body{height:100%;margin:0}
    body{background:#10205e;font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif}

    /* ===== FULL HERO (ringkas, sama rasa dgn login) ===== */
    .hero{
      position:relative; display:flex; align-items:center; justify-content:center;
      padding:32px 16px; min-height:100vh;
      background:linear-gradient(135deg,var(--hero-a) 0%, var(--hero-b) 60%, var(--hero-c) 100%);
      color:var(--text); overflow:hidden;
    }
    .decor{position:absolute;border-radius:999px;background:rgba(255,255,255,.08);pointer-events:none}
    .decor-1{right:-60px;top:-60px;width:200px;height:200px}
    .decor-2{left:-60px;bottom:-60px;width:260px;height:260px;background:rgba(255,255,255,.06)}

    .wrap{width:100%;max-width:460px;z-index:1}
    .title{margin:0 0 .25rem 0;font-weight:800;font-size:1.9rem;text-align:center}
    .subtitle{margin:0 0 1rem 0;text-align:center;opacity:.95;font-size:.95rem}

    .form{display:flex;flex-direction:column;gap:14px}
    .form-label{font-weight:600;color:#eef1ff;font-size:.9rem}

    /* === INPUT (seragam dgn login) === */
    .form-input{
      width:100%; margin-top:4px;
      padding:10px 44px 10px 12px;  /* ruang kanan utk ikon mata */
      border-radius:10px; font-size:.95rem;
      background:var(--input-bg) !important; border:1px solid var(--input-bd);
      color:var(--input-text) !important; caret-color:var(--input-text);
    }
    .form-input::placeholder{color:var(--placeholder);opacity:1}
    .form-input:focus{
      outline:none; background:#fff !important; border-color:var(--input-bd-focus);
      color:var(--input-text) !important;
    }
    .form-input:focus::placeholder{color:var(--placeholder-focus)}
    /* Autofill */
    input.form-input:-webkit-autofill{
      -webkit-text-fill-color:var(--input-text) !important;
      transition: background-color 9999s ease-in-out 0s;
      box-shadow:0 0 0 1000px #fff inset;
    }

    .input-wrap{position:relative}
    .toggle-pass{
      position:absolute; right:8px; top:50%; transform:translateY(-50%);
      background:transparent; border:none; padding:6px; border-radius:8px;
      color:#5060b3; cursor:pointer;
    }
    .toggle-pass:hover{background:#eef2ff}

    .form-error{color:var(--danger); background:#fff; border-radius:8px; padding:5px 8px; margin-top:4px;font-size:.8rem}

    .btn-primary{
      background:var(--btn); color:#fff; font-weight:700;
      padding:10px; border:none; border-radius:12px; cursor:pointer; width:100%;
    }
    .btn-primary:hover{background:var(--btn-hover)}
    .link-small{color:#fff;text-decoration:underline;font-weight:600;font-size:.9rem}
    .meta{color:#eef1ff;text-align:center;font-size:.9rem;margin-top:.5rem}
  </style>
</head>
<body>
  <section class="hero">
    <span class="decor decor-1"></span>
    <span class="decor decor-2"></span>

    <div class="wrap">
      <header class="text-center">
        <h1 class="title">Register</h1>
        <p class="subtitle">Buat akun baru untuk menggunakan <b>ALPUKAT</b></p>
      </header>

      <form method="POST" action="{{ route('register') }}" class="form" novalidate>
        @csrf

        {{-- Nama --}}
        <div>
          <x-input-label for="name" :value="__('Nama Lengkap')" class="form-label" />
          <x-text-input id="name" class="form-input"
                        type="text" name="name" :value="old('name')" required autofocus
                        autocomplete="name" placeholder="Masukkan Nama Lengkap" />
          <x-input-error :messages="$errors->get('name')" class="form-error" />
        </div>

        {{-- Email --}}
        <div>
          <x-input-label for="email" :value="__('Email')" class="form-label" />
          <x-text-input id="email" class="form-input"
                        type="email" name="email" :value="old('email')" required
                        autocomplete="username" placeholder="Masukkan Alamat Email" />
          <x-input-error :messages="$errors->get('email')" class="form-error" />
        </div>

        {{-- Password + ikon mata --}}
        <div>
          <x-input-label for="password" :value="__('Password')" class="form-label" />
          <div class="input-wrap">
            <x-text-input id="password" class="form-input"
                          type="password" name="password" required
                          autocomplete="new-password" placeholder="Masukkan Password (min. 8 karakter)" />
            <button type="button" class="toggle-pass" data-target="password" aria-label="Tampilkan password">
              <i class="fa fa-eye"></i>
            </button>
          </div>
          <x-input-error :messages="$errors->get('password')" class="form-error" />
        </div>

        {{-- Konfirmasi Password + ikon mata --}}
        <div>
          <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="form-label" />
          <div class="input-wrap">
            <x-text-input id="password_confirmation" class="form-input"
                          type="password" name="password_confirmation" required
                          autocomplete="new-password" placeholder="Ulangi Password" />
            <button type="button" class="toggle-pass" data-target="password_confirmation" aria-label="Tampilkan password">
              <i class="fa fa-eye"></i>
            </button>
          </div>
          <x-input-error :messages="$errors->get('password_confirmation')" class="form-error" />
        </div>

        <button type="submit" class="btn-primary">Register</button>

        <p class="meta">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="link-small">Login</a>
        </p>
      </form>
    </div>
  </section>

  <script>
    // Toggle show/hide untuk semua tombol .toggle-pass
    document.querySelectorAll('.toggle-pass').forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (!input) return;

        const isHidden = input.getAttribute('type') === 'password';
        input.setAttribute('type', isHidden ? 'text' : 'password');

        const icon = btn.querySelector('i');
        icon.classList.toggle('fa-eye', !isHidden);
        icon.classList.toggle('fa-eye-slash', isHidden);

        btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        input.focus({preventScroll:true});
      });
    });
  </script>
</body>
</html>
