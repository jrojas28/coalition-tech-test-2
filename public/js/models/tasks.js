var Task = function() {
    $('#project-selector').on('change', function(e) {
        var projectId = $(this).val();
        //Update the tasks:
        var getUrl = projectId != 0 ? 'api/projects/' + projectId + '/tasks' : 'api/tasks';
        $.ajax({
            method: 'GET',
            url: getUrl,
            success: function(tasks) {
                var $taskHolder = $('#task-holder');
                $taskHolder.html('');
                for(i = 0; i < tasks.length; i++) {
                    $templateCopy = $('#task-template').clone();
                    $templateCopy.removeClass('hidden');
                    $templateCopy.find('.name').first().html(tasks[i].name);
                    $templateCopy.find('.priority').first().html(projectId != 0 ? tasks[i].project_priority : tasks[i].priority);
                    $templateCopy.find('.project').first().html(tasks[i].project_name);
                    $templateCopy.find('.timestamp').first().html(tasks[i].created_at);
                    $templateCopy.data('id', tasks[i].id);
                    $templateCopy.data('priority', tasks[i].priority);
                    $templateCopy.data('project-priority', tasks[i].project_priority);
                    $taskHolder.append($templateCopy);
                }
            }
        })
    });

    $('#task-form').on('submit', function (e) {
        e.preventDefault();
        $form = $(this);
        $taskHolder = $('#task-holder');
        console.log("Submitting..");

        $.ajax({
            type: 'POST',
            url: '/api/tasks',
            data: $form.serialize(),
            success: function (task) {
                // var task = JSON.parse(task);
                console.log("Success");
                $templateCopy = $('#task-template').clone();
                $templateCopy.removeClass('hidden');
                $templateCopy.find('.name').first().html(task.name);
                $templateCopy.find('.priority').first().html(task.priority);
                $templateCopy.find('.project').first().html(typeof task.project_name !== 'undefined' ? task.project_name : "None");
                $templateCopy.find('.timestamp').first().html(task.created_at);
                if($('#project-selector').val() == 0 || $("#project-selector").val() == $task.project_id)
                $taskHolder.append($templateCopy);
            }
        });
    });

    $('#task-holder').sortable({
        stop: function (event, ui) {
            var data = {};
            data.ids = [];
            data.project = $('#project-selector').val();
            $('#task-holder').find('.task').each(function (idx, elem) {
                data.ids.push($(elem).data('id'));
            });
            console.log(data);
            $('#res').text(JSON.stringify(data));
            $.ajax({
                type: 'POST',
                url: '/api/tasks/update', 
                data: data,
                success: function (priorities) {
                    $('.task').each(function (index, elem) {
                        if($('#project-selector').val() != 0) {
                            $(elem).data('priority', priorities[index]);
                        }
                        else {
                            $(elem).data('project-priority', priorities[index]);
                        }
                        $(elem).find('.priority').html(priorities[index]);
                        
                    });
                }
            });
            // AJAX CALL TO UPDATE ALL PRIOS GO HERE.
        }
    });
}

$(function() {
    Task();
});