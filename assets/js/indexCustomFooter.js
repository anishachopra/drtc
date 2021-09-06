var astra = {
    "break_point": "921",
    "isRtl": ""
};
var option = {
    "mystickyClass": "header.site-header",
    "activationHeight": "0",
    "disableWidth": "0",
    "disableLargeWidth": "0",
    "adminBar": "false",
    "device_desktop": "1",
    "device_mobile": "1",
    "mystickyTransition": "fade",
    "mysticky_disable_down": "false"
};
var elementskit = {
    resturl: 'https://springdemo.tech/wp-json/elementskit/v1/',
}
var HappyLocalize = {
    "ajax_url": "https:\/\/springdemo.tech\/wp-admin\/admin-ajax.php",
    "nonce": "0f7aed3e69"
};
var PaModulesSettings = {
    "equalHeight_url": "https:\/\/springdemo.tech\/wp-content\/plugins\/premium-addons-for-elementor\/assets\/frontend\/min-js\/premium-eq-height.min.js"
};
var elementorFrontendConfig = {
    "environmentMode": {
        "edit": false,
        "wpPreview": false,
        "isScriptDebug": false
    },
    "i18n": {
        "shareOnFacebook": "Share on Facebook",
        "shareOnTwitter": "Share on Twitter",
        "pinIt": "Pin it",
        "download": "Download",
        "downloadImage": "Download image",
        "fullscreen": "Fullscreen",
        "zoom": "Zoom",
        "share": "Share",
        "playVideo": "Play Video",
        "previous": "Previous",
        "next": "Next",
        "close": "Close"
    },
    "is_rtl": false,
    "breakpoints": {
        "xs": 0,
        "sm": 480,
        "md": 768,
        "lg": 1025,
        "xl": 1440,
        "xxl": 1600
    },
    "responsive": {
        "breakpoints": {
            "mobile": {
                "label": "Mobile",
                "value": 767,
                "direction": "max",
                "is_enabled": true
            },
            "mobile_extra": {
                "label": "Mobile Extra",
                "value": 880,
                "direction": "max",
                "is_enabled": false
            },
            "tablet": {
                "label": "Tablet",
                "value": 1024,
                "direction": "max",
                "is_enabled": true
            },
            "tablet_extra": {
                "label": "Tablet Extra",
                "value": 1365,
                "direction": "max",
                "is_enabled": false
            },
            "laptop": {
                "label": "Laptop",
                "value": 1620,
                "direction": "max",
                "is_enabled": false
            },
            "widescreen": {
                "label": "Widescreen",
                "value": 2400,
                "direction": "min",
                "is_enabled": false
            }
        }
    },
    "version": "3.2.5",
    "is_static": false,
    "experimentalFeatures": {
        "e_dom_optimization": true,
        "a11y_improvements": true,
        "landing-pages": true
    },
    "urls": {
        "assets": "https:\/\/springdemo.tech\/wp-content\/plugins\/elementor\/assets\/"
    },
    "settings": {
        "page": [],
        "editorPreferences": []
    },
    "kit": {
        "active_breakpoints": ["viewport_mobile", "viewport_tablet"],
        "global_image_lightbox": "yes",
        "lightbox_enable_counter": "yes",
        "lightbox_enable_fullscreen": "yes",
        "lightbox_enable_zoom": "yes",
        "lightbox_enable_share": "yes",
        "lightbox_title_src": "title",
        "lightbox_description_src": "description"
    },
    "post": {
        "id": 1456,
        "title": "Duplicated%3A%20Home%20Page%20%E2%80%93%20%5B%237%5D",
        "excerpt": "",
        "featuredImage": false
    }
}; window.scopes_array = {};
window.backend = 0;
jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/section", function ($scope, $) {
        if ("undefined" == typeof $scope) {
            return;
        }
        if ($scope.hasClass("premium-equal-height-yes")) {
            var id = $scope.data("id");
            window.scopes_array[id] = $scope;
        }
        if (elementorFrontend.isEditMode()) {
            var url = PaModulesSettings.equalHeight_url;
            jQuery.cachedAssets = function (url, options) {
                // Allow user to set any option except for dataType, cache, and url.
                options = jQuery.extend(options || {}, {
                    dataType: "script",
                    cache: true,
                    url: url
                });
                // Return the jqXHR object so we can chain callbacks.
                return jQuery.ajax(options);
            };
            jQuery.cachedAssets(url);
            window.backend = 1;
        }
    });
});
jQuery(document).ready(function () {
    if (jQuery.find(".premium-equal-height-yes").length < 1) {
        return;
    }

    var url = PaModulesSettings.equalHeight_url;

    jQuery.cachedAssets = function (url, options) {
        // Allow user to set any option except for dataType, cache, and url.
        options = jQuery.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });

        // Return the jqXHR object so we can chain callbacks.
        return jQuery.ajax(options);
    };
    jQuery.cachedAssets(url);
});
var _wpUtilSettings = {
    "ajax": {
        "url": "\/wp-admin\/admin-ajax.php"
    }
};
var wpformsElementorVars = {
    "captcha_provider": "recaptcha",
    "recaptcha_type": "v2"
};
/(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window
    .addEventListener("hashchange", function () {
        var t, e = location.hash.substring(1);
        /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i
            .test(t.tagName) || (t.tabIndex = -1), t.focus())
    }, !1);
var wpforms_settings = {
    "val_required": "This field is required.",
    "val_email": "Please enter a valid email address.",
    "val_email_suggestion": "Did you mean {suggestion}?",
    "val_email_suggestion_title": "Click to accept this suggestion.",
    "val_email_restricted": "This email address is not allowed.",
    "val_number": "Please enter a valid number.",
    "val_number_positive": "Please enter a valid positive number.",
    "val_confirm": "Field values do not match.",
    "val_checklimit": "You have exceeded the number of allowed selections: {#}.",
    "val_limit_characters": "{count} of {limit} max characters.",
    "val_limit_words": "{count} of {limit} max words.",
    "val_recaptcha_fail_msg": "Google reCAPTCHA verification failed, please try again later.",
    "val_empty_blanks": "Please fill out all blanks.",
    "uuid_cookie": "",
    "locale": "en",
    "wpforms_plugin_url": "https:\/\/springdemo.tech\/wp-content\/plugins\/wpforms-lite\/",
    "gdpr": "",
    "ajaxurl": "https:\/\/springdemo.tech\/wp-admin\/admin-ajax.php",
    "mailcheck_enabled": "1",
    "mailcheck_domains": [],
    "mailcheck_toplevel_domains": ["dev"],
    "is_ssl": "1"
}