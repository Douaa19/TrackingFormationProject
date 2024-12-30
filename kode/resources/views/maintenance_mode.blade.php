<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @if(@site_settings("same_site_name") ==  App\Enums\StatusEnum::true->status())
            {{@site_settings("site_name")}}
            @else
            {{@site_settings("user_site_name")}}
        @endif - {{$title}} 
    </title>

    <link rel="shortcut icon" href="{{ getImageUrl(getFilePaths()['site_logo']['path'].'/'.site_settings('site_favicon')) }}" >

    <style>
      * {
        padding: 0;
        margin: 0;
        outline: 0;
      }

      body {
        color: #000;
        font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica,
          Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
        overflow-x: hidden;
      }
      .maintenance {
        min-height: 100vh;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
      }

      .maintenance-wrapper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        align-items: center;
        width: 80%;
        margin: 90px 0;
      }

      .logo {
        width: 200px;
        margin-bottom: 25px;
        display: inline-block;
      }
      .logo img {
        width: 100%;
        height: auto;
      }

      .error-msg-container > h1 {
        font-size: 56px;
        margin-bottom: 40px;
      }
      .error-msg-container > p {
        font-size: 18px;
        margin-bottom: 20px;
      }
      .error-msg-container a {
        color: #654ce6;
        text-decoration: none;
      }
      .main-img {
        margin: 0 auto;
      }
      .main-img img {
        width: 100%;
        height: 100%;
      }
      @media screen and (max-width: 1199.98px) {
        .maintenance-wrapper {
          width: 90%;
        }
      }

      @media screen and (max-width: 991.98px) {
        .maintenance-wrapper {
          grid-template-columns: repeat(1, 1fr);
          gap: 50px;
        }
      }

      @media (max-width: 767.98px) and (min-width: 600px) {
        .error-msg-container > h1 {
          font-size: 42px;
        }
      }

      @media screen and (max-width: 599.98px) {
        .error-msg-container > h1 {
          font-size: 32px;
        }
      }
    </style>
  </head>
  <body>
    <div class="maintenance">
      <div class="maintenance-wrapper">
        <div class="error-msg-container">
          <a href="{{route('home')}}" class="logo">
            <img
              src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}"
              alt="{{site_settings('frontend_logo')}}"
            />
          </a>
          
          <h1>
              {{site_settings('maintenance_title')}}
          </h1>
          <p>
             {{site_settings('maintenance_description')}}
          </p>

        </div>

        <div class="main-img">
            <img src="{{asset('assets/images/maintenance.jpg')}}" alt="maintenance.jpg"/>
        </div>
      </div>
    </div>
  </body>
</html>
