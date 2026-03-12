<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Login Administrator - Insight Stress</title>
    @vite('resources/css/app.css')

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background-color: #0f172a;
            background-image: radial-gradient(circle at center, rgba(20,184,166,0.08), transparent 65%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .login-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 48px;
        }

        /* Remove brand-icon flex styling since login-header handles it now */

        .brand-icon-box {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #14b8a6, #0d9488);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(20,184,166,0.35);
        }

        .brand-icon-box svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 600;
            color: #e2e8f0;
            letter-spacing: 0.3px;
        }

        .admin-badge {
            display: inline-block;
            padding: 5px 10px;
            background: rgba(20,184,166,0.05);
            border: 1px solid rgba(20,184,166,0.35);
            border-radius: 20px;
            font-size: 11px;
            color: #14b8a6;
            margin-left: 4px;
        }

        /* Card */
        .login-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 44px 40px;
            width: 440px;
            max-width: 92%;
            margin: 0 auto;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.04);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #e2e8f0;
            text-align: center;
            margin-bottom: 0.4rem;
            letter-spacing: -0.02em;
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Divider removed */

        /* Alert boxes */
        .alert {
            padding: 0.875rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
        }

        .alert-success {
            background: rgba(20,184,166,0.1);
            border: 1px solid rgba(20,184,166,0.3);
            color: #5eead4;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            padding-left: 1rem;
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
            color: #475569;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #e2e8f0;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input::placeholder { color: #475569; }

        .form-input:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20,184,166,0.15);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background: linear-gradient(135deg, #14b8a6, #0d9488);
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 22px;
            box-shadow: 0 8px 20px rgba(20,184,166,0.25);
            letter-spacing: 0.01em;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            box-shadow: 0 12px 28px rgba(20,184,166,0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit svg {
            width: 18px;
            height: 18px;
            transition: transform 0.2s;
        }

        .btn-submit:hover svg { transform: translateX(3px); }

        /* Back link */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 16px;
            font-size: 13px;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link svg { width: 14px; height: 14px; }

        .back-link:hover { color: #14b8a6; }
        .back-link:hover svg { stroke: #14b8a6; }

        /* Security badge at bottom */
        .security-footer {
            text-align: center;
            margin-top: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            color: #64748b;
            font-size: 12px;
        }

        .security-footer svg { width: 12px; height: 12px; }
    </style>
</head>
<body>

    <div class="login-wrapper">

        {{-- Branding --}}
        <div class="login-header">
            <div class="brand-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <span class="brand-name">Admin Panel</span>
            <div class="admin-badge">Insight Stress Platform</div>
        </div>

        {{-- Login Card --}}
        <div class="login-card">

            <h2 class="card-title" data-i18n="card_title">Login Administrator</h2>
            <p class="card-subtitle" data-i18n="card_subtitle">Masuk untuk mengelola sistem</p>

            {{-- Session Messages --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Login Form --}}
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" data-i18n="lbl_email">Email Admin</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="emailInput"
                            placeholder="admin@insightstress.id"
                            data-i18n-placeholder="placeholder_email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="form-input"
                        >
                    </div>
                    @error('email')
                        <p style="color:#f87171;font-size:0.78rem;margin-top:0.35rem;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" data-i18n="lbl_password">Password</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="••••••••"
                            data-i18n-placeholder="placeholder_password"
                            required
                            autocomplete="current-password"
                            class="form-input"
                        >
                    </div>
                    @error('password')
                        <p style="color:#f87171;font-size:0.78rem;margin-top:0.35rem;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit">
                    <span data-i18n="btn_login">Masuk</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            {{-- Back Link --}}
            <a href="{{ route('login') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span data-i18n="link_back">Kembali ke login mahasiswa</span>
            </a>
        </div>

        {{-- Security Footer --}}
        <div class="security-footer">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Secured Admin Access · Insight Stress Platform
        </div>
    </div>

    <script>
        // ===== ADMIN LOGIN i18n =====
        const i18nLogin = {
            id: {
                page_title: 'Login Administrator - Insight Stress',
                card_title: 'Login Administrator',
                card_subtitle: 'Masuk untuk mengelola sistem',
                lbl_email: 'Email Admin',
                lbl_password: 'Password',
                placeholder_email: 'Masukkan email admin',
                placeholder_password: 'Masukkan password',
                btn_login: 'Masuk',
                link_back: 'Kembali ke login mahasiswa'
            },
            en: {
                page_title: 'Administrator Login - Insight Stress',
                card_title: 'Administrator Login',
                card_subtitle: 'Sign in to manage the system',
                lbl_email: 'Admin Email',
                lbl_password: 'Password',
                placeholder_email: 'Enter admin email',
                placeholder_password: 'Enter password',
                btn_login: 'Sign In',
                link_back: 'Back to student login'
            }
        };

        function applyLoginI18n() {
            const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nLogin[lang] || i18nLogin['id'];

            // Text content
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) el.textContent = t[key];
            });

            // Placeholders
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key] !== undefined) el.placeholder = t[key];
            });

            // Page title
            document.title = t['page_title'];
        }

        applyLoginI18n();

        // Sync across tabs
        window.addEventListener('storage', function(e) {
            if (e.key === 'app_language') applyLoginI18n();
        });
    </script>

</body>
</html>
