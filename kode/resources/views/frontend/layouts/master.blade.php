<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            @if(@site_settings("same_site_name") ==  App\Enums\StatusEnum::true->status())
                  {{@site_settings("site_name")}}
                @else
                  {{@site_settings("user_site_name")}}
            @endif - {{@$title?translate($title):"Error"}}</title>

        <meta name="csrf-token" content="{{csrf_token()}}" />

        <link rel="shortcut icon" href="{{ getImageUrl(getFilePaths()['site_logo']['path'].'/'.site_settings('site_favicon')) }}" >

        <link href="{{asset('assets/frontend/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/frontend/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/css/operating-hour.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/frontend/css/media.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />

        <style>
            .inner-banner{
                background-image: url('{{asset("/assets/images/frontend/inner-banner-shape.png")}}');
                background-size: cover;
                width: 100%;
                background-repeat: no-repeat;
                background-position: center center;
            }

            .banner{
                width: 100%;
            }

            .banner::after{
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                background-image: url('{{asset("/assets/images/frontend/banner-bg.jpg")}}');
                background-size: cover;
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-position: center center;
                z-index: -1;
                opacity: 0.029;
                border: none;

            }


            footer::after {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                background-image: url('{{asset("/assets/images/frontend/banner-bg.jpg")}}');;
                background-size: cover;
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-position: center center;
                z-index: -1;
                opacity: 0.029;
                border: none;
            }


        </style>

        @include('frontend.partials.theme')

        @stack('style-include')
        @stack('styles')



    </head>

    <body>

        @if(!request()->routeIs('dos.security'))
            <span class="line-1"></span>
            <span class="line-2"></span>
            <span class="line-3"></span>
            <span class="line-4"></span>

            @include('frontend.partials.header')
        @endif

            <main>
                @yield('content')
            </main>



        @if(!request()->routeIs('dos.security'))
            @include('frontend.partials.footer')


            @if(site_settings("cookie") == App\Enums\StatusEnum::true->status() && request()->routeIs("home"))
              @include('cookie-consent::index')
            @endif
        @endif

        <script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
        <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/global/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
        <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
        <script src="{{asset('assets/frontend/js/script.js')}}"></script>
        <script src="{{asset('assets/global/js/helper.js')}}"></script>

        @include('partials.notify')
        @stack('script-include')
        @stack('script-push')


        <script>
           "use strict";

            $(document).on('keyup','#home-search',function(e){
               $('.live-search').addClass("d-none")

                $.ajax({
                    url: "{{route('article.search')}}",
                    type: "post",
                    data:{
                        "search" : $(this).val(),
                        "_token":"{{csrf_token()}}",
                    },
                    dataType:'json',
                    success:(function (response) {

                         if(response.status){
                            $('.live-search').removeClass("d-none")
                            $('.live-search').html(response.article_html)
                         }
                    }),
                    error:(function (error) {

                    })
                })

                e.preventDefault()
            })

            $(document).on('keyup', '#inner-search', function (e) {
                $('.search-wrapper').removeClass("show-history")

                $.ajax({
                    url: "{{route('article.search')}}",
                    type: "post",
                    data: {
                        "search": $(this).val(),
                        "_token": "{{csrf_token()}}",
                    },
                    dataType: 'json',
                    success: (function (response) {
                        if (response.status) {
                            $('.search-wrapper').addClass("show-history")
                            $('.live-search').html(response.article_html)
                        }
                    }),
                    error: (function (error) {

                    })
                })

                e.preventDefault()
            })


            $(document).on('click', '.note-btn.dropdown-toggle', function (e) {

                var $clickedDropdown = $(this).next();
                $('.note-dropdown-menu.show').not($clickedDropdown).removeClass('show');
                $clickedDropdown.toggleClass('show');
                e.stopPropagation();

            });



            $(document).on('click', function(e) {
                if (!$(e.target).closest('.note-btn.dropdown-toggle').length) {
                    $(".note-dropdown-menu").removeClass("show");
                }
            });


           //file upload and preview

            var uploadedFiles = []; //
            $(".upload-filed input").on("change", function() {
                var fileInput = this;
                uploadedFiles = convertFileListToArray(uploadedFiles) ;
                var preview = $(".file-list");

                function handleFileUpload(file) {
                    var reader = new FileReader();
                    uploadedFiles.push(file);

                    reader.onload = function(e) {

                        preview.append(`<li><span class="remove-list pointer"><i data-name="${file.name}" class="remove-file bi bi-x-circle"></i></span> <p>${file.name}</p> </li>`);

                    };

                    reader.readAsDataURL(file);

                }

                $(this.files).each(function(i, file) {
                    handleFileUpload(file);
                });


                uploadedFiles = createFileList(uploadedFiles);
                fileInput.files = uploadedFiles;

                preview.on("click", ".remove-file", function() {

                    var fileName = $(this).data("name");
                    $(this).parent().parent().remove();

                    var selectedFiles = Array.from(uploadedFiles);

                    selectedFiles = selectedFiles.filter(function(file) {

                        return file.name != fileName;

                    });



                    var newFileList = new DataTransfer();
                    selectedFiles.forEach(function(file) {
                        newFileList.items.add(file);
                    });

                    uploadedFiles   = newFileList.files
                    fileInput.files = newFileList.files;

                });
            });


          function createFileList(blobs) {
              const dataTransfer = new DataTransfer();
              blobs.forEach(blob => {
                  const file = new File([blob], blob.name);
                  dataTransfer.items.add(file);
              });
              return dataTransfer.files;
          }


          function convertFileListToArray(fileList) {

              var filesArray = [];
              for (var i = 0; i < fileList.length; i++) {
                  filesArray.push(fileList[i]);
              }
              return filesArray;
          }

        </script>

    </body>

</html>
