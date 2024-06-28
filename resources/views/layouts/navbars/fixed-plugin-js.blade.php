
<script>
    $(document).ready(function () {
        $('#facebook').sharrre({
            share: {
                facebook: true
            },
            enableHover: false,
            enableTracking: false,
            enableCounter: false,
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('facebook');
            },
            template: '<i class="fab fa-facebook-f"></i> Facebook',
            url: ''
        });
        $('#google').sharrre({
            share: {
                googlePlus: true
            },
            enableCounter: false,
            enableHover: false,
            enableTracking: true,
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('googlePlus');
            },
            template: '<i class="fab fa-google-plus"></i> Google',
            url: ''
        });
        $('#twitter').sharrre({
            share: {
                twitter: true
            },
            enableHover: false,
            enableTracking: false,
            enableCounter: false,
            buttons: {
                twitter: {
                    via: 'CreativeTim'
                }
            },
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('twitter');
            },
            template: '<i class="fab fa-twitter"></i> Twitter',
            url: ''
        });
        // Facebook Pixel Code Don't Delete
        ! function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', '//connect.facebook.net/en_US/fbevents.js');
        try {
            fbq('init', '111649226022273');
            fbq('track', "PageView");
        } catch (err) {
            console.log('Facebook Track Error:', err);
        }
    });
</script>
<script>
   $(document).ready(function() {
    // Elementos de la interfaz de usuario
    $sidebar = $('.sidebar');
    $sidebar_img_container = $sidebar.find('.sidebar-background');
    $full_page = $('.full-page');
    $sidebar_responsive = $('body > .navbar-collapse');
    $full_page_background = $('.full-page-background');

    // Cargar configuraciones guardadas
    if (localStorage.getItem('activeColor')) {
        var activeColor = localStorage.getItem('activeColor');
        $sidebar.attr('data-active-color', activeColor);
        $full_page.attr('data-active-color', activeColor);
        $sidebar_responsive.attr('data-active-color', activeColor);
        $('.fixed-plugin .active-color span[data-color="' + activeColor + '"]').addClass('active');
    }
    if (localStorage.getItem('backgroundColor')) {
        var backgroundColor = localStorage.getItem('backgroundColor');
        $sidebar.attr('data-color', backgroundColor);
        $full_page.attr('filter-color', backgroundColor);
        $sidebar_responsive.attr('data-color', backgroundColor);
        $('.fixed-plugin .background-color span[data-color="' + backgroundColor + '"]').addClass('active');
    }
    if (localStorage.getItem('backgroundImage')) {
        var backgroundImage = localStorage.getItem('backgroundImage');
        $sidebar_img_container.css('background-image', 'url("' + backgroundImage + '")');
        $full_page_background.css('background-image', 'url("' + backgroundImage + '")');
        $('.fixed-plugin .img-holder img[src="' + backgroundImage + '"]').parent('li').addClass('active');
    }

    // Eventos para cambiar colores y fondo
    $('.fixed-plugin .active-color span').click(function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        var new_color = $(this).data('color');
        $sidebar.attr('data-active-color', new_color);
        $full_page.attr('data-active-color', new_color);
        $sidebar_responsive.attr('data-active-color', new_color);
        localStorage.setItem('activeColor', new_color);
    });

    $('.fixed-plugin .background-color span').click(function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        var new_color = $(this).data('color');
        $sidebar.attr('data-color', new_color);
        $full_page.attr('filter-color', new_color);
        $sidebar_responsive.attr('data-color', new_color);
        localStorage.setItem('backgroundColor', new_color);
    });

    $('.fixed-plugin .img-holder').click(function() {
        $(this).parent('li').siblings().removeClass('active');
        $(this).parent('li').addClass('active');
        var new_image = $(this).find("img").attr('src');
        $sidebar_img_container.fadeOut('fast', function() {
            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $sidebar_img_container.fadeIn('fast');
        });
        $full_page_background.fadeOut('fast', function() {
            $full_page_background.css('background-image', 'url("' + new_image + '")');
            $full_page_background.fadeIn('fast');
        });
        localStorage.setItem('backgroundImage', new_image);
    });
        $('.switch-sidebar-image input').on("switchChange.bootstrapSwitch", function () {
            $full_page_background = $('.full-page-background');
            $input = $(this);
            if ($input.is(':checked')) {
                if ($sidebar_img_container.length != 0) {
                    $sidebar_img_container.fadeIn('fast');
                    $sidebar.attr('data-image', '#');
                }
                if ($full_page_background.length != 0) {
                    $full_page_background.fadeIn('fast');
                    $full_page.attr('data-image', '#');
                }
                background_image = true;
            } else {
                if ($sidebar_img_container.length != 0) {
                    $sidebar.removeAttr('data-image');
                    $sidebar_img_container.fadeOut('fast');
                }
                if ($full_page_background.length != 0) {
                    $full_page.removeAttr('data-image', '#');
                    $full_page_background.fadeOut('fast');
                }
                background_image = false;
            }
        });
        $('.switch-mini input').on("switchChange.bootstrapSwitch", function () {
            $body = $('body');
            $input = $(this);
            if (paperDashboard.misc.sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                paperDashboard.misc.sidebar_mini_active = false;
                $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
            } else {
                $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
                setTimeout(function () {
                    $('body').addClass('sidebar-mini');
                    paperDashboard.misc.sidebar_mini_active = true;
                }, 300);
            }
            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function () {
                window.dispatchEvent(new Event('resize'));
            }, 180);
            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function () {
                clearInterval(simulateWindowResize);
            }, 1000);
        });
    });
</script>
