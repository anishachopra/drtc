
window._wpemojiSettings = {
    "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/13.0.1\/72x72\/",
    "ext": ".png",
    "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/13.0.1\/svg\/",
    "svgExt": ".svg",
    "source": {
        "concatemoji": "https:\/\/springdemo.tech\/wp-includes\/js\/wp-emoji-release.min.js?ver=5.7.2"
    }
};
! function (e, a, t) {
    var n, r, o, i = a.createElement("canvas"),
        p = i.getContext && i.getContext("2d");

    function s(e, t) {
        var a = String.fromCharCode;
        p.clearRect(0, 0, i.width, i.height), p.fillText(a.apply(this, e), 0, 0);
        e = i.toDataURL();
        return p.clearRect(0, 0, i.width, i.height), p.fillText(a.apply(this, t), 0, 0), e === i.toDataURL()
    }

    function c(e) {
        var t = a.createElement("script");
        t.src = e, t.defer = t.type = "text/javascript", a.getElementsByTagName("head")[0].appendChild(t)
    }
    for (o = Array("flag", "emoji"), t.supports = {
        everything: !0,
        everythingExceptFlag: !0
    }, r = 0; r < o.length; r++) t.supports[o[r]] = function (e) {
        if (!p || !p.fillText) return !1;
        switch (p.textBaseline = "top", p.font = "600 32px Arial", e) {
            case "flag":
                return s([127987, 65039, 8205, 9895, 65039], [127987, 65039, 8203, 9895, 65039]) ? !1 : !s([55356,
                    56826, 55356, 56819
                ], [55356, 56826, 8203, 55356, 56819]) && !s([55356, 57332, 56128, 56423, 56128, 56418, 56128,
                    56421, 56128, 56430, 56128, 56423, 56128, 56447
                ], [55356, 57332, 8203, 56128, 56423, 8203, 56128, 56418, 8203, 56128, 56421, 8203, 56128,
                    56430, 8203, 56128, 56423, 8203, 56128, 56447
                ]);
            case "emoji":
                return !s([55357, 56424, 8205, 55356, 57212], [55357, 56424, 8203, 55356, 57212])
        }
        return !1
    }(o[r]), t.supports.everything = t.supports.everything && t.supports[o[r]], "flag" !== o[r] && (t.supports
        .everythingExceptFlag = t.supports.everythingExceptFlag && t.supports[o[r]]);
    t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && !t.supports.flag, t.DOMReady = !1, t
        .readyCallback = function () {
            t.DOMReady = !0
        }, t.supports.everything || (n = function () {
            t.readyCallback()
        }, a.addEventListener ? (a.addEventListener("DOMContentLoaded", n, !1), e.addEventListener("load", n, !
            1)) : (e.attachEvent("onload", n), a.attachEvent("onreadystatechange", function () {
                "complete" === a.readyState && t.readyCallback()
            })), (n = t.source || {}).concatemoji ? c(n.concatemoji) : n.wpemoji && n.twemoji && (c(n.twemoji), c(n
                .wpemoji)))
}(window, document, window._wpemojiSettings);

// 

