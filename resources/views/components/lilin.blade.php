@once
    <style>
        .lilin-loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(25, 33, 54, 0.45);
            pointer-events: auto;
        }

        .lilin-loading-overlay.is-visible {
            display: flex;
        }

        .lilin-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            min-width: 80px;
            background: transparent;
            padding: 0;
            box-shadow: none;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .lilin-glow-bg {
            position: absolute;
            width: 58px;
            height: 58px;
            background: radial-gradient(circle, rgba(255, 215, 70, .5) 0%, rgba(255, 180, 30, .15) 40%, transparent 70%);
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 50%;
            pointer-events: none;
            animation: lilinGlowPulse 1.4s ease-in-out infinite alternate;
        }

        @keyframes lilinGlowPulse {
            from {
                opacity: .7;
                transform: translateX(-50%) scale(1);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) scale(1.15);
            }
        }

        .lilin-stage {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            position: relative;
            z-index: 2;
            margin-bottom: 0;
            transform: scale(.72);
            transform-origin: center bottom;
        }

        .lilin-candle {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .lilin-loading-overlay.is-visible .lilin-candle {
            animation: lilinCandleRise .58s cubic-bezier(.2, .8, .2, 1) both;
        }

        .lilin-loading-overlay.is-visible .lilin-left {
            animation-delay: .04s;
        }

        .lilin-loading-overlay.is-visible .lilin-center {
            animation-delay: .18s;
        }

        .lilin-loading-overlay.is-visible .lilin-right {
            animation-delay: .32s;
        }

        @keyframes lilinCandleRise {
            from {
                opacity: 0;
                transform: translateY(26px) scale(.82);
            }

            70% {
                opacity: 1;
                transform: translateY(-4px) scale(1.03);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .lilin-body {
            background: #1a3fc4;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
            box-shadow: inset -3px 0 0 rgba(0, 0, 0, .15), inset 3px 0 0 rgba(255, 255, 255, .06);
        }

        .lilin-body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(90deg,
                    transparent 0px, transparent 4px,
                    rgba(255, 255, 255, .18) 4px, rgba(255, 255, 255, .18) 5px,
                    transparent 5px, transparent 9px);
            border-radius: 5px;
        }

        .lilin-wax {
            position: absolute;
            left: -2px;
            right: -2px;
            background: white;
            border-radius: 7px 7px 3px 3px;
            box-shadow: 0 2px 6px rgba(100, 130, 230, .18);
            z-index: 2;
        }

        .lilin-wax::before,
        .lilin-wax::after {
            content: "";
            position: absolute;
            background: white;
            border-radius: 50%;
            bottom: -3px;
        }

        .lilin-wax::before {
            width: 6px;
            height: 9px;
            left: 3px;
        }

        .lilin-wax::after {
            width: 5px;
            height: 7px;
            right: 3px;
            bottom: -2px;
        }

        .lilin-wick {
            width: 2px;
            background: #9a7220;
            border-radius: 1px;
            position: absolute;
            z-index: 3;
        }

        .lilin-shadow {
            width: 85%;
            height: 6px;
            background: radial-gradient(ellipse, rgba(30, 60, 200, .16) 0%, transparent 70%);
            margin-top: 2px;
            border-radius: 50%;
        }

        .lilin-left .lilin-body {
            width: 18px;
            height: 37px;
        }

        .lilin-left .lilin-wax {
            top: -1px;
            height: 10px;
        }

        .lilin-left .lilin-wick {
            height: 3px;
            bottom: 46px;
        }

        .lilin-center .lilin-body {
            width: 22px;
            height: 61px;
        }

        .lilin-center .lilin-wax {
            top: -1px;
            height: 12px;
        }

        .lilin-center .lilin-wick {
            height: 4px;
            bottom: 73px;
        }

        .lilin-center .lilin-flame-wrap {
            bottom: 77px;
        }

        .lilin-right .lilin-body {
            width: 18px;
            height: 48px;
        }

        .lilin-right .lilin-wax {
            top: -1px;
            height: 10px;
        }

        .lilin-right .lilin-wick {
            height: 3px;
            bottom: 57px;
        }

        .lilin-flame-wrap {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lilin-rays {
            position: absolute;
            width: 33px;
            height: 33px;
            top: -5px;
            left: 50%;
            transform: translateX(-50%);
            animation: lilinRaysSpin 5s linear infinite;
            pointer-events: none;
        }

        .lilin-ray {
            position: absolute;
            width: 2px;
            border-radius: 1px;
            background: linear-gradient(to top, #ffe060, transparent);
            left: calc(50% - 1px);
            bottom: 50%;
            transform-origin: bottom center;
        }

        @keyframes lilinRaysSpin {
            from {
                transform: translateX(-50%) rotate(0deg);
            }

            to {
                transform: translateX(-50%) rotate(360deg);
            }
        }

        .lilin-flame-halo {
            position: absolute;
            width: 42px;
            height: 42px;
            background: radial-gradient(circle, rgba(255, 220, 50, .45) 0%, transparent 65%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -40%);
            animation: lilinGlowPulse 1s ease-in-out infinite alternate;
            pointer-events: none;
            z-index: -1;
        }

        .lilin-flame-outer {
            width: 16px;
            height: 26px;
            background: #e0200a;
            border-radius: 50% 50% 30% 30% / 55% 55% 45% 45%;
            clip-path: polygon(50% 0%, 72% 22%, 92% 55%, 82% 85%, 50% 100%, 18% 85%, 8% 55%, 28% 22%);
            position: relative;
            animation: lilinFlicker .85s ease-in-out infinite;
            transform-origin: bottom center;
        }

        .lilin-flame-mid {
            position: absolute;
            width: 10px;
            height: 17px;
            background: #ff6200;
            border-radius: 50% 50% 30% 30% / 55% 55% 45% 45%;
            clip-path: polygon(50% 0%, 74% 24%, 90% 56%, 80% 84%, 50% 100%, 20% 84%, 10% 56%, 26% 24%);
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            animation: lilinFlicker .65s ease-in-out infinite .08s;
            transform-origin: bottom center;
        }

        .lilin-flame-core {
            position: absolute;
            width: 5px;
            height: 10px;
            background: #fff7a0;
            border-radius: 50% 50% 30% 30% / 55% 55% 45% 45%;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            animation: lilinFlicker .55s ease-in-out infinite .04s;
            transform-origin: bottom center;
        }

        @keyframes lilinFlicker {
            0% {
                transform: translateX(-50%) rotate(-2deg) scaleX(1) scaleY(1);
            }

            15% {
                transform: translateX(-50%) rotate(3deg) scaleX(.92) scaleY(1.07);
            }

            30% {
                transform: translateX(-50%) rotate(-4deg) scaleX(1.08) scaleY(.95);
            }

            50% {
                transform: translateX(-50%) rotate(2deg) scaleX(.95) scaleY(1.09);
            }

            70% {
                transform: translateX(-50%) rotate(-3deg) scaleX(1.06) scaleY(.93);
            }

            100% {
                transform: translateX(-50%) rotate(-2deg) scaleX(1) scaleY(1);
            }
        }

        .lilin-spark {
            position: absolute;
            width: 2px;
            height: 2px;
            border-radius: 50%;
            background: #ffe055;
            opacity: 0;
            animation: lilinSparkFly var(--dur) ease-out var(--delay) infinite;
        }

        @keyframes lilinSparkFly {
            0% {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translate(var(--tx), var(--ty)) scale(0);
            }
        }

        .lilin-title {
            display: none;
            color: #1a3fc4;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .02em;
            margin: 0 0 6px;
            position: relative;
            z-index: 2;
        }

        .lilin-dots {
            display: none;
            gap: 5px;
            position: relative;
            z-index: 2;
        }

        .lilin-dots span {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #b8c8f0;
            animation: lilinDotBounce 1.3s ease-in-out infinite;
        }

        .lilin-dots span:nth-child(2) {
            background: #1a3fc4;
            animation-delay: .2s;
        }

        .lilin-dots span:nth-child(3) {
            animation-delay: .4s;
        }

        @keyframes lilinDotBounce {
            0%,
            100% {
                opacity: .35;
                transform: translateY(0) scale(1);
            }

            50% {
                opacity: 1;
                transform: translateY(-5px) scale(1.15);
            }
        }
    </style>

    <script>
        window.showLilinLoading = function () {
            const overlay = document.getElementById('lilinLoadingOverlay');
            if (!overlay) return;

            overlay.classList.add('is-visible');
            overlay.setAttribute('aria-hidden', 'false');
            document.documentElement.style.cursor = 'progress';
        };

        window.hideLilinLoading = function () {
            const overlay = document.getElementById('lilinLoadingOverlay');
            if (!overlay) return;

            overlay.classList.remove('is-visible');
            overlay.setAttribute('aria-hidden', 'true');
            document.documentElement.style.cursor = '';
        };

        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('submit', function (event) {
                const form = event.target;

                if (!(form instanceof HTMLFormElement)) return;
                if (event.defaultPrevented) return;
                if (form.dataset.loadingIgnore === 'true') return;
                if (form.hasAttribute('target')) return;
                if (typeof form.checkValidity === 'function' && !form.checkValidity()) return;

                window.showLilinLoading();
            });

            document.addEventListener('click', function (event) {
                const link = event.target.closest('a[href]');
                if (!link || link.dataset.loadingIgnore === 'true') return;
                if (link.target && link.target !== '_self') return;
                if (link.hasAttribute('download')) return;

                const href = link.getAttribute('href') || '';
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;

                const url = new URL(link.href, window.location.href);
                if (url.origin !== window.location.origin) return;
                if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;

                window.showLilinLoading();
            });

            window.addEventListener('pageshow', window.hideLilinLoading);
            window.addEventListener('beforeunload', window.showLilinLoading);
        });
    </script>
@endonce

<div id="lilinLoadingOverlay" class="lilin-loading-overlay" aria-hidden="true" aria-live="polite">
    <div class="lilin-loader" role="status" aria-label="Memuat data">
        <div class="lilin-glow-bg"></div>
        <div class="lilin-stage">
            <div class="lilin-candle lilin-left">
                <div class="lilin-wick"></div>
                <div class="lilin-body"></div>
                <div class="lilin-wax"></div>
                <div class="lilin-shadow"></div>
            </div>

            <div class="lilin-candle lilin-center">
                <div class="lilin-flame-wrap">
                    <div class="lilin-rays">
                        <div class="lilin-ray" style="height:6px;transform:rotate(0deg) translateY(-17px)"></div>
                        <div class="lilin-ray" style="height:5px;transform:rotate(45deg) translateY(-15px)"></div>
                        <div class="lilin-ray" style="height:6px;transform:rotate(90deg) translateY(-17px)"></div>
                        <div class="lilin-ray" style="height:5px;transform:rotate(135deg) translateY(-15px)"></div>
                        <div class="lilin-ray" style="height:5px;transform:rotate(180deg) translateY(-15px)"></div>
                        <div class="lilin-ray" style="height:5px;transform:rotate(225deg) translateY(-15px)"></div>
                        <div class="lilin-ray" style="height:6px;transform:rotate(270deg) translateY(-17px)"></div>
                        <div class="lilin-ray" style="height:5px;transform:rotate(315deg) translateY(-15px)"></div>
                    </div>
                    <div class="lilin-spark" style="--dur:1.1s;--delay:.0s;--tx:-9px;--ty:-20px;bottom:28px;left:50%"></div>
                    <div class="lilin-spark" style="--dur:1.4s;--delay:.3s;--tx:8px;--ty:-24px;bottom:27px;left:50%"></div>
                    <div class="lilin-spark" style="--dur:1.0s;--delay:.7s;--tx:-3px;--ty:-26px;bottom:29px;left:50%"></div>
                    <div class="lilin-flame-halo"></div>
                    <div class="lilin-flame-outer">
                        <div class="lilin-flame-mid">
                            <div class="lilin-flame-core"></div>
                        </div>
                    </div>
                </div>
                <div class="lilin-wick"></div>
                <div class="lilin-body"></div>
                <div class="lilin-wax"></div>
                <div class="lilin-shadow"></div>
            </div>

            <div class="lilin-candle lilin-right">
                <div class="lilin-wick"></div>
                <div class="lilin-body"></div>
                <div class="lilin-wax"></div>
                <div class="lilin-shadow"></div>
            </div>
        </div>
        <h3 class="lilin-title">Memuat data...</h3>
        <div class="lilin-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
