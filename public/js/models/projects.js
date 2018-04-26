var Project = function() {
    $('#project-form').on('submit', function (e) {
        e.preventDefault();
        $form = $(this);
        $projectHolder = $('#project-holder');
        console.log("Submitting..");

        $.ajax({
            type: 'POST',
            url: '/api/projects',
            data: $form.serialize(),
            success: function (project) {
                // var project = JSON.parse(project);
                console.log("Success");
                console.log(project);
                $templateCopy = $('#project-template').clone();
                $templateCopy.removeClass('hidden');
                $templateCopy.find('.name').first().html(project.name);
                $templateCopy.find('.timestamp').first().html(project.created_at);
                $projectHolder.append($templateCopy);                    
            }
        });
    });
}

$(function() {
    Project();
});