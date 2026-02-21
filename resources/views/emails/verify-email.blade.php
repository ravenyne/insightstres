<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Insight Stress</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
            padding: 40px 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .email-header {
            background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            padding: 50px 30px;
            text-align: center;
            position: relative;
        }

        .logo-container {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .logo-container svg {
            width: 56px;
            height: 56px;
        }

        .email-header h1 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 500;
        }

        .email-body {
            padding: 50px 40px;
        }

        .greeting {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .greeting svg {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        .message {
            font-size: 16px;
            line-height: 1.8;
            color: #475569;
            margin-bottom: 36px;
        }

        .message p {
            margin-bottom: 16px;
        }

        .verify-button {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            color: white;
            text-decoration: none;
            padding: 18px 48px;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(20, 184, 166, 0.35);
            transition: all 0.3s ease;
        }

        .verify-button svg {
            width: 24px;
            height: 24px;
        }

        .verify-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(20, 184, 166, 0.45);
        }

        .button-container {
            text-align: center;
            margin: 40px 0;
        }

        .alternative-link {
            margin-top: 36px;
            padding-top: 36px;
            border-top: 2px solid #e2e8f0;
        }

        .alternative-link p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .alternative-link a {
            color: #14b8a6;
            word-break: break-all;
            font-size: 13px;
            font-weight: 500;
        }

        .email-footer {
            background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
            padding: 40px 30px;
            text-align: center;
            border-top: 2px solid #e2e8f0;
        }

        .email-footer p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .email-footer .app-name {
            font-weight: 700;
            color: #14b8a6;
        }

        .warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 5px solid #f59e0b;
            padding: 20px;
            border-radius: 12px;
            margin-top: 36px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .warning svg {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .warning-content {
            flex: 1;
        }

        .warning-content p {
            font-size: 14px;
            color: #92400e;
            margin: 0;
            line-height: 1.6;
        }

        .warning-content strong {
            font-weight: 700;
            color: #78350f;
        }

        @media only screen and (max-width: 600px) {
            .email-header {
                padding: 40px 24px;
            }

            .email-header h1 {
                font-size: 26px;
            }

            .email-body {
                padding: 40px 24px;
            }

            .greeting {
                font-size: 20px;
            }

            .verify-button {
                padding: 16px 36px;
                font-size: 16px;
            }

            .logo-container {
                width: 80px;
                height: 80px;
            }

            .logo-container svg {
                width: 44px;
                height: 44px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo-container">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 6V12L16 14" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1>Insight Stress</h1>
            <p>Platform Monitoring Stres Mahasiswa</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Halo, {{ $user->name }}!</span>
            </div>

            <div class="message">
                <p><strong>Terima kasih telah mendaftar di Insight Stress!</strong></p>
                <p>
                    Untuk mengaktifkan akun Anda dan mulai menggunakan platform monitoring stres kami, 
                    silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:
                </p>
            </div>

            <div class="button-container">
                <a href="{{ $verificationUrl }}" class="verify-button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 4L12 14.01L9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verifikasi Email Saya
                </a>
            </div>

            <div class="alternative-link">
                <p>Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser Anda:</p>
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </div>

            <div class="warning">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.29 3.86L1.82 18C1.64537 18.3024 1.55296 18.6453 1.55199 18.9945C1.55101 19.3437 1.64151 19.6871 1.81445 19.9905C1.98738 20.2939 2.23675 20.5467 2.53773 20.7239C2.83871 20.9011 3.18082 20.9962 3.53 21H20.47C20.8192 20.9962 21.1613 20.9011 21.4623 20.7239C21.7633 20.5467 22.0126 20.2939 22.1856 19.9905C22.3585 19.6871 22.449 19.3437 22.448 18.9945C22.447 18.6453 22.3546 18.3024 22.18 18L13.71 3.86C13.5317 3.56611 13.2807 3.32312 12.9812 3.15448C12.6817 2.98585 12.3437 2.89725 12 2.89725C11.6563 2.89725 11.3183 2.98585 11.0188 3.15448C10.7193 3.32312 10.4683 3.56611 10.29 3.86Z" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 9V13" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 17H12.01" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="warning-content">
                    <p><strong>Penting:</strong> Link verifikasi ini akan kadaluarsa dalam 60 menit. Jika Anda tidak mendaftar di Insight Stress, abaikan email ini.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>Email ini dikirim otomatis oleh <span class="app-name">Insight Stress</span></p>
            <p>Platform Monitoring & Analisis Tingkat Stres Mahasiswa</p>
            <p style="margin-top: 20px; font-size: 12px; color: #94a3b8;">
                © {{ date('Y') }} Insight Stress. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
