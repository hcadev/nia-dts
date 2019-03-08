$(function(){
    $(".project-name").popover({
        html : true,
        trigger : 'hover',
        content : function(){
            var project_id = $(this).parents('tr').find('td:first').text();
            return $(".pop-content-"+project_id).html();
        }
    });

    $("#new-project").click(function(){
        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('New Project');
        $("#largeModal .modal-body").load('new');

        $("#largeModal").on("submit", "#project-add-form", function(e){
            var post = $("#project-add-form").serializeArray();
            project_form_submit('new', post);
            e.preventDefault();
            e.stopImmediatePropagation();
        });
    });

    $(".edit-project").click(function(){
        var project_id = $(this).parents('tr').find('td:first').text();

        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('Edit Project');
        $("#largeModal .modal-body").load('edit?id='+project_id);

        $("#largeModal").on("submit", "#project-edit-form", function(e){
            var post = $("#project-edit-form").serializeArray();
            project_form_submit('edit?id='+project_id, post);
            e.preventDefault();
            e.stopImmediatePropagation();
        });
    });

    $(".send-project").click(function(){
        var project_id = $(this).parents('tr').find('td:first').text();
        var project_name = $(this).parents('tr').find('a.project-name').text();

        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('Send Project - '+project_name);
        $("#largeModal .modal-body").empty();
        $("#largeModal .modal-body").load('send?project_id='+project_id);

        $("#largeModal").on("submit", "#project-send", function(e){
            var post = {recipient_id : $("#project-send #recipient-id").text(), remarks : $("#project-send #purpose").text()+' '+$("#project-send [name=remarks]").val()};

            $.post('send?project_id='+project_id, post, function(response){
                if (response.post_status == 'Success')
                {
                    $("#largeModal").modal('toggle');
                    location.reload();
                }
                else
                {
                    $("#largeModal .modal-body").empty();
                    $("#largeModal .modal-body").append(response.html);
                }
            }, 'json');

            e.preventDefault();
            e.stopImmediatePropagation();
        });

        return false;
    });

    $(".receive-project").click(function(){
        $.ajax({
            url: 'receive?project_id='+$(this).parents('tr').find('td:first').text(),
            success: function(response){
                if (response == 'Success')
                {
                    location.reload();
                }
            }
        });
    });

    function project_form_submit(url, data)
    {
        $.post(url, data, function(response){
            $("#largeModal .modal-body").empty();
            $("#largeModal .modal-body").append(response.html);

            if (response.post_status == 'Success')
            {
                $("#largeModal").on('hidden.bs.modal', function(){
                    location.reload();
                });
            }
        }, 'json');
    }

    $(".delete-project").click(function(e){
        var project_id = $(this).parents('tr').find('td:first').text();
        var project_name = $(this).parents('tr').find('td:nth-child(3) .project-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Delete Project');
        $("#smallModal .modal-body").load('delete?id='+project_id);

        $("#smallModal").on("click", "#cancel-project-delete", function(e){
            $("#smallModal").modal('toggle');
        });

        $("#smallModal").on("click", "#confirm-project-delete", function(e){
            $.post('delete?id='+project_id, {delete : true}, function(response){
                $("#smallModal .modal-body").empty();

                if (response.post_status == 'Success')
                {
                    $("#smallModal .modal-body").append('<div class="alert alert-success small">Project no. '+project_id+', '+project_name+', has been deleted, for restoration, contact the administrator.</div>');

                    $("#smallModal").on('hidden.bs.modal', function(){
                        location.reload();
                    });
                }
                else
                {
                    $("#smallModal .modal-body").append(response.html);
                }
            }, 'json');
        });
    });

    $(".restore-project").click(function(e){
        var project_id = $(this).parents('tr').find('td:first').text();
        var project_name = $(this).parents('tr').find('td:nth-child(3) .project-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Restore Project');
        $("#smallModal .modal-body").load('restore?id='+project_id);

        $("#smallModal").on("click", "#cancel-project-restore", function(e){
            $("#smallModal").modal('toggle');
        });

        $("#smallModal").on("click", "#confirm-project-restore", function(e){
            $.post('restore?id='+project_id, {restore : true}, function(response){
                $("#smallModal .modal-body").empty();
                if (response.post_status == 'Success')
                {
                    $("#smallModal .modal-body").append('<div class="alert alert-success small">Project no. '+project_id+', '+project_name+', has been restored.</div>');

                    $("#smallModal").on('hidden.bs.modal', function(){
                        location.reload();
                    });
                }
                else
                {
                    $("#smallModal .modal-body").append(response.html);
                }
            }, 'json');
        });
    });

    $("#largeModal").on("click", "#close-project-form", function(){
        $("#largeModal").modal('toggle');
    });

    $(".upload-attachment").click(function(){
        var attachment_id = $(this).parents('tr').find("td:nth-child(2) span.attachment-id").text();
        var attachment_name = $(this).parents('tr').find('td:nth-child(2) span.attachment-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html(attachment_name);
        $("#smallModal .modal-body").load('?attachment=upload');

        $("#smallModal").on("submit", "#attachment-form", function(e){
            e.preventDefault();

            var post = new FormData();
            post.append('file', $("#attachment-form input[name=file]")[0].files[0]);

            $.ajax({
                url : '?attachment=upload&attachment_id=' + attachment_id,
                type : 'POST',
                cache : false,
                data : post,
                processData : false,
                contentType : false,
                dataType : 'json',
                success : function(response){
                    if (response.post_status = 'Success')
                    {
                        $("#smallModal").modal('toggle');
                        $("#smallModal").on('hidden.bs.modal', function(){
                            location.reload();
                        });
                    }
                    else
                    {
                        $("#smallModal .modal-body").empty();
                        $("#smallModal .modal-body").append(response.html);
                    }
                }
            });
        });

        return false;
    });

    $(".replace-attachment").click(function(){
        var attachment_id = $(this).parents('tr').find("td:nth-child(2) span.attachment-id").text();
        var attachment_name = $(this).parents('tr').find('td:nth-child(2) span.attachment-name').text();

        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html(attachment_name);
        $("#smallModal .modal-body").load('?attachment=replace');

        $("#smallModal").on("submit", "#attachment-form", function(e){
            e.preventDefault();

            var post = new FormData();
            post.append('file', $("#attachment-form input[name=file]")[0].files[0]);

            $.ajax({
                url : '?attachment=replace&attachment_id=' + attachment_id,
                type : 'POST',
                cache : false,
                data : post,
                processData : false,
                contentType : false,
                dataType : 'json',
                success : function(response){
                    if (response.post_status = 'Success')
                    {
                        $("#smallModal").modal('toggle');
                        $("#smallModal").on('hidden.bs.modal', function(){
                            location.reload();
                        });
                    }
                    else
                    {
                        $("#smallModal .modal-body").empty();
                        $("#smallModal .modal-body").append(response.html);
                    }
                }
            });
        });

        return false;
    });

    //$(".delete-attachment").click(function(){
    //    var attachment_id = $(this).parents('tr').find("td:nth-child(2) span.attachment-id").text();
    //    var attachment_name = $(this).parents('tr').find('td:nth-child(2) span.attachment-name').text();
    //
    //    $("#smallModal").modal({
    //        keyboard : false,
    //        backdrop : 'static'
    //    });
    //
    //    $("#smallModal .modal-title").html('Delete Attachment - '+attachment_name);
    //    $("#smallModal .modal-body").load('?attachment=delete&attachment_id='+attachment_id);
    //
    //    $("#smallModal").on("click", "#cancel-attachment-delete", function(){
    //        $("#smallModal").modal('toggle');
    //    });
    //
    //    $("#smallModal").on("click", "#confirm-attachment-delete", function(){
    //        $.post('?attachment=delete&attachment_id='+attachment_id, {delete : true}, function(response){
    //            if (response.post_status == 'Success')
    //            {
    //                $("#smallModal").modal('toggle');
    //                location.reload();
    //            }
    //            else
    //            {
    //                $("#smallModal .modal-body").empty();
    //                $("#smallModal .modal-body").append(response.html);
    //            }
    //        }, 'json');
    //
    //        return false;
    //    });
    //
    //    return false;
    //});

    $(".view-attachment").click(function(){
        var attachment_id = $(this).parents('tr').find("td:nth-child(2) span.attachment-id").text();
        var attachment_name = $(this).parents('tr').find('td:nth-child(2) span.attachment-name').text();

        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html(attachment_name);
        $("#largeModal .modal-body").load('?attachment=view&attachment_id='+attachment_id);

        $("#largeModal").on("click", ".attachment", function(e){
            var filename = $(this).find('span.filename').html();
            var filepath = $(this).find('span.filepath').html();

            $('embed').attr('src', '/nia/'+filepath+filename);
        });

        return false;
    });

    $("#project-start").submit(function(e){
        var post = $(this).serializeArray();

        $.post('?project=start', post, function(response){
            if (response.post_status == 'Success')
            {
                location.reload();
            }
            else
            {
                $("#project-start-error").addClass('alert alert-danger small');
                $("#project-start-error").html(response.error);
            }
        }, 'json');

        e.preventDefault();
        e.stopImmediatePropagation();
    });

    $("#report-upload").click(function(){
        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('Upload Report');
        $("#largeModal .modal-body").load('?report=upload');

        $("#largeModal").on("submit", "#report-form", function(e){
            var post = new FormData();
            post.append('title', $("#report-form input[name=title]").val());
            post.append('pa_progress', $("#report-form input[name=pa_progress]").val());
            post.append('fr_progress', $("#report-form input[name=fr_progress]").val());

            if ($("#report-form input[name=file]").val() != '')
            {
                post.append('file', $("#report-form input[name=file]")[0].files[0]);
            }
            $.ajax({
                url : '?report=upload',
                type : 'POST',
                cache : false,
                data : post,
                processData : false,
                contentType : false,
                dataType : 'json',
                success : function(response){
                    if (response.post_status == 'Success')
                    {
                        $("#largeModal").modal('toggle');
                        $("#largeModal").on('hidden.bs.modal', function(){
                            location.reload();
                        });
                    }
                    else
                    {
                        $("#largeModal .modal-body").empty();
                        $("#largeModal .modal-body").append(response.html);
                    }
                }
            });

            e.preventDefault();
            e.stopImmediatePropagation();
        });

        return false;
    });

    $(".report-replace").click(function(){
        var report_id = $(this).parents('tr').find('td:nth-child(2) span.report-id').html();
        var report_title = $(this).parents('tr').find('td:nth-child(2) span.report-name').html();

        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('Edit Report');
        $("#largeModal .modal-body").load('?report=replace&report_id='+report_id);

        $("#largeModal").on("submit", "#report-form", function(e){
            var post = new FormData();
            post.append('title', $("#report-form input[name=title]").val());
            post.append('pa_progress', $("#report-form input[name=pa_progress]").val());
            post.append('fr_progress', $("#report-form input[name=fr_progress]").val());

            if ($("#report-form input[name=file]").val() != '')
            {
                post.append('file', $("#report-form input[name=file]")[0].files[0]);
            }
            $.ajax({
                url : '?report=replace&report_id='+report_id,
                type : 'POST',
                cache : false,
                data : post,
                processData : false,
                contentType : false,
                dataType : 'json',
                success : function(response){
                    if (response.post_status = 'Success')
                    {
                        $("#largeModal").modal('toggle');
                        $("#largeModal").on('hidden.bs.modal', function(){
                            location.reload();
                        });
                    }
                    else
                    {
                        $("#largeModal .modal-body").empty();
                        $("#largeModal .modal-body").append(response.html);
                    }
                }
            });

            e.preventDefault();
            e.stopImmediatePropagation();
        });

        return false;
    });

    //$(".report-delete").click(function(){
    //    var report_id = $(this).parents('tr').find("td:nth-child(2) span.report-id").text();
    //    var report_name = $(this).parents('tr').find('td:nth-child(2) span.report-name').text();
    //
    //    $("#smallModal").modal({
    //        keyboard : false,
    //        backdrop : 'static'
    //    });
    //
    //    $("#smallModal .modal-title").html('Delete Report - '+report_name);
    //    $("#smallModal .modal-body").load('?report=delete&report_id='+report_id);
    //
    //    $("#smallModal").on("click", "#cancel-report-delete", function(){
    //        $("#smallModal").modal('toggle');
    //    });
    //
    //    $("#smallModal").on("click", "#confirm-report-delete", function(){
    //        $.post('?report=delete&report_id='+report_id, {delete : true}, function(response){
    //            if (response.post_status == 'Success')
    //            {
    //                $("#smallModal").modal('toggle');
    //                $("#smallModal").on('hidden.bs.modal', function(){
    //                    location.reload();
    //                });
    //            }
    //            else
    //            {
    //                $("#smallModal .modal-body").empty();
    //                $("#smallModal .modal-body").append(response.html);
    //            }
    //        }, 'json');
    //
    //        return false;
    //    });
    //
    //    return false;
    //});

    $(".report-view").click(function(){
        var report_id = $(this).parents('tr').find("td:nth-child(2) span.report-id").text();
        var report_name = $(this).parents('tr').find('td:nth-child(2) span.report-name').text();

        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html(report_name);
        $("#largeModal .modal-body").load('?report=view&report_id='+report_id);

        $("#largeModal").on("click", ".report", function(e){
            var filename = $(this).find('span.filename').html();
            var filepath = $(this).find('span.filepath').html();

            $('embed').attr('src', '/nia/'+filepath+filename);
        });

        return false;
    });

    $("#project-extend").click(function(){
        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Extend Project');
        $("#smallModal .modal-body").load('?project=extend');

        $("#smallModal").on("submit", "#project-extend", function(e){
            var completion_date = $("#project-extend [name=completion_date]").val();

            $.post('?project=extend', {completion_date : completion_date}, function(response){
                if (response.post_status == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    $("#smallModal").on('hidden.bs.modal', function(){
                        location.reload();
                    });
                }
                else
                {
                    $("#smallModal .modal-body").empty();
                    $("#smallModal .modal-body").append(response.html);
                }
            }, 'json');

            e.preventDefault();
            e.stopImmediatePropagation();
        });

        return false;
    });

    $("#project-complete").click(function(){
        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Complete Project');
        $("#smallModal .modal-body").load('?project=complete');

        $("#smallModal").on("submit", "#project-complete", function(){
            $.post('?project=complete', {complete : true}, function(response){
                if (response.post_status == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    location.reload();
                }
                else
                {
                    $("#smallModal .modal-body").empty();
                    $("#smallModal .modal-body").append(response.html);
                }
            }, 'json');
            return false;
        });

        return false;
    });

    $("#project-send").click(function(){
        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('Send Project - '+$("#project-name").text());
        $("#largeModal .modal-body").load('?project=send');

        $("#largeModal").on("submit", "#project-send", function(e){
            var post = {recipient_id : $("#project-send #recipient-id").text(), remarks : $("#project-send #purpose").text()+' '+$("#project-send [name=remarks]").val()};

            $.post('?project=send', post, function(response){
                if (response.post_status == 'Success')
                {
                    $("#largeModal").modal('toggle');
                    location.reload();
                }
                else
                {
                    $("#largeModal .modal-body").empty();
                    $("#largeModal .modal-body").append(response.html);
                }
            }, 'json');

            e.preventDefault();
            e.stopImmediatePropagation();
        });
    });

    $("#project-receive").click(function(){
        $.ajax({
            url: '?project=receive',
            success: function(response){
                if (response == 'Success')
                {
                    location.reload();
                }
            }
        });
    });

    $("#project-approve").click(function(){
        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Approve '+$("#project-name").text());
        $("#smallModal .modal-body").empty();
        $("#smallModal .modal-body").append('<div class="row"><div class="col-lg-6"><a id="cancel-project-approve" class="btn btn-primary btn-block btn-sm">Cancel</a></div><div class="col-lg-6"><a id="confirm-project-approve" class="btn btn-danger btn-block btn-sm">Confirm</a></div></div>');

        $("#smallModal").on("click", "#cancel-project-approve", function(){
            $("#smallModal").modal('toggle');
            return false;
        });

        $("#smallModal").on("click", "#confirm-project-approve", function(){
            $.post('?project=approve', {approve : true}, function(response){
                if (response == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    location.reload();
                }
            });
            return false;
        });
        return false;
    });

    $("#project-decline").click(function(){
        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Decline '+$("#project-name").text());
        $("#smallModal .modal-body").empty();
        $("#smallModal .modal-body").append('<div class="row"><div class="col-lg-6"></div><div class="col-lg-6 col-lg-offset-6"><a id="confirm-project-decline" class="btn btn-danger btn-block btn-sm">Confirm</a></div></div>');

        $("#smallModal").on("click", "#confirm-project-decline", function(){
            $.post('?project=decline', {approve : true}, function(response){
                if (response == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    location.reload();
                }
            });
            return false;
        });
        return false;
    });

    $("#project-history").click(function(){
        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('History');
        $("#largeModal .modal-body").load('?project=history');
    });

    $("#project-progress").click(function(){
        $("#smallModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#smallModal .modal-title").html('Set Project Progress');
        $("#smallModal .modal-body").load('?project=progress');

        $("#smallModal").on("submit", "#project-progress", function(e){
            var pa_progress = $("#project-progress [name=pa_progress]").val();
            var fr_progress = $("#project-progress [name=fr_progress]").val();

            $.post('?project=progress', {pa_progress : pa_progress, fr_progress : fr_progress}, function(response){
                if (response.post_status == 'Success')
                {
                    $("#smallModal").modal('toggle');
                    $("#smallModal").on('hidden.bs.modal', function(){
                        location.reload();
                    });
                }
                else
                {
                    $("#smallModal .modal-body").empty();
                    $("#smallModal .modal-body").append(response.html);
                }
            }, 'json');

            e.preventDefault();
            e.stopImmediatePropagation();
        });
    });

    $("#project-edit").click(function(){
        $("#largeModal").modal({
            keyboard : false,
            backdrop : 'static'
        });

        $("#largeModal .modal-title").html('Edit Project');
        $("#largeModal .modal-body").load('?project=edit');

        $("#largeModal").on("submit", "#project-edit-form", function(e){
            var post = $("#project-edit-form").serializeArray();
            project_form_submit('?project=edit', post);
            e.preventDefault();
            e.stopImmediatePropagation();
        });
    });

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
});