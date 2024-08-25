(function ($) {
    function getDimensions(container, maxWidth = 0) {
        const screenWidth = $(container).width() > 1320 ? 1320 : $(container).width();
        const screenHeight = $(container).height() > window.innerHeight ? window.innerHeight : $(container).height();
        // const aspectRatio = 4 / 3;
        // const aspectRatio = 476 / 267.75;
        const aspectRatio = 16 / 9;
        let width = screenWidth;
        let height = (width / aspectRatio);
        if (height > screenHeight) {
            height = screenHeight - 80;
            width = (height * aspectRatio);
        }
        return { width, height };
    }

    Fancybox.bind("[data-fancybox='x-video-plyr']", {
        groupAll: false,
        groupAttr: false,
        on: {
            'destroy': (event, fancybox, slide) => {
                window.player.destroy();
            },
            'done': (fancybox, slide) => {
                const playerElement = $(fancybox.$container).find('.plyr__video-embed');
                const dimensions = getDimensions($(fancybox.$container).find('.fancybox__slide'));
                $(fancybox.$container).addClass('x-video-fancybox-container');
                $(fancybox.$container).find('.fancybox__content').css('width', `${dimensions.width}px`);
                $(fancybox.$container).find('.fancybox__content').css('height', `${dimensions.height}px`);
                loadAssets().then(() => {
                    setupFancyBoxPlayer(fancybox, playerElement);
                });

                $(window).on('resize', () => {
                    console.log('fancybox.$container', fancybox.$container)
                    if (fancybox.$container) {
                        const dimensions = getDimensions($(fancybox.$container).find('.fancybox__slide'));
                        $(fancybox.$container).find('.fancybox__content').css('width', `${dimensions.width}px`);
                        $(fancybox.$container).find('.fancybox__content').css('height', `${dimensions.height}px`);
                    }
                });
            },
        },
    });

    function setupFancyBoxPlayer(fancybox, playerElement) {
        window.player = new Plyr(playerElement, {
            autoplay: true,
            hideControls: false,
            resetOnEnd: false,
            settings: ['captions', 'quality', 'speed', 'loop'],
            controls: ['play-large', 'play', 'quality', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'fullscreen'],
            youtube: {
                rel: 0
            }
        });
        window.player.on('ready', event => {
            if (fancybox.$container) {
                window.player.play();
            } else {
                window.player.destroy();
            }
        });
    }
    function loadAssets() {
        return Promise.all([loadPlyScript(), loadStyleSheet()]);
    }
    function loadPlyScript() {
        return new Promise((resolve, reject) => {
            const scriptUrl = window.x_theme_script_vars.plyr_script_url;
            if ($('script[src="' + scriptUrl + '"]').length) {
                resolve();
            } else {
                try {
                    const scriptEle = document.createElement("script");
                    scriptEle.async = true;
                    scriptEle.src = scriptUrl;
                    scriptEle.id = 'plyr-script';
                    scriptEle.addEventListener("load", (ev) => {
                        resolve({ status: true });
                    });
                    scriptEle.addEventListener("error", (ev) => {
                        reject({
                            status: false,
                            message: `Failed to load the script ＄{scriptUrl}`
                        });
                    });
                    document.body.appendChild(scriptEle);
                } catch (error) {
                    reject(error);
                }
            }
        });
    }
    function loadStyleSheet() {
        return new Promise((resolve, reject) => {
            const styleUrl = window.x_theme_script_vars.plyr_style_url; 
            if ($('link[href="' + styleUrl + '"]').length) {
                resolve();
            } else {
                try {
                    const linkEle = document.createElement("link");
                    linkEle.rel = "stylesheet";
                    linkEle.href = styleUrl;
                    linkEle.id = 'plyr-style';
                    linkEle.addEventListener("load", (ev) => {
                        resolve({ status: true });
                    });
                    linkEle.addEventListener("error", (ev) => {
                        reject({
                            status: false,
                            message: `Failed to load the stylesheet ${styleUrl}`
                        });
                    });
                    document.head.appendChild(linkEle);
                } catch (error) {
                    reject(error);
                }
            }
        });
    }
})(jQuery);