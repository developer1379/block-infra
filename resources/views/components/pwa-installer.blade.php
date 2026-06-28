<div id="pwa-install-banner" style="display: none;">
    <div class="pwa-banner-content">
        <button id="pwa-close-btn" class="pwa-close-button" aria-label="Close">&times;</button>
        <div class="pwa-banner-body">
            <div class="pwa-logo-container">
                <img src="/logo.png" alt="Bloc Infra Logo" class="pwa-app-logo">
            </div>
            <div class="pwa-text-container">
                <h4 class="pwa-app-title">Bloc Infra</h4>
                <p class="pwa-app-desc">Install our app for a faster, offline-ready experience on your device.</p>
            </div>
        </div>
        <div class="pwa-banner-actions">
            <!-- Android/Desktop Install Button -->
            <button id="pwa-install-btn" class="pwa-action-btn" style="display: none;">Install App</button>
            <!-- iOS Instructions -->
            <div id="pwa-ios-instructions" class="pwa-ios-instructions-text" style="display: none;">
                Tap <span class="pwa-ios-icon">⎋</span> (Share) then select <strong>"Add to Home Screen"</strong>
            </div>
        </div>
    </div>
</div>

<style>
/* PWA Banner Styles */
#pwa-install-banner {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    width: 90%;
    max-width: 450px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border-radius: 16px;
    z-index: 99999;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
    opacity: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    border: 1px solid rgba(15, 118, 110, 0.15);
    box-sizing: border-box;
}

#pwa-install-banner.pwa-banner-visible {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

.pwa-banner-content {
    position: relative;
    padding: 16px 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.pwa-close-button {
    position: absolute;
    top: 8px;
    right: 12px;
    background: transparent;
    border: none;
    font-size: 20px;
    color: #64748b;
    cursor: pointer;
    line-height: 1;
    padding: 4px;
    transition: color 0.2s;
}

.pwa-close-button:hover {
    color: #0f766e;
}

.pwa-banner-body {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-right: 16px; /* space for close button */
}

.pwa-logo-container {
    flex-shrink: 0;
}

.pwa-app-logo {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.pwa-text-container {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.pwa-app-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f766e;
    text-align: left;
}

.pwa-app-desc {
    margin: 0;
    font-size: 12px;
    color: #475569;
    line-height: 1.4;
    text-align: left;
}

.pwa-banner-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.pwa-action-btn {
    background: #0f766e;
    color: #ffffff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
}

.pwa-action-btn:hover {
    background: #0d9488;
}

.pwa-action-btn:active {
    transform: scale(0.97);
}

.pwa-ios-instructions-text {
    font-size: 13px;
    color: #1e293b;
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    padding: 8px 12px;
    border-radius: 8px;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
}

.pwa-ios-icon {
    display: inline-block;
    background: #e2e8f0;
    border-radius: 4px;
    padding: 0 6px;
    font-weight: bold;
    color: #007aff; /* Apple Blue */
}

@media (max-width: 480px) {
    #pwa-install-banner {
        bottom: 10px;
        width: calc(100% - 20px);
        border-radius: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Check if running in standalone mode (already installed)
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
    if (isStandalone) {
        return; // App is already installed, don't show the prompt
    }

    // 2. Detect Platform
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    const banner = document.getElementById('pwa-install-banner');
    const closeBtn = document.getElementById('pwa-close-btn');
    const installBtn = document.getElementById('pwa-install-btn');
    const iosInstructions = document.getElementById('pwa-ios-instructions');
    const navButtons = document.querySelectorAll('.pwa-install-nav-btn');

    let deferredPrompt = null;
    const bannerDismissed = localStorage.getItem('pwa_prompt_dismissed') === 'true';

    // Show banner helper
    function showBanner() {
        if (bannerDismissed) return; // Don't show automatic banner if dismissed
        banner.style.display = 'block';
        setTimeout(() => {
            banner.classList.add('pwa-banner-visible');
        }, 50);
    }

    // Dismiss banner helper
    function dismissBanner() {
        banner.classList.remove('pwa-banner-visible');
        setTimeout(() => {
            banner.style.display = 'none';
        }, 400);
        localStorage.setItem('pwa_prompt_dismissed', 'true');
    }

    // Show navbar buttons helper
    function showNavButtons() {
        navButtons.forEach(btn => {
            btn.style.setProperty('display', 'inline-flex', 'important');
        });
    }

    // Hide navbar buttons helper
    function hideNavButtons() {
        navButtons.forEach(btn => {
            btn.style.setProperty('display', 'none', 'important');
        });
    }

    closeBtn.addEventListener('click', dismissBanner);

    if (isIOS) {
        // Show navbar buttons on iOS Safari
        showNavButtons();

        // iOS Safari does not support beforeinstallprompt. Show iOS instructions banner directly on load (if not dismissed)
        setTimeout(() => {
            iosInstructions.style.display = 'block';
            showBanner();
        }, 3000);

        // Clicking navbar button shows iOS instructions banner
        navButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                iosInstructions.style.display = 'block';
                // Show banner even if dismissed previously
                banner.style.display = 'block';
                setTimeout(() => {
                    banner.classList.add('pwa-banner-visible');
                }, 50);
            });
        });
    } else {
        // Android / Desktop Chrome support beforeinstallprompt
        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome from automatically showing native banner
            e.preventDefault();
            // Stash the event
            deferredPrompt = e;
            
            // Show the install button in bottom banner
            installBtn.style.display = 'block';
            
            // Show navbar buttons
            showNavButtons();
            
            // Show our custom banner
            setTimeout(() => {
                showBanner();
            }, 2000);
        });

        // Trigger prompt helper
        function triggerInstallPrompt() {
            if (!deferredPrompt) return;
            // Trigger standard browser install prompt
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the PWA install prompt');
                    hideNavButtons();
                } else {
                    console.log('User dismissed the PWA install prompt');
                }
                deferredPrompt = null;
                dismissBanner();
            });
        }

        installBtn.addEventListener('click', triggerInstallPrompt);
        navButtons.forEach(btn => {
            btn.addEventListener('click', triggerInstallPrompt);
        });
    }

    window.addEventListener('appinstalled', () => {
        dismissBanner();
        hideNavButtons();
    });
});
</script>
