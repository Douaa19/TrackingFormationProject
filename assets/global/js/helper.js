
   //toaster functions
    function toastr(text,className){
        Toastify({
            newWindow: !0,
            text: text,
            gravity: 'top',
            position: 'right',
            className: "bg-" + className,
            stopOnFocus: !0,
            offset: { x:  0, y: 0 },
            duration:3000,
            close: "close" == "close",

        }).showToast();
    }

  

     //EMPTY INPUT FIELD 
     function emptyInputFiled(id, selector = 'id', html = true) {
         var identifier = selector === 'id' ? `#${id}` : `.${id}`;
        $(identifier)[html ? 'html' : 'val']('');
      }


    //delete event start
    $(document).on('click',".delete-item",function(e){
        e.preventDefault();

        var href = $(this).attr('data-href');
        var modal  = $("#delete-modal");
        if($('#ticketModal').hasClass('show')){
            modal.css("z-index", "999999");
            $('.modal-backdrop').css("z-index", '9999');
        }

        $("#delete-href").attr("href", href);
        modal.modal("show");

    })
    $(document).on('click',".close-delete-modal",function(e){
        e.preventDefault();
        
        if($('#ticketModal').hasClass('show')){
            $('.modal-backdrop').css("z-index", '');
        }
    })

    //file upload preview
    $(document).on('change', '.preview', function (e) {
        emptyInputFiled('image-preview-section')
        var file = e.target.files[0];
        var size =  ($(this).attr('data-size')).split("x");
        imagePreview(file, 'image-preview-section',size);
        e.preventDefault();
    })





    $(document).on('click', '.copy-text ', function (e) {

         var data = $(this).attr('data-text')

    

         var  modal  = $(this).attr("data-modal")

         var tempInput = $('<input class="tmp-input">');

         var selector = modal ? ".modal-body" : "body"



         $(selector).append(tempInput);

         $('.tmp-input').val(data).select();
         document.execCommand('copy');
         $('.tmp-input').remove();

         toastr('Text/ Url Copied Successfully','success')
    })

    //SINGLE IMAGE PREVIEW METHOD
    function  imagePreview (file, id,size) {
        $(`#${id}`).append(
            `<img alt='${file.type}' class="mt-2 rounded  d-block"
             style="width:${size[0]}px;height:${size[1]}px;"
            src='${URL.createObjectURL(file)}'>`
        );
    }



    function send_browser_notification(heading , icon ,message,route){
    

        Push.create(`${heading}`, {
            body: message,
            icon: `${icon}`,
            timeout: 4000,
            onClick: function () {
                window.location.href = route
                this.close();
            }
        });
    }


         
    function checkebox_event(selector,sub_selector){

        length = $(`${selector}`).length
        checked_lenght = $(`${selector}:checked`).length;
        if(length == checked_lenght){
            $(`${sub_selector}`).prop('checked', true);
        }
        else{
            $(`${sub_selector}`).prop('checked', false);
        }

        return  length;
    }


    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            e = document.getElementById(e).getAttribute("data-colors");
            if (e)
                return (e = JSON.parse(e)).map(function (e) {
                    var t = e.replace(" ", "");
                    return -1 === t.indexOf(",")
                        ? getComputedStyle(document.documentElement).getPropertyValue(t) || t
                        : 2 == (e = e.split(",")).length
                            ? "rgba(" +
                            getComputedStyle(document.documentElement).getPropertyValue(e[0]) +
                            "," +
                            e[1] +
                            ")"
                            : t;
                });
        }
    }


     $(document).on('click',".arrow-button",function(e){
        e.preventDefault();
        var index = $(".arrow-button").index(this);
        $(".frontend-scrollbar").eq(index).slideToggle("slow");
      });

      $(document).on('click',".card-header h5",function(e){
        e.preventDefault();
        var index = $(".card-header h5").index(this);
        $(".frontend-scrollbar").eq(index - 1).slideToggle("slow");
      });



      /** bulk action js start */

        $(document).on('click','.check-all' ,function(e){
            if($(this).is(':checked')){
                $(`.data-checkbox`).prop('checked', true);
                $(`.bulk-action`).removeClass('d-none');
            }
            else{
                $(`.data-checkbox`).prop('checked', false);
                $(`.bulk-action`).addClass('d-none');
            }
        })

        $(document).on('click','.data-checkbox' ,function(e){
            var length = checkebox_event(".data-checkbox",'.check-all');
            if(length > 0){
                $(`.bulk-action`).removeClass('d-none');
            }
            else{
                $(`.bulk-action`).addClass('d-none');
            }
        })


        $(document).on('click','.bulkActionBtn' ,function(e){

           

            var type = $(this).attr("data-type")
            var value = $(this).val()

            const checkedIds = $('.data-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            $('#bulkid').val(JSON.stringify(checkedIds));
            $('#value').val(value);
            $('#type').val(type);

            $("#bulkActionForm").submit()

        });



        $(document).on('click','#deleteModal',function(e){
            var modal = $('#bulkDeleteModal')
            modal.modal('show')
        })

/** bulk action js end */


   


   