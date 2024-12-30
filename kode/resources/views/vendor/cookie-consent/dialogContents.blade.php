

<div class="js-cookie-consent cookie-consent  ">
    <h5>{{translate('Accept Our Cookie')}}</h5>
    <p>
        <span class="cookie-icon"><i class="fa-solid fa-cookie-bite"></i></span> {{
            site_settings("cookie_text")
        }}
    </p>
    
    <div class="cookies-action text-center">
        <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer accept-cookie Btn btn--sm secondary-btn">
            {{translate("Accept & Continue")}}
        </button>
    </div>
</div>
