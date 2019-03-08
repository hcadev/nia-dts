$(function(){
    $("#new-employee").click(function(){
        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('New Employee');
        $("#largeModal .modal-body").load('new');

        $("#largeModal .modal-body").on("submit", "#employee-form", function(e){
            var post = $("#employee-form").serializeArray();

            $.post('new', post, function(response){
                if (response.post_status == 'Success')
                {
                    $("#largeModal .modal-body").empty();
                    $("#largeModal .modal-body").append(response.html);

                    $("#largeModal").modal('hidden.bs.modal', function(){
                        location.reload();
                    });
                }
                else
                {
                    $("#largeModal .modal-body").empty();
                    $("#largeModal .modal-body").append(response.html);
                }
            }, 'json');

            e.preventDefault();
        })
    });

    $(".employee-block").click(function(){
        var employee_id = $(this).parents('tr').find('td:nth-child(2) span.employee-id').text();
        var employee_name = $(this).parents('tr').find('td:nth-child(2) span.employee-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Block '+employee_name);
        $("#smallModal .modal-body").append('<div class="row"><div class="col-lg-6"><a id="cancel-employee-block" class="btn btn-primary btn-block btn-sm">Cancel</a></div><div class="col-lg-6"><a id="confirm-employee-block" class="btn btn-danger btn-block btn-sm">Confirm</a></div></div>');

        $("#smallModal").on("click", "#cancel-employee-block", function(e){
            $("#smallModal .modal-body").empty();
            $("#smallModal").modal('toggle');
            return false;
        });

        $("#smallModal").on("click", "#confirm-employee-block", function(e){
            $.post('block', {id : employee_id}, function(response){
                if (response.post_status == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    location.reload();
                }
            }, 'json');
            return false;
        });
    });

    $(".employee-allow").click(function(){
        var employee_id = $(this).parents('tr').find('td:nth-child(2) span.employee-id').text();
        var employee_name = $(this).parents('tr').find('td:nth-child(2) span.employee-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Unblock '+employee_name);
        $("#smallModal .modal-body").append('<div class="row"><div class="col-lg-12"><div class="alert alert-warning small">Some positions require only 1 employee to be active. Unblocking this employee may block other employees of the same position.</div></div> </div><div class="row"><div class="col-lg-6"><a id="cancel-employee-allow" class="btn btn-primary btn-block btn-sm">Cancel</a></div><div class="col-lg-6"><a id="confirm-employee-allow" class="btn btn-danger btn-block btn-sm">Confirm</a></div></div>');

        $("#smallModal").on("click", "#cancel-employee-allow", function(){
            $("#smallModal .modal-body").empty();
            $("#smallModal").modal('toggle');
            return false;
        });

        $("#smallModal").on("click", "#confirm-employee-allow", function(){
            $.post('allow', {id : employee_id}, function(response){
                if (response.post_status == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    location.reload();
                }
            }, 'json');
            return false;
        });
    });

    $(".employee-delete").click(function(){
        var employee_id = $(this).parents('tr').find('td:nth-child(2) span.employee-id').text();
        var employee_name = $(this).parents('tr').find('td:nth-child(2) span.employee-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Delete '+employee_name);
        $("#smallModal .modal-body").append('<div class="row"><div class="col-lg-12"><div class="alert alert-warning small">Employees who have logged in at least once can not be deleted.</div></div> </div><div class="row"><div class="col-lg-6"><a id="cancel-employee-delete" class="btn btn-primary btn-block btn-sm">Cancel</a></div><div class="col-lg-6"><a id="confirm-employee-delete" class="btn btn-danger btn-block btn-sm">Confirm</a></div></div>');

        $("#smallModal").on("click", "#cancel-employee-delete", function(){
            $("#smallModal .modal-body").empty();
            $("#smallModal").modal('toggle');
            return false;
        });

        $("#smallModal").on("click", "#confirm-employee-delete", function(){
            $.post('delete', {id : employee_id}, function(response){
                if (response.post_status == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    location.reload();
                }
            }, 'json');
            return false;
        });
    });
});