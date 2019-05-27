<script>
        $(document).ready(function(){

            
            function resetFields(){
                
                let inputDivClassname = ['.div-username', '.div-email', '.div-password', '.div-password_confirm', '.div-firstname', '.div-lastname'];
                let inputErrorClassname = ['.username_error', '.email_error', '.password_error', '.password_confirm_error', '.firstname_error', '.username_error'];
                
                inputDivClassname.forEach( function(val) {
                    $(val).removeClass('has-error');    
                });

                inputErrorClassname.forEach( function(val) {
                    $(val + ' span').text('');
                    $(val).addClass('hidden');
                });

            }

            /* $('#addNewUser').on('click', function() {
                alert('addNewUser onclick');
                resetInput();
            }); */

            $('#createUser').on('click', function() {
                
                resetFields();

                // ajax call
                $.ajax({
                    type: 'POST',
                    url:    "{{ url('user-management') }}",
                    data: {
                        '_token' : $('input[name=_token]').val(),
                        'username' : $('input[name=username]').val(),
                        'password' : $('input[name=password]').val(),
                        'email' : $('input[name=email]').val(),
                        'password_confirm' : $('input[name=password_confirm]').val(),
                        'firstname' : $('input[name=firstname]').val(),
                        'middlename' : $('input[name=middlename]').val(),
                        'lastname' : $('input[name=lastname]').val()
                    },
                    dataType: 'json',
                    success: function(response){
                        console.log(response);  // {success: true, data: {…}}
                        console.log(JSON.parse(response.success));  // true
                        console.log(response.data);  //{username: "laramix", email: "lara@gmail.com", firstname: "lara", middlename: "l", lastname: "velmix", …}
                        
                        if(response.errors){
                            // remove hidden prop of the error message
                            //$('.username_error').removeClass('hidden');
                            //$('.username_error span').text(response.errors.username);
                        }
                    },
                    error: function (response, textStatus, jqXHR){
                        /*console.log($.parseJSON(data.responseText));
                        var jData = $.parseJSON(data.responseText);
                        console.log(jData.success);
                        console.log(jData.errors);
                        console.log(jData);*/

                        //console.log(JSON.parse(response.success));
                        //console.log(JSON.parse(response));
                        //console.log($.parseJSON(response));
                        //console.log($.parseJSON(response.success));
                        //console.log(response.errors);
                        //console.log(response.success);
                        //console.log(response.responseText);
                    
                        console.log(response);  //{readyState: 4, getResponseHeader: ƒ, getAllResponseHeaders: ƒ, setRequestHeader: ƒ, overrideMimeType: ƒ, …}
                        console.log(JSON.parse(response.responseText)); //working: {success: false, errors: {…}}
                        var aData = response.responseJSON;  //{success: false, errors: {…}}
                        console.log(aData.errors);  //{username: Array(1), email: Array(1), password: Array(1), password_confirm: Array(1), firstname: Array(1), …}
                        console.log(aData.errors.email);    //["The email field is required."]
                        console.log(aData.success); // false
                 

                        $.each(aData.errors, function(key, value) {
                            //console.log(key + ' _ ' + value);   //username _ The username field is required.

                            $('.div-' + key).addClass('has-error');
                            console.log('.' + key + '_error span');
                            $('.' + key + '_error').removeClass('hidden');
                            $('.' + key + '_error span').text(value);
                        });
                        //$('.div-username').addClass('has-error');


                    }
                });                    
            })


            $('#editModal').on('show.bs.modal', function (event) {

                var button = $(event.relatedTarget); // Button that triggered the modal
                console.log(button);
                var username = button.data('username'); // Extract info from data-* attributes
                var email = button.data('email');
                var password = button.data('password');
                var firstname = button.data('firstname');
                var middlename = button.data('middlename');
                var lastname = button.data('lastname');

                var modal = $(this);    // instance of the current modal
                modal.find('.modal-body #username').val(username);
                modal.find('.modal-body #email').val(email);
                
                modal.find('.modal-body #firstname').val(firstname);
                modal.find('.modal-body #middlename').val(middlename);
                modal.find('.modal-body #lastname').val(lastname);

            });

        });
    </script>