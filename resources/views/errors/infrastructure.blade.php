<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta name="color-scheme" content="dark" />
        <title>Service unavailable — Kamali Architects</title>
        <style>
            :root {
                --bg: #1a1a18;
                --cream: #f5f0e8;
                --cream-muted: rgba(245, 240, 232, 0.72);
                --gold: #c9a227;
                --border: rgba(245, 240, 232, 0.12);
            }
            * {
                box-sizing: border-box;
            }
            body {
                margin: 0;
                min-height: 100dvh;
                font-family:
                    ui-sans-serif,
                    system-ui,
                    -apple-system,
                    'Segoe UI',
                    Roboto,
                    'Helvetica Neue',
                    Arial,
                    sans-serif;
                background: var(--bg);
                color: var(--cream);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.25rem 3rem;
                line-height: 1.55;
            }
            .wrap {
                max-width: 32rem;
                width: 100%;
            }
            .label {
                font-size: 0.7rem;
                letter-spacing: 0.28em;
                text-transform: uppercase;
                color: var(--cream-muted);
            }
            h1 {
                margin: 0.75rem 0 0;
                font-size: clamp(2.25rem, 6vw, 3rem);
                font-weight: 500;
                line-height: 1.05;
                font-family: Georgia, 'Times New Roman', serif;
            }
            h1 span {
                font-style: italic;
                color: var(--gold);
            }
            p {
                margin: 1.25rem 0 0;
                color: var(--cream-muted);
                font-size: 0.95rem;
            }
            .actions {
                margin-top: 2rem;
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
            }
            a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.35rem;
                padding: 0.65rem 1.15rem;
                border-radius: 9999px;
                font-size: 0.875rem;
                text-decoration: none;
                border: 1px solid var(--border);
                color: var(--cream);
                transition: background 0.15s ease, border-color 0.15s ease;
            }
            a.primary {
                background: var(--gold);
                color: var(--bg);
                border-color: transparent;
                font-weight: 600;
            }
            a.primary:hover {
                filter: brightness(1.05);
            }
            a.secondary:hover {
                background: rgba(245, 240, 232, 0.06);
                border-color: rgba(245, 240, 232, 0.22);
            }
        </style>
    </head>
    <body>
        <div class="wrap">
            <div class="label">· Unavailable</div>
            <h1>We’ll be <span>right back</span></h1>
            <p>
                The site can’t be reached right now — often a brief network or server issue. Please try again in a
                moment.
            </p>
            <div class="actions">
                <a class="primary" href="{{ url('/') }}">Try again →</a>
                <a class="secondary" href="mailto:{{ config('kamali.email') }}">Email studio</a>
            </div>
        </div>
    </body>
</html>