var chaty_settings = {
    "object_settings": {
        "isPRO": 0,
        "pending_messages": "off",
        "cht_cta_bg_color": "#ffffff",
        "cht_cta_text_color": "#333333",
        "click_setting": "click",
        "number_of_messages": "1",
        "number_color": "#ffffff",
        "number_bg_color": "#dd0000",
        "position": "right",
        "social": [{
            "val": "02912633674",
            "default_icon": "<svg class=\"ico_d \" width=\"39\" height=\"39\" viewBox=\"0 0 39 39\" fill=\"none\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\" style=\"transform: rotate(0deg);\"><circle class=\"color-element\" cx=\"19.4395\" cy=\"19.4395\" r=\"19.4395\" fill=\"#03E78B\"\/><path d=\"M19.3929 14.9176C17.752 14.7684 16.2602 14.3209 14.7684 13.7242C14.0226 13.4259 13.1275 13.7242 12.8292 14.4701L11.7849 16.2602C8.65222 14.6193 6.11623 11.9341 4.47529 8.95057L6.41458 7.90634C7.16046 7.60799 7.45881 6.71293 7.16046 5.96705C6.56375 4.47529 6.11623 2.83435 5.96705 1.34259C5.96705 0.596704 5.22117 0 4.47529 0H0.745882C0.298353 0 5.69062e-07 0.298352 5.69062e-07 0.745881C5.69062e-07 3.72941 0.596704 6.71293 1.93929 9.3981C3.87858 13.575 7.30964 16.8569 11.3374 18.7962C14.0226 20.1388 17.0061 20.7355 19.9896 20.7355C20.4371 20.7355 20.7355 20.4371 20.7355 19.9896V16.4094C20.7355 15.5143 20.1388 14.9176 19.3929 14.9176Z\" transform=\"translate(9.07179 9.07178)\" fill=\"white\"\/><\/svg>",
            "bg_color": "#03E78B",
            "rbg_color": "3,231,139",
            "title": "Phone",
            "img_url": "",
            "social_channel": "phone",
            "channel_type": "phone",
            "href_url": "tel:02912633674",
            "desktop_target": "",
            "mobile_target": "",
            "qr_code_image": "",
            "channel": "Phone",
            "is_mobile": 1,
            "is_desktop": 1,
            "mobile_url": "tel:02912633674",
            "on_click": "",
            "has_font": 0,
            "popup_html": "",
            "has_custom_popup": 0,
            "is_default_open": 0
        }],
        "pos_side": "right",
        "bot": "25",
        "side": "25",
        "device": "desktop_active mobile_active",
        "color": "#A886CD",
        "rgb_color": "168,134,205",
        "widget_size": "54",
        "widget_type": "chat-base",
        "widget_img": "",
        "cta": "Contact us",
        "active": "true",
        "close_text": "Hide",
        "analytics": 0,
        "save_user_clicks": 0,
        "close_img": "",
        "is_mobile": 0,
        "ajax_url": "https:\/\/springdemo.tech\/wp-admin\/admin-ajax.php",
        "animation_class": "jump",
        "time_trigger": "yes",
        "trigger_time": "0",
        "exit_intent": "no",
        "on_page_scroll": "no",
        "page_scroll": "0",
        "gmt": "",
        "display_conditions": 0,
        "display_rules": [],
        "display_state": "click",
        "has_close_button": "yes",
        "mode": "vertical"
    },
    "ajax_url": "https:\/\/springdemo.tech\/wp-admin\/admin-ajax.php"
};

var wbkl10n = {
    "mode": "simple",
    "phonemask": "enabled",
    "phoneformat": "(999) 999-9999",
    "ajaxurl": "https:\/\/springdemo.tech\/wp-admin\/admin-ajax.php",
    "selectdatestart": "Book an appointment on or after",
    "selectdatestartbasic": "Book an appointment on",
    "selecttime": "Available time slots",
    "selectdate": "date",
    "thanksforbooking": "<p>Thanks for booking appointment<\/p>",
    "january": "January",
    "february": "February",
    "march": "March",
    "april": "April",
    "may": "May",
    "june": "June",
    "july": "July",
    "august": "August",
    "september": "September",
    "october": "October",
    "november": "November",
    "december": "December",
    "jan": "Jan",
    "feb": "Feb",
    "mar": "Mar",
    "apr": "Apr",
    "mays": "May",
    "jun": "Jun",
    "jul": "Jul",
    "aug": "Aug",
    "sep": "Sep",
    "oct": "Oct",
    "nov": "Nov",
    "dec": "Dec",
    "sunday": "Sunday",
    "monday": "Monday",
    "tuesday": "Tuesday",
    "wednesday": "Wednesday",
    "thursday": "Thursday",
    "friday": "Friday",
    "saturday": "Saturday",
    "sun": "Sun",
    "mon": "Mon",
    "tue": "Tue",
    "wed": "Wed",
    "thu": "Thu",
    "fri": "Fri",
    "sat": "Sat",
    "today": "Today",
    "clear": "Clear",
    "close": "Close",
    "startofweek": "",
    "nextmonth": "Next month",
    "prevmonth": "Previous  month",
    "hide_form": "disabled",
    "booked_text": "Booked",
    "show_booked": "disabled",
    "multi_booking": "disabled",
    "checkout": "Checkout",
    "multi_limit": "",
    "multi_limit_default": "",
    "phone_required": "3",
    "show_desc": "disabled",
    "date_input": "classic",
    "allow_attachment": "no",
    "stripe_public_key": "",
    "override_stripe_error": "no",
    "stripe_card_error_message": "incorrect input",
    "something_wrong": "Something went wrong, please try again.",
    "time_slot_booked": "Time slot(s) already booked.",
    "pp_redirect": "disabled",
    "show_prev_booking": "disabled",
    "scroll_container": "html, body",
    "continious_appointments": "",
    "show_suitable_hours": "no",
    "stripe_redirect_url": "",
    "stripe_mob_size": "",
    "auto_add_to_cart": "disabled",
    "range_selection": "disabled",
    "picker_format": "mmmm d, yyyy",
    "scroll_value": "120",
    "field_required": "",
    "error_status_scroll_value": "0",
    "limit_per_email_message": "You have reached your booking limit.",
    "stripe_hide_postal": "false",
    "jquery_no_conflict": "disabled"
};