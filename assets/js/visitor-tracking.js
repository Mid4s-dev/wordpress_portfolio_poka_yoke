(function () {
    const config = window.portfolioVisitorTrackingData;
    if (!config || !config.ajaxUrl || !config.nonce) {
        return;
    }

    const startTime = Date.now();
    const sessionKey = 'portfolio_vt_sid';
    const sessionId = getSessionId();
    let maxScroll = 0;

    function getSessionId() {
        try {
            const existing = localStorage.getItem(sessionKey);
            if (existing) return existing;
            const id = crypto.randomUUID ? crypto.randomUUID() : String(Math.random()).slice(2);
            localStorage.setItem(sessionKey, id);
            return id;
        } catch (e) {
            return String(Math.random()).slice(2);
        }
    }

    function currentMeta() {
        return {
            page_url: window.location.href,
            referrer: document.referrer || '',
            page_title: document.title || '',
            session_id: sessionId,
            ts: Date.now(),
            user_agent: navigator.userAgent || '',
            screen_width: window.screen && window.screen.width ? window.screen.width : '',
            screen_height: window.screen && window.screen.height ? window.screen.height : '',
            viewport_width: window.innerWidth || '',
            viewport_height: window.innerHeight || '',
            language: navigator.language || '',
            timezone_offset: new Date().getTimezoneOffset(),
            scroll_depth: Math.round(maxScroll),
            time_on_page_ms: Date.now() - startTime,
        };
    }

    function sendEvent(eventType, extra = {}) {
        const payload = Object.assign({ event_type: eventType }, currentMeta(), extra);
        const body = new URLSearchParams({
            action: 'portfolio_track_event',
            nonce: config.nonce,
            event: JSON.stringify(payload),
        });

        fetch(config.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            },
            body,
            keepalive: true,
        }).catch(() => {
            // Silently ignore network errors to avoid blocking UX
        });
    }

    function handleScroll() {
        const scrolled = window.scrollY || window.pageYOffset || 0;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (docHeight <= 0) return;
        const percent = (scrolled / docHeight) * 100;
        if (percent > maxScroll) {
            maxScroll = percent;
        }
    }

    function handleVisibilityChange() {
        if (document.visibilityState === 'hidden') {
            sendEvent('page_leave');
        }
    }

    // Initial page view
    sendEvent('page_view');

    // Track scroll depth
    window.addEventListener('scroll', handleScroll, { passive: true });

    // Track when user leaves or hides page
    document.addEventListener('visibilitychange', handleVisibilityChange);
    window.addEventListener('beforeunload', function () {
        sendEvent('page_leave');
    });
})();
