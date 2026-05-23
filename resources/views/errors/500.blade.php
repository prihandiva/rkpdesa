<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Terjadi Kesalahan | SIPDES</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        .icon {
            width: 80px;
            height: 80px;
            background: #fee2e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }
        h1 { font-size: 3rem; font-weight: 800; color: #1e293b; line-height: 1; }
        h2 { font-size: 1.25rem; font-weight: 600; color: #374151; margin: 0.5rem 0 1rem; }
        p  { color: #6b7280; font-size: 0.95rem; line-height: 1.6; margin-bottom: 2rem; }
        .msg {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            color: #92400e;
            margin-bottom: 2rem;
            text-align: left;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: #4f46e5;
            color: #fff;
        }
        .btn-primary:hover { background: #4338ca; transform: translateY(-1px); }
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            margin-left: 0.5rem;
        }
        .btn-secondary:hover { background: #e5e7eb; }
        .footer { margin-top: 2rem; font-size: 0.8rem; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">⚠️</div>
        <h1>500</h1>
        <h2>Terjadi Kesalahan Server</h2>
        <p>Maaf, terjadi kesalahan yang tidak terduga. Tim kami telah dicatat mengenai masalah ini.</p>

        @if(isset($message))
        <div class="msg">
            <strong>Info:</strong> {{ $message }}
        </div>
        @endif

        <div>
            <a href="javascript:history.back()" class="btn btn-primary">
                ← Kembali
            </a>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">
                🏠 Dashboard
            </a>
        </div>

        <div class="footer">
            SIPDES &mdash; Sistem Informasi Perencanaan Desa
        </div>
    </div>
</body>
</html>
