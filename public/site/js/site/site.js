// Example starter JavaScript for disabling form submissions if there are invalid fields
$(document).ready(function () {



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#contact-us").click(function(e){
        e.preventDefault();
        // (function () {
        //     'use strict'
        //
        //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
        //     var forms = document.querySelectorAll('.needs-validation')
        //
        //     // Loop over them and prevent submission
        //     Array.prototype.slice.call(forms)
        //         .forEach(function (form) {
        //             form.addEventListener('submit', function (event) {
        //                 if (!form.checkValidity()) {
        //                     event.preventDefault()
        //                     event.stopPropagation()
        //                 }
        //
        //                 form.classList.add('was-validated')
        //             }, false)
        //         })
        // })()

        var fullname = $("#full-name").val();
        var email = $("#Emailid").val();
        var subject = $("#Subject").val();
        var phoneNumber = $("#PhoneNumber").val();
        var message = $("#text-message").val();

        console.log(fullname,email,subject,phoneNumber,message)

        $.ajax({
            type:'POST',
            url:"{{ route('send-message') }}",
            data:{
                fullname:fullname,
                email:email,
                subject:subject,
                phoneNumber:phoneNumber,
                message:message
            },
            success:function(data){
                alert(data.success);
            }
        });

    });
})




