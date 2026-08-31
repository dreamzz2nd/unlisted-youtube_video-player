/**
 * EduSecure - Protected Video Player System
 * Core Logic: Plyr.js Masking, Click Interceptor, Dynamic Monospace Watermark & Anti-Inspect Guard
 */

document.addEventListener('DOMContentLoaded', () => {
    initProtectedPlayer();
    initDynamicWatermark();
    initSecurityInterceptors();
});

let playerInstance = null;

/**
 * 1. Inisialisasi Plyr Player dengan Masking & Tema Bersih
 */
function initProtectedPlayer() {
    const playerElement = document.getElementById('player');
    if (!playerElement) return;

    playerInstance = new Plyr(playerElement, {
        controls: [
            'play-large',
            'play',
            'progress',
            'current-time',
            'duration',
            'mute',
            'volume',
            'settings',
            'fullscreen'
        ],
        settings: ['speed', 'quality'],
        speed: { selected: 1, options: [0.75, 1, 1.25, 1.5, 2] },
        tooltips: { controls: true, seek: true },
        keyboard: { focused: true, global: false },
        youtube: {
            noCookie: true,
            rel: 0,
            showinfo: 0,
            iv_load_policy: 3,
            modestbranding: 1,
            controls: 0,
            disablekb: 1,
            playsinline: 1
        }
    });

    // Pasang Click Interceptor pada Shield Overlay (Play/Pause dan Fullscreen toggle)
    const shield = document.getElementById('playerShield');
    if (shield) {
        shield.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (playerInstance) {
                playerInstance.togglePlay();
            }
        });

        shield.addEventListener('dblclick', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (playerInstance) {
                playerInstance.fullscreen.toggle();
            }
        });
    }

    playerInstance.on('ready', () => {
        console.log('🛡️ Protected Player Ready: YouTube iframe successfully masked.');
    });

    playerInstance.on('play', () => {
        startWatermarkAnimation();
    });
}

/**
 * 2. Dynamic Floating Monospace Watermark (Anti Screen Recording)
 */
let watermarkTimer = null;

function initDynamicWatermark() {
    startWatermarkAnimation();
}

function startWatermarkAnimation() {
    if (watermarkTimer) clearInterval(watermarkTimer);

    const watermark = document.getElementById('dynamicWatermark');
    if (!watermark) return;

    moveWatermarkRandomly(watermark);

    // Geser setiap 10 detik ke posisi acak baru
    watermarkTimer = setInterval(() => {
        moveWatermarkRandomly(watermark);
    }, 10000);
}

function moveWatermarkRandomly(element) {
    const minTop = 15;
    const maxTop = 70;
    const minLeft = 8;
    const maxLeft = 60;

    const randomTop = Math.floor(Math.random() * (maxTop - minTop + 1)) + minTop;
    const randomLeft = Math.floor(Math.random() * (maxLeft - minLeft + 1)) + minLeft;

    element.style.top = `${randomTop}%`;
    element.style.left = `${randomLeft}%`;
}

/**
 * 3. Security & Anti-Inspect Interceptors
 */
function initSecurityInterceptors() {
    const videoContainer = document.getElementById('videoSecurityContainer');
    
    if (videoContainer) {
        // Blokir Klik Kanan pada area video
        videoContainer.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            e.stopPropagation();
            showSecurityToast('Fitur klik kanan dinonaktifkan untuk melindungi hak cipta video.');
            return false;
        });
    }

    // Blokir Tombol Pintas Developer Tools & View Source
    window.addEventListener('keydown', (e) => {
        // F12
        if (e.key === 'F12' || e.keyCode === 123) {
            e.preventDefault();
            showSecurityToast('Akses Developer Tools diblokir.');
            return false;
        }

        // Ctrl + Shift + I / J / C (DevTools)
        if (e.ctrlKey && e.shiftKey && ['I', 'i', 'J', 'j', 'C', 'c'].includes(e.key)) {
            e.preventDefault();
            showSecurityToast('Akses Inspect Element diblokir.');
            return false;
        }

        // Ctrl + U (View Source)
        if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
            e.preventDefault();
            showSecurityToast('Melihat source code diblokir.');
            return false;
        }

        // Ctrl + S (Save Page)
        if (e.ctrlKey && (e.key === 's' || e.key === 'S')) {
            e.preventDefault();
            showSecurityToast('Menyimpan halaman web diblokir.');
            return false;
        }
    });
}

/**
 * Flash Alert / Security Toast
 */
let toastTimeout = null;
function showSecurityToast(message) {
    const toast = document.getElementById('securityNotice');
    if (!toast) return;

    if (message) {
        const textSpan = toast.querySelector('span');
        if (textSpan) textSpan.textContent = message;
    }

    toast.classList.remove('hidden');

    if (toastTimeout) clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        toast.classList.add('hidden');
    }, 4000);
}

/**
 * Tab Navigation (GitHub UnderlineNav)
 */
window.switchTab = function(event, tabId) {
    if (event) event.preventDefault();
    document.querySelectorAll('.underline-nav-item, .tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
    const targetPane = document.getElementById(tabId);
    if (targetPane) {
        targetPane.classList.add('active');
    }
};
