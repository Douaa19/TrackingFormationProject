<script>
    (function($) {
        "use strict";



    var      page      = 1;
    var      modalPage = 1;


    loadMoreMessages(page)

    /** load more message event */
    $(document).on('click','.load-more',function(e){

        if($(this).hasClass('modal-message')){
            var modal = $('#ticketModal')
            var ticketId = $(this).attr('data-ticket');
            modalPage++;
            loadMoreMessages(modalPage,ticketId ,modal)
        }
        else{
            page++;
            loadMoreMessages(page);
        }

        e.preventDefault()
    })

    /** load more message ajax */

    function  loadMoreMessages(page ,ticketId = '{{$ticket->id}}', modal = '', html = false){

        formSubmitted = true;
        var loaderElement = modal != '' ? $('#ticketModal').find('#elmLoader') : $('#elmLoader');
        var loadMore      = modal != '' ? $('#ticketModal').find('.load-more-div') : $('.load-more-div');
        var replyItem     = modal != '' ? $('#ticketModal').find('.all-reply-item') : $('.all-reply-item');

        $.ajax({
            url: "{{route('admin.ticket.messages')}}",
            type: "get",
            data:{
                'page' : page,
                'id'   : ticketId,

            },
            dataType:'json',
            beforeSend: function () {
                loaderElement.removeClass('d-none');
            },
            success:(function (response) {

                loaderElement.addClass('d-none');
                if(response.status){

                    $('.reply-card').addClass('d-none')
                    if(html){
                        replyItem.html(response.messages_html)
                    }else{
                        replyItem.append(response.messages_html)
                    }

                    if(response.next_page){
                        loadMore.removeClass('d-none')
                    }else{
                        loadMore.addClass('d-none')
                    }

                    $('.image-v-preview').viewbox({
                                setTitle: true,
                                margin: 20,
                                resizeDuration: 300,
                                openDuration: 200,
                                closeDuration: 200,
                                closeButton: true,
                                navButtons: true,
                                closeOnSideClick: true,
                                nextOnContentClick: true
                    });
                }
                else{
                    replyItem.html(`
                        <div class="text-center text-danger mt-10">
                            ${response.message}
                        </div>
                   `)
                }

            }),

            error:(function (response) {

                loaderElement.addClass('d-none');

                replyItem.html(`
                    <div class="text-center text-danger mt-10">
                        {{translate('Something went wrong !! Please Try agian')}}
                    </div>
                `)

            })
        })
    }



    /** previous ticket */
    $(document).on('click','.previous-ticket',function(e){

        formSubmitted = true;

        var ticketId        = $(this).attr('data-ticket');
        var parentTicketId  =  "{{$ticket->ticket_number}}"
        var modal = $('#ticketModal')
        modal.modal('show');

        $.ajax({
            type: 'POST',
            url:"{{ route('admin.ticket.modal.view')}}",
            data: {
                _token: '{{ csrf_token() }}',

                ticket_id        : ticketId,
                parent_ticket    : parentTicketId,

            },

            beforeSend: function () {
                modal.find('.modal-loader').removeClass('d-none');
                modal.find(".ticket-html").html('')
            },

            success: function(data) {
                if(data.status){
                    setTimeout(function() {
                        modal.find('.modal-loader').addClass('d-none');
                        modal.find(".ticket-html").html(data.ticket_html)
                        loadMoreMessages(modalPage,data.ticketId ,modal)
                        int_summernote()
                    }, 1000);

                }else{
                    toastr(data.message,'danger')
                }


            },

            error: function (error){
                if(error && error.responseJSON){
                    if(error.responseJSON.errors){
                        for (let i in error.responseJSON.errors) {
                            toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }
                    else{
                        if((error.responseJSON.message)){
                            toastr(error.responseJSON.message,'danger')
                        }
                        else{
                            toastr( error.responseJSON.error,'danger')
                        }
                    }
                }
                else{
                    toastr(error.message,'danger')
                }
            }
        });
        e.preventDefault();
    })



    /** Ticket notifications sataus update ajax */
    $(document).on('click', '.ticket-status-update', function (e) {

        formSubmitted = true;

        var status  = $(this).attr('data-status');
        var key     = $(this).attr('data-key');
        var id      = "{{$ticket->id}}";

        $.ajax({
                method: 'POST',
                url: '{{route("admin.ticket.update.notification")}}',
                data: {
                    "_token" :"{{csrf_token()}}",
                    'id'     :id,
                    'key'    :key,
                    'status' :status,
                },
            dataType: 'json',
            success: function (response) {

                if (response) {
                    var status =  'danger'
                    if(response.status)
                    {
                        status =  'success'
                    }
                    toastr(response.message,status)
                    if(response.reload){
                        location.reload()
                    }

                } else {
                    toastr("{{translate('This Function is Not Avaialbe For Website Demo Mode')}}",'danger')
                }
            },
            error: function (error){
                if(error && error.responseJSON){
                    if(error.responseJSON.errors){
                        for (let i in error.responseJSON.errors) {
                            toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }
                    else{
                        if((error.responseJSON.message)){
                            toastr(error.responseJSON.message,'danger')
                        }
                        else{
                            toastr( error.responseJSON.error,'danger')
                        }
                    }
                }
                    else{
                        toastr(error.message,'danger')
                    }
            }
        })


    })




     /** Show message event */
    $(document).on('click','.show-message',function(e){

        var message   = $(this).attr('data-message');

        $('#originalMesssage').html(message)
        var modal = $('#showMessage')
        modal.css("z-index", "999999");
        modal.modal('show');
        $('.modal-backdrop').css("z-index", '9999');


    });

    /** edit message event */
    $(document).on('click','.edit-message',function(e){

        var id         = $(this).attr('data-id');
        var message    = $(this).attr('data-message');
        var selector   = $('.update-message');


        $('#messageId').val(id);

        selector.summernote('code',message);

        var modal = $('#updateMessage');
        modal.css("z-index", "999999");
        modal.modal('show');
        $('.modal-backdrop').css("z-index", '9999');

    })


     /** Ticket update message  ajax */
     $(document).on('submit', '.ticket-update', function (e) {
        formSubmitted = true;
        e.preventDefault();

        var formData = $(this).serialize();

        var element  = $('this');

        $.ajax({
                method: 'POST',
                url: '{{route("admin.ticket.update.message")}}',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $(".submit-btn").find(".note-btn-spinner").remove();
                    $(".submit-btn").append(`<div class="ms-1 spinner-border spinner-border-sm text-white note-btn-spinner " role="status">
                            <span class="visually-hidden"></span>
                        </div>`);
                },
                success: function (response) {

                    if(response.status){
                        toastr(response.message,'success')
                        var modal  = $('#ticketModal').hasClass('show') ? "ticketModal" : '';
                        loadMoreMessages(1 ,response.ticket_id, modal,  true)
                    }
                },
                error: function (error){
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            if((error.responseJSON.message)){
                                toastr(error.responseJSON.message,'danger')
                            }
                            else{
                                toastr( error.responseJSON.error,'danger')
                            }
                        }
                    }
                        else{
                            toastr(error.message,'danger')
                        }
                },
                complete: function() {

                    $('#updateMessage').modal("hide")
                    $(".submit-btn").find(".note-btn-spinner").remove();
                },
                })


     })

    /** ticket reply shortcut event */
    $(document).keydown(function(event) {

        if (event.key.toUpperCase() === 'R'
        && !event.ctrlKey
        && !event.altKey
        && !event.shiftKey
        && !event.metaKey
        && !isTypingInInputField(event)) {

            var modal = $('#ticketModal').hasClass('show') ? true : false;
            enable_reply_option(modal);
        }
    });


    $(document).on('click','#aiBtn',function(e){
        $("#description").html('')
        $("#descriptionSection").addClass('d-none')

    })

    /** ticket add note modal event */
    $(document).on('click','.add-note',function(e){

        var ticketId = $(this).attr('data-ticket');

        var modal = $('#addNote');
        modal.find('#ticketId').val(ticketId);

        modal.css("z-index", "999999");
        modal.find('.summernote').summernote('code','')
        modal.modal('show')

        $('.modal-backdrop').css("z-index", '9999');


    });

    

    /** Canned reply modal */
    $(document).on('click','.assign-btn',function(e){

        var modal = $('#assignModal');
        var ticketId = $(this).attr('data-ticket');
        if(ticketId){
            modal.find(".assign-ticket").val(ticketId)
        }
        modal.modal('show')


    });



    /** Canned reply modal */
    $(document).on('click','.canned-reply',function(e){

        var modal = $('#cannedReply');
        modal.css("z-index", "999999");
        modal.modal('show')
        $('.modal-backdrop').css("z-index", '9999');

    });

     /** Canned reply modal close */
    $(document).on('click','.canned-reply-close',function(e){
        $('.modal-backdrop').css("z-index", '');

    });

     $(document).on('click', function(event) {
        if ($(event.target).closest('#ticketModal').length === 0 && $('#ticketModal').is(':visible')) {

            $('.modal-backdrop').css("z-index", '');
        }
    });



    /** ticket add note ajax */
    $(document).on("submit",'#noteform',function(e){

        formSubmitted = true;

        var formData = $(this).serialize();

        $.ajax({
            url: "{{route('admin.ticket.add.note')}}",
            type: "post",
            data:formData,
            dataType:'json',
            beforeSend: function() {
                $('.note-btn-spinner').removeClass('d-none');
            },

            success:(function (response) {
                if(response.status){
                    toastr(response.message,'success')

                    $('.summernote').summernote('code','');

                    var modal  = '';

                    if($('#ticketModal').hasClass('show')){
                        modal  = 'ticketModal';
                        $('.modal-backdrop').css("z-index", '');
                    }

                    loadMoreMessages(1 ,response.ticket_id, modal,  true)

                }
            }),
            error:(function (error) {

                if(error && error.responseJSON){
                    if(error.responseJSON.message){
                        toastr(error.responseJSON.message,'danger')
                    }
                    else{
                        for (let i in error.responseJSON.errors) {
                           toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }

                }
                else{
                    toastr("{{translate('This Function is Not Avaialbe For Website Demo Mode')}}",'danger')
                }
            }),
            complete: function() {

                $('#addNote').modal("hide")
                 $('.note-btn-spinner').addClass('d-none')
            },
        })
        e.preventDefault()
    });


    /** ticket status update ajax */

    $(document).on('change','#ticket-status',function(e){

            formSubmitted = true;
            var ticketId =  "{{$ticket->id}}";
            var status   =   $(this).val();

            var modal = false ;
            if($(this).hasClass('ticket-modal')){
               
                modal = true ;
                ticketId =  $(this).find(':selected').attr('data-id')
            }

            $.ajax({
                method: 'POST',
                url: '{{route("admin.ticket.status.update")}}',
                data: {
                    "_token" :"{{csrf_token()}}",
                    'id'     :ticketId,
                    'key'    :'status',
                    'status' :status,
                },
               dataType: 'json',
               success: function (response) {

                    if (response) {
                        var status =  'danger'
                        if(response.status){
                            status =  'success'

                              var selector =    modal
                                                    ? $('#ticketModal').find('.reply-card')
                                                    : $('.reply-card');
                               selector.html(response.reply_card)
                               
                                if(!modal){
                                  $('.ticket-header').html(response.ticket_header)
                                }

                               int_summernote();

                        }
                        toastr(response.message,status)

                    } else {
                        toastr("{{translate('This Function is Not Avaialbe For Website Demo Mode')}}",'danger')
                    }
                },
                error: function (error){

                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            if((error.responseJSON.message)){
                                toastr(error.responseJSON.message,'danger')
                            }
                            else{
                                toastr( error.responseJSON.error,'danger')
                            }
                        }
                    }

                    else{
                        toastr(error.message,'danger')
                    }
                }
            })


    })


    /** ticket mute ajax */

    $(document).on('click','#mute-user',function(e){
        formSubmitted = true;
        var ticketId =  $(this).attr('data-ticket');
        var url = "{{ route('admin.ticket.make.mute', ":ticketId") }}";
           url = url.replace(':ticketId', ticketId);

        $.ajax({
            method: 'get',
            url: url,

            dataType: 'json',
            success: function (response) {
                var selector = $('#ticketModal').hasClass('show') ?  $('#ticketModal').find('#mute-user') : $('#mute-user');
                var icon = `<i class="mute-icon ri-notification-4-line icon-sm text-light"></i>`;
                if(response.status) {

                    icon = `<i class="mute-icon ri-notification-off-line icon-sm text-light"></i>`;
                    selector.removeClass('bg-success');
                    selector.addClass('bg-danger');

                }else{
                    selector.addClass('bg-success');
                    selector.removeClass('bg-danger');
                }

                selector.html(icon)

            },
            error: function (error){

                if(error && error.responseJSON){
                    if(error.responseJSON.errors){
                        for (let i in error.responseJSON.errors) {
                            toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }
                    else{
                        if((error.responseJSON.message)){
                            toastr(error.responseJSON.message,'danger')
                        }
                        else{
                            toastr( error.responseJSON.error,'danger')
                        }
                    }
                }

                else{
                    toastr(error.message,'danger')
                }
            }
        })
    })


    /** priority status update event */
    $(document).on('change','#priority-status',function(e){

        $('#status').val($(this).val())
        $('#key').val('priority')
        $('#ticket-id').val("{{$ticket->id}}")
        $('#statusUpdate').submit()
        e.preventDefault()
    })

    /** canned reply  event */
    $(document).on('change','#cannedReplyBody',function(e){

        var html  = $(this).val()
        $('.summernote').summernote('destroy');

         var modal =$('#ticketModal');
         var selector  =  modal.hasClass('show') ? modal.find(".summernote") : $('.summernote');
         var replyCard =  modal.hasClass('show') ? modal.find(".reply-card") : $('.reply-card');
         selector.summernote('code',html);

         int_summernote();
        $('#cannedReply').modal('hide')


        $('.modal-backdrop').css("z-index", '');


        replyCard.removeClass('d-none')
        e.preventDefault()
    })


    /** init summernote editor */
    function int_summernote(selector = 'summernote'){

        $(`.${selector}`).summernote({
            height: 300,
            placeholder: '{{translate("Start typing...")}}',
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['picture', 'link', 'video']],
            ['view', ['codeview']],

            ],
            callbacks: {
                onInit: function() {

                }
            }
        });
    }

    $(document).on('click','.agentBtn',function(e){

        var agentId = $(this).attr('value')
        $('.assignedToBtn').val(agentId)

    });


    var formSubmitted = false;


    $(document).on('click',".delete-item",function(e){

        formSubmitted = true;

        e.preventDefault();
        

    });
    /** ticket reply form ajax */


    $(document).on("submit",'.ticketReply',function(e){

        formSubmitted = true;

        var form = this;

        var formData = new FormData(form);

        if($('#ticketModal').hasClass('show')){
            var modal = $('#ticketModal');
            var formData = new FormData(modal.find('form.ticketReply')[0]);
        }

        $.ajax({
            url: "{{route('admin.ticket.reply')}}",
            type: "post",
            data:formData,
            dataType:'json',
            processData: false,
            contentType: false,
            beforeSend: function() {

                 $('.reply-option').addClass('d-none');
                 $('.reply-btn-spinner').removeClass('d-none');

            },
            success:(function (response) {
                if(response.status == 'success'){
                    toastr(response.message,'success')
                

                    $('#ticketFile').val('');

                    $('.summernote').summernote('code','');
                    $('#ticketModal').find('.summernote').summernote('code','');

                    var modal  = '';

                    if($('#ticketModal').hasClass('show')){
                        modal  = 'ticketModal';
                    }



                    var selector =    $('#ticketModal').hasClass('show')
                                                    ? $('#ticketModal').find('.reply-card')
                                                    : $('.reply-card');
                    selector.html(response.reply_card)
                    int_summernote();
                    loadMoreMessages(1 ,response.ticket_id, modal,  true)

                    if(response.url){
                        window.location.href =  response.url;
                    }
                }
            }),
            error:(function (error) {

                if(error && error.responseJSON){
                    if(error.responseJSON.message){
                        toastr(error.responseJSON.message,'danger')
                    }
                    else{
                        for (let i in error.responseJSON.errors) {
                           toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }

                }
                else{
                    toastr("{{translate('This Function is Not Avaialbe For Website Demo Mode')}}",'danger')
                }
            }),
            complete: function() {

                 $('.reply-option').removeClass('d-none');
                 $('.reply-btn-spinner').addClass('d-none');
            },
        })
        e.preventDefault()
    });




    $(document).on('click', 'a:not([target="_blank"])', function (e) {
        if (!formSubmitted && !$(e.target).closest('#text-editor').length) {


            if($(this).attr('href') != "#"){
                saveDraft();
            }
     
        }
    });


    $(document).on('click', '.edit-draft', function (e) {

        var message = $(this).attr('data-message');
        var id      = $(this).attr('data-id');
        $(`#messageCard-${id}`).addClass('d-none');
        $('#draft_message_id').val(id);
        $('.reply-card').removeClass('d-none')
        $('.summernote').summernote('destroy');
        $('.summernote').html(message);

        int_summernote()


    });

    function saveDraft() {

        var draftContent = $('#text-editor').summernote('code');
        var draftId      = $('#draft_message_id').val();

        $.ajax({
            type: 'POST',
            url:"{{ route('admin.ticket.save.draft')}}",
            data: {
                _token: '{{ csrf_token() }}',
                draft       : draftContent,
                ticket_id   : "{{$ticket->id}}",
                draft_id    : draftId,

            },
            success: function(data) {

            },

            error: function (error) {

            }
        });
    }



    $(document).on('click','.reply-btn',function(e){

        var isModal = false;

        if($(this).hasClass('modal-ticket')){
            isModal = true;
        }
        enable_reply_option(isModal)
    })




    $(document).on('click','.envato-verification-btn',function(e){

        var isModal = false;

        if($(this).hasClass('modal-ticket')){
            isModal = true;
        }
        expand_envato_card(isModal)
   })


   function expand_envato_card(modal = false){
        var selector  = modal ? $('#ticketModal').find('.envato--card') :  $('.envato--card')
        selector.toggleClass('d-none')
   }


    function isTypingInInputField(event) {

        var targetEvent   = event.target;
        var targetTagName = targetEvent.tagName.toLowerCase();
        return (targetTagName == 'input' || targetTagName == 'textarea' || targetEvent.classList.contains("note-editable"));
    }

    function enable_reply_option (modal = false){
        var selector  = modal ? $('#ticketModal').find('.reply-card') :  $('.reply-card')
        $('.envato--card').addClass('d-none')
        selector.toggleClass('d-none')
    }


    $(document).on('click','.merge-ticket',function(e){

        var ticketId = $(this).attr('data-ticket');

        var modal = $('#merge-modal');
        $("#childTicket").val(ticketId)
        modal.css("z-index", "999999");
        modal.modal('show')
        $('.modal-backdrop').css("z-index", '9999');
        modal.modal('show')

    })



    })(jQuery);

</script>
