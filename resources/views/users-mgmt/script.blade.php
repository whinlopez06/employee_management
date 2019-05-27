<script>
    $(document).ready(function(){


        function resetAllFields(){
            
            let inputDivClassname = ['.div-username', '.div-email', '.div-password', '.div-password_confirm', '.div-firstname', '.div-lastname'];
            let inputErrorClassname = ['.username_error', '.email_error', '.password_error', '.password_confirm_error', '.firstname_error', '.username_error'];
            let inputFields = ['#username', '#email', '#password', '#password_confirm', '#firstname', '#middlename', '#lastname'];

            inputDivClassname.forEach( function(val) {
                $(val).removeClass('has-error');    
            });

            inputErrorClassname.forEach( function(val) {
                $(val + ' span').text('');
                $(val).addClass('hidden');
            });

            inputFields.forEach( function (val) {
                //$('input[name=username]').val()
                $(val).val('');
            });

        }

        let showValidationClass = function(clsName, val) {

            $('.div-' + clsName).addClass('has-error');
            $('.' + clsName + '_error').removeClass('hidden');
            $('.' + clsName + '_error span').text(val);

        };

        let showAlertMessage = function(message, alertMode) {
            $('#div-alert').removeClass('hidden');
            $('#div-alert').addClass(alertMode);
            $('#div-alert span').text(message);

            $("#div-alert").fadeTo(5000, 500).slideUp(500, function(){
                //--$("#div-alert").slideUp(500);
                $("#div-alert").slideUp(500, function(){
                    //callback 
                    $('#div-alert').removeClass(alertMode);
                    $('#div-alert').addClass('hidden');
                    $('#div-alert span').text('');
                });
            });   
        };


        $('#addNewUser').on('click', function() {
            resetAllFields();
        }); 


        $('#createUser').on('click', function() {

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

                    let data = response.data;
          
                    //"<tr class='post" + data.id + "'>"+
                    $('#userTable').append(
                    "<tr role='row' class='user-" + data.id + "'>"+
                    "<td>" + data.username + "</td>" +
                    "<td>" + data.email + "</td>" +
                    "<td>" + data.firstname + "</td>" +
                    "<td>" + data.lastname + "</td>" +
                    "<td><button class='btn btn-info ' data-user_id='" + data.id + "' data-username='" + data.username + "' data-email='" + data.email + "' data-firstname='" + data.firstname + "' data-middlename='" + data.middlename + "' data-lastname='" + data.lastname + "'" + 
                    " data-toggle='modal' data-target='#editUserModal' data-backdrop='static'><span class='glyphicon glyphicon-edit'> </span> Edit</button>&nbsp;" +
                    " <button class='btn btn-danger ' data-user_id='" + data.id + "' data-toggle='modal' data-target='#deleteUserModal'><span class='glyphicon glyphicon-trash'> </span> Delete</button></td>" +
                    "</tr>");

                    //$('#userTable table tbody tr:last').addClass('highlight');
                    $('#userTable').find('tbody tr:last').addClass('bg-success').siblings().removeClass('bg-success');
                    resetAllFields();
                    $("#addUserModal .close").click();  // close the form
                    showAlertMessage(response.message, 'alert-success');
                },
                error: function (response, textStatus, jqXHR){

                    var aData = response.responseJSON;
                    $.each(aData.errors, function(key, val) {
                        showValidationClass(key, val);
                    });

                }
            });                    
        })


        $('#editUserModal').on('show.bs.modal', function (event) {
            
            resetAllFields();

            var button = $(event.relatedTarget); // Button that triggered the modal
            //console.log(button);
            var username = button.data('username'); // Extract info from data-* attributes
            var email = button.data('email');
            var password = button.data('password');
            var firstname = button.data('firstname');
            var middlename = button.data('middlename');
            var lastname = button.data('lastname');
            var user_id = button.data('user_id');
            
            /* let fieldObj = {
                 username : button.data('username'),
                 email : button.data('email'),
            }; */

            var modal = $(this);    // instance of the current modal
            modal.find('.modal-body #username').val(username);
            modal.find('.modal-body #email').val(email);
            
            modal.find('.modal-body #firstname').val(firstname);
            modal.find('.modal-body #middlename').val(middlename);
            modal.find('.modal-body #lastname').val(lastname);

            modal.find('.modal-body #user_id').val(user_id);
        });


        $('#updateUser').on('click', function() {
            
            let user_id = $('#editUserModal').find('.modal-body #user_id').val();
            let username = $('#editUserModal').find('.modal-body #username').val();
            let email = $('#editUserModal').find('.modal-body #email').val();
            let password = $('#editUserModal').find('.modal-body #password').val();
            let password_confirm = $('#editUserModal').find('.modal-body #password_confirm').val();
            let firstname = $('#editUserModal').find('.modal-body #firstname').val();
            let middlename = $('#editUserModal').find('.modal-body #middlename').val();
            let lastname = $('#editUserModal').find('.modal-body #lastname').val();
            let httpMethod = $('#editUserModal').find('.modal-body input[name=_method]').val();
            //var code = $('#editModal').find('.modal-body #code').val();

            $.ajax({
                type: "POST",
                url: "{{ url('user-management') }}/" + user_id,
                data: {
                    '_token' : $('input[name=_token]').val(),
                    '_method' : httpMethod,
                    'user_id' : user_id,
                    'username' : username,
                    'password' : password,
                    'email' : email,
                    'password_confirm' : password_confirm,
                    'firstname' : firstname,
                    'middlename' : middlename,
                    'lastname' : lastname
                },
                success: function(response) {

                    let data = response.data;
                    console.log(data);
                    $('.user-'+data.id).replaceWith(" "+
                    "<tr role='row' class='user-" + data.id + "'>" + 
                    "<td>"+ data.username + "</td>" +
                    "<td>"+ data.email + "</td>" +
                    "<td>"+ data.firstname + "</td>" +
                    "<td>"+ data.lastname + "</td>" +
                    "<td><button class='btn btn-info ' data-user_id='" + data.id + "' data-username='" + data.username + "' data-email='" + data.email + "' data-firstname='" + data.firstname + "' data-middlename='" + data.middlename + "' data-lastname='" + data.lastname + "'" + 
                    " data-toggle='modal' data-target='#editUserModal' data-backdrop='static'><span class='glyphicon glyphicon-edit'> </span> Edit</button>&nbsp;" +
                    " <button class='btn btn-danger ' data-user_id='" + data.id + "' data-toggle='modal' data-target='#deleteUserModal'><span class='glyphicon glyphicon-trash'> </span> Delete</button></td>" +
                    "</tr>");
               
                    //--$('#userTable').find('tbody tr:last').addClass('bg-success').siblings().removeClass('bg-success');
                    $('#userTable').find('tbody tr.user-'+data.id).addClass('bg-success').siblings().removeClass('bg-success');
                    //resetAllFields();
                    $("#editUserModal .close").click();  // close the form
                    showAlertMessage(response.message, 'alert-success');
                }, 
                error: function (response, textStatus, jqXHR){

                    var aData = response.responseJSON;
                    console.log(aData);
                    $.each(aData.errors, function(key, val) {
                        showValidationClass(key, val);
                    });

                }
            });
        });


        $('#deleteUserModal').on('show.bs.modal', function (event) {
                
            let button = $(event.relatedTarget);
            var user_id = button.data('user_id');

            var modal = $(this);    // instance of the current modal
            modal.find('.modal-body #user_id').val(user_id);

        });

        $('#deleteUser').on('click', function() {
          
            let user_id = $('#deleteUserModal').find('.modal-body #user_id').val(); 
            let httpMethod = $('#deleteUserModal').find('.modal-body input[name=_method]').val();
            //alert('userid: '+user_id + ' method: '+ httpMethod);
            //$('.user-'+user_id + ' table tr').remove();
            
            $.ajax({
                type: 'POST',
                url: "{{ url('user-management') }}/" + user_id,
                data: {
                    '_token' : $('input[name=_token]').val(),
                    '_method' : httpMethod,
                    'user_id' : user_id
                },
                success: function (response) {
                    $('.user-'+user_id).remove();
                    showAlertMessage(response.message, 'alert-success');
                    $("#deleteUserModal .close").click();  // close the form
                }, error: function (response) {
                   
                }
            });       

        });


    }); 
                
</script>