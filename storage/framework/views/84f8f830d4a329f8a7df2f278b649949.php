<div x-data="{ open: false }" class="relative" @click.away="open = false">
    <button @click="open = !open" type="button"
        class="inline-flex items-center space-x-2 text-sm font-semibold text-gray-700 hover:text-cisa-accent transition-all focus:outline-none bg-white/50 px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm hover:shadow-md">
        <i class="fas fa-language text-lg text-cisa-base"></i>
        <span class="hidden sm:inline" id="current-lang-label">Select Language</span>
        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200"
            :class="{ 'rotate-180': open }"></i>
    </button>

    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-56 rounded-xl shadow-glass bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border border-gray-100"
        style="display: none;">

        <div class="px-4 py-3 bg-slate-50 border-b border-gray-100">
            <span class="text-xs font-bold uppercase tracking-wider text-cisa-muted">Translate Website</span>
        </div>

        <div class="py-1" id="google_translate_element_custom">
            <a href="javascript:void(0)" onclick="triggerTranslation('en')"
                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-cisa-base hover:text-white transition-colors flex items-center justify-between group">
                <div class="flex items-center space-x-3">
                    <span class="w-6 text-center text-xs opacity-60">EN</span>
                    <span>English</span>
                </div>
                <i class="fas fa-check text-cisa-accent opacity-0 group-hover:opacity-100 selection-check"
                    id="check-en"></i>
            </a>
            <a href="javascript:void(0)" onclick="triggerTranslation('fr')"
                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-cisa-base hover:text-white transition-colors flex items-center justify-between group">
                <div class="flex items-center space-x-3">
                    <span class="w-6 text-center text-xs opacity-60">FR</span>
                    <span>Français</span>
                </div>
                <i class="fas fa-check text-cisa-accent opacity-0 group-hover:opacity-100 selection-check"
                    id="check-fr"></i>
            </a>
            <a href="javascript:void(0)" onclick="triggerTranslation('es')"
                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-cisa-base hover:text-white transition-colors flex items-center justify-between group">
                <div class="flex items-center space-x-3">
                    <span class="w-6 text-center text-xs opacity-60">ES</span>
                    <span>Español</span>
                </div>
                <i class="fas fa-check text-cisa-accent opacity-0 group-hover:opacity-100 selection-check"
                    id="check-es"></i>
            </a>
            <a href="javascript:void(0)" onclick="triggerTranslation('pt')"
                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-cisa-base hover:text-white transition-colors flex items-center justify-between group">
                <div class="flex items-center space-x-3">
                    <span class="w-6 text-center text-xs opacity-60">PT</span>
                    <span>Português</span>
                </div>
                <i class="fas fa-check text-cisa-accent opacity-0 group-hover:opacity-100 selection-check"
                    id="check-pt"></i>
            </a>
            <a href="javascript:void(0)" onclick="triggerTranslation('sw')"
                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-cisa-base hover:text-white transition-colors flex items-center justify-between group">
                <div class="flex items-center space-x-3">
                    <span class="w-6 text-center text-xs opacity-60">SW</span>
                    <span>Kiswahili</span>
                </div>
                <i class="fas fa-check text-cisa-accent opacity-0 group-hover:opacity-100 selection-check"
                    id="check-sw"></i>
            </a>
        </div>
    </div>
</div>

<div id="google_translate_element" style="display:none"></div>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,fr,es,pt,sw',
            autoDisplay: false
        }, 'google_translate_element');
    }

    function triggerTranslation(langCode) {
        var select = document.querySelector('.goog-te-combo');
        if (select) {
            select.value = langCode;
            select.dispatchEvent(new Event('change'));

            // Update label
            var labels = {
                'en': 'English',
                'fr': 'Français',
                'es': 'Español',
                'pt': 'Português',
                'sw': 'Kiswahili'
            };
            document.getElementById('current-lang-label').innerText = labels[langCode] || 'Select Language';

            // Highlight selected
            document.querySelectorAll('.selection-check').forEach(el => el.classList.add('opacity-0'));
            const activeCheck = document.getElementById('check-' + langCode);
            if (activeCheck) activeCheck.classList.remove('opacity-0');
        }
    }

    // JS Fix to reset body position without breaking translation
    (function () {
        const resetPagePosition = () => {
            if (document.documentElement.style.top !== '0px' && document.documentElement.style.top !== '') {
                document.documentElement.style.top = '0px';
            }
            if (document.body.style.top !== '0px' && document.body.style.top !== '') {
                document.body.style.top = '0px';
            }
        };

        // Run checking less frequently to avoid constant DOM fights
        setInterval(resetPagePosition, 1000);

        const observer = new MutationObserver(resetPagePosition);
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['style'] });
    })();
</script>
<script type="text/javascript"
    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<style>
    /* Hide Google Translate Banner and Popups */
    .goog-te-banner-frame.skiptranslate,
    .goog-te-banner-frame,
    .goog-te-banner,
    .goog-te-gadget-icon,
    iframe.goog-te-banner-frame,
    #goog-gt-tt,
    .goog-te-balloon-frame,
    .skiptranslate {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        width: 0 !important;
        position: absolute !important;
        z-index: -1000 !important;
        pointer-events: none !important;
    }

    html {
        margin-top: 0 !important;
    }

    body {
        top: 0px !important;
        position: static !important;
    }

    /* Additional specific rule for the top banner container if it has a different class */
    body>.skiptranslate {
        display: none !important;
    }

    .goog-te-gadget {
        font-family: inherit !important;
        font-size: 0 !important;
        color: transparent !important;
    }

    .goog-te-gadget .goog-te-combo {
        display: none !important;
    }

    /* Hide Google Tooltip & Highlights */
    .goog-tooltip,
    .goog-tooltip:hover,
    .VIpgJd-y662s-p6n610-idS98e,
    .VIpgJd-y662s-p6n610 {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }

    .goog-text-highlight {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    /* Prevent offset caused by translation bar */
    iframe.goog-te-banner-frame {
        display: none !important;
    }
</style>

<script>
    // Force reset top style which Google adds
    if (window.Element && Element.prototype.attachShadow) {
        // If possible, might be inside shadow DOM, but usually it's in main DOM
    }

    const removeGoogleTopBar = () => {
        const banners = document.querySelectorAll('.goog-te-banner-frame');
        banners.forEach(banner => {
            banner.style.display = 'none';
            banner.style.visibility = 'hidden';
            banner.height = 0;
        });

        document.body.style.top = '0px';
        document.documentElement.style.top = '0px';
    };

    // Run heavily on load
    window.addEventListener('load', () => {
        removeGoogleTopBar();
        setInterval(removeGoogleTopBar, 500); // Check every 500ms
    });
</script><?php /**PATH /home/u857061584/domains/cisajournal.org/public_html/resources/views/partials/language_switcher.blade.php ENDPATH**/ ?>