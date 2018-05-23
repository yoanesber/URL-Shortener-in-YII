$(function () {
    $('#task_start_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: 'id'
    });
    $('#task_end_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: 'id'
    });
});

function setTodolistStatus(){
    $.ajax({
        type: "GET",
        url: "/statustodolists",
        dataType: "json",
        success: function(response, status) {
            if(response && !response.error && response.data.length > 0){
                var select = document.getElementById('task_status');
                for (var i = 0; i<=response.data.length; i++){
                    var opt = document.createElement('option');
                    opt.value = response.data[i].id;
                    opt.innerHTML = response.data[i].status_name;
                    select.appendChild(opt);
                }
            }
        },
        error: function (response, status) {
            alert("Error when get statustodolists!");
        },
    });
}
setTodolistStatus();

$("#row-form-todo-list").css("display", "none");

$("#btn-cancel-form-todo-list").on("click", function(){
    $("#todolist-form")[0].reset();
    $("#row-form-todo-list").css("display", "none");
    $("#row-table-todo-list").css("display", "block");
});

$("#btn-add-form-todo-list").on("click", function(){
    $("#row-table-todo-list").css("display", "none");
    $("#row-form-todo-list").css("display", "block");

    $("#field-task-status").css("display", "none");

    $("#btn-save-form-todo-list").css("display", "Inline ");
    $("#btn-update-form-todo-list").css("display", "none");

    $("#btn-save-form-todo-list").on("click", function(){
        var task_name = ($("#task_name").val() && $("#task_name").val() !== undefined)? $("#task_name").val(): null;
        var task_desc = ($("#task_desc").val() && $("#task_desc").val() !== undefined)? $("#task_desc").val(): null;
        var task_start_date = ($("#task_start_date").val() && $("#task_start_date").val() !== undefined)? $("#task_start_date").val(): null;
        var task_end_date = ($("#task_end_date").val() && $("#task_end_date").val() !== undefined)? $("#task_end_date").val(): null;
        var task_place = ($("#task_place").val() && $("#task_place").val() !== undefined)? $("#task_place").val(): null;
        
        var form_submit = false;
        if(task_name != null && task_start_date != null && task_end_date != null)
            form_submit = true;
        
        if(form_submit){
            $.ajax({
                type: "POST",
                url: "/site",
                data: {task_name: task_name, task_desc: task_desc, task_start_date: task_start_date, task_end_date: task_end_date, task_place: task_place},
                dataType: "json",
                success: function(response, status) {
                    if(response && !response.error){
                        location.reload();
                    }
                },
                error: function (response, status) {
                    alert("Error when post todolists!");
                },
            });
        }
        else {
            if(task_name == null)
                $("#task_name").parent().addClass("has-error");
            
            if(task_start_date == null)
                $("#task_start_date").parent().addClass("has-error");
            
            if(task_end_date == null)
                $("#task_end_date").parent().addClass("has-error");
            
            $("#alert").removeClass("alert-info").addClass("alert-danger");
            $("#alert").html("Please fill all requirement fields");
        }
    });
});

function editTask(task_id){
    $("#row-table-todo-list").css("display", "none");
    $("#row-form-todo-list").css("display", "block");

    $("#field-task-status").css("display", "block");

    $("#btn-save-form-todo-list").css("display", "none");
    $("#btn-update-form-todo-list").css("display", "Inline ");

    $.ajax({
        type: "GET",
        url: "/site/" + task_id,
        dataType: "json",
        success: function(response, status) {
            if(response && !response.error && response.data.length > 0){
                $("#task_name").val(response.data[0].task_name);
                $("#task_desc").val(response.data[0].task_desc);
                $("#task_start_date").val(response.data[0].task_start_date);
                $("#task_end_date").val(response.data[0].task_end_date);
                $("#task_place").val(response.data[0].task_place);
                $("#task_status").val(response.data[0].status_id);
            }
        },
        error: function (response, status) {
            alert("Error when get todolists!");
        },
    });

    $("#btn-update-form-todo-list").on("click", function(){
        var task_name = ($("#task_name").val() && $("#task_name").val() !== undefined)? $("#task_name").val(): null;
        var task_desc = ($("#task_desc").val() && $("#task_desc").val() !== undefined)? $("#task_desc").val(): null;
        var task_start_date = ($("#task_start_date").val() && $("#task_start_date").val() !== undefined)? $("#task_start_date").val(): null;
        var task_end_date = ($("#task_end_date").val() && $("#task_end_date").val() !== undefined)? $("#task_end_date").val(): null;
        var task_place = ($("#task_place").val() && $("#task_place").val() !== undefined)? $("#task_place").val(): null;
        var task_status = ($("#task_status").val() && $("#task_status").val() !== undefined)? $("#task_status").val(): null;

        var form_submit = false;
        if(task_name != null && task_start_date != null && task_end_date != null)
            form_submit = true;
        
        if(form_submit){
            $.ajax({
                type: "PUT",
                url: "/site/" + task_id,
                data: {task_name: task_name, task_desc: task_desc, task_start_date: task_start_date, task_end_date: task_end_date, task_place: task_place, task_status: task_status},
                dataType: "json",
                success: function(response, status) {
                    if(response && !response.error){
                        location.reload();
                    }
                },
                error: function (response, status) {
                    alert("Error when put todolists!");
                },
            });
        }
        else {
            if(task_name == null)
                $("#task_name").parent().addClass("has-error");
           
            if(task_start_date == null)
                $("#task_start_date").parent().addClass("has-error");
            
            if(task_end_date == null)
                $("#task_end_date").parent().addClass("has-error");

            $("#alert").removeClass("alert-info").addClass("alert-danger");
            $("#alert").html("Please fill all requirement fields");
        }
    });
}

function deleteTask(task_id){
    $('#modal-form-todolist').modal('show');

    $("#btn-delete-todo-list").on('click', function(){
        $.ajax({
            type: "DELETE",
            url: "/site/" + task_id,
            dataType: "json",
            success: function(response, status) {
                if(response && !response.error && response.data.length > 0){
                    location.reload();
                }
            },
            error: function (response, status) {
                alert("Error when delete todolists!");
            },
        });
    });
}

$("#btn-cancel2-delete-todo-list").on("click", function(){
    location.reload();
});

$("#btn-cancel-delete-todo-list").on("click", function(){
    location.reload();
});

$("#btn-cancel-form-todo-list").on("click", function(){
    location.reload();
});