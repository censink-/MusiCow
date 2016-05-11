$(init);

function init() {
    getNewRecords();
    setInterval(getNewRecords, 1000);
    $('#groupinput').on('keyup', getNewRecords);
}

function addPanel() {

}

var newitem;
function getNewRecords() {
    $.ajax({
        dataType: "json",
        url: "api.php",
        data: {
            action: "getnewrecords",
            group: groupid
        },
        success: addNewRecords
    })
}

function addNewRecords(data) {
    if (data.code == 200) {
        $.each(data.records, function (i, result) {
            if (!$('#recordpanels').find('#recordpanel-' + result.id).length) {
                newitem = $('<div>')
                    .addClass('panel panel-default')
                    .attr('id', 'recordpanel-' + result.id)
                    .append($('<div>')
                        .addClass('panel-heading')
                        .append($('<h4>')
                            .addClass('panel-title')
                            .append($('<a>')
                                .attr('data-toggle', 'collapse')
                                .attr('data-parent', '#recordpanels')
                                .attr('href', '#collapserecord-' + result.id)
                                .text("Sound " + result.sound + " at " + result.datetime)
                                .append($('<span>')
                                    .addClass('pull-right')
                                    .text('#' + result.id)
                            )
                        )
                    )
                )
                    .append($('<div>')
                        .addClass('panel-collapse collapse')
                        .attr('id', 'collapserecord-' + result.id)
                        .append($('<div>')
                            .addClass('panel-body')
                            .attr('id', 'record-mice-' + result.id)
                    )
                        .append($('<div>')
                            .addClass('panel-footer')
                            .append($('<a>')
                                .addClass('btn btn-danger btn-mouse')
                                .attr('data-mouse', '0')
                                .attr('data-entry', result.id)
                                .text('Invalid click / Don\'t know')

                        )
                            .append($('<form>')
                                .attr('data-entry', result.id)
                                .attr('id', 'form-mice-' + result.id)
                                .addClass('form-mice pull-right')
                                .append($('<input>')
                                    .attr('type', 'submit')
                                    .addClass('btn btn-success')
                            )
                        )
                    )
                );
                $('#recordpanels').append(newitem);
                console.log("Added panel for record #" + result.id);

                insertMice(result.id);
            }
        });
        //hideError();
    } else if (data.code == 204) {
        //displayError(data.code, "No new records for group " + groupid);
    } else {
        //displayError(data.code, data.error);
    }
}

function insertMice(panel) {
    console.log("Filling panel " + panel + " with mice");
    $.each(mice, function(i, result) {
        $('#record-mice-' + panel).append($('<div>')
            .addClass('col-sm-2')
            .append($('<div>')
                .addClass('thumbnail btn-mouse mouse-thumbnail')
                .attr('data-mouse', result.id)
                .attr('data-entry', panel)
                .append($("<img>")
                    .attr('src', result.image)
                    .attr('alt', result.name)
                )
                .append($('<div>')
                    .addClass('text-center')
                    .text(result.name)
                )
            )
        );
    });
    $('#form-mice-' + panel).prepend($('<input>')
            .attr('type', 'text')
            .attr('id', 'input-mouse-' + panel)
            .addClass('hidden')
    );
    $('.btn-mouse').on('click', selectMouse);
    $('.form-mice').on('submit', submitMouse);
}

function selectMouse() {
    console.log("Selected mouse #" + $(this).attr('data-mouse') + ' for entry #' + $(this).attr('data-entry'));
    $('#input-mouse-' + $(this).attr('data-entry')).val($(this).attr('data-mouse'));
    $('#collapserecord-' + $(this).attr('data-entry')).find('.btn-mouse').removeClass('mouse-selected');
    $(this).addClass('mouse-selected');
}

var entry = 0;
function submitMouse(e) {
    event.preventDefault();
    entry = $(this).attr('data-entry');
    var mouse = $('#input-mouse-' + $(this).attr('data-entry')).val();
    console.log('submit!');
    console.log('Entry ' + entry + ' submits with mouse #' + mouse);
    if (mouse == "") {
        alert("Click a mouse first!");
    } else {
        $.ajax({
            dataType: "json",
            url: "api.php",
            data: {
                action: "settestsubject",
                id: entry,
                testsubject: mouse
            },
            success: removeRecord
        })
    }

}

function removeRecord(data) {
    console.log(data);
    console.log(entry);
    $('#recordpanel-' + entry).slideUp(300);
}

var created = false;
/*function displayError(code, error) {
    if (groupid != "") {
        if (created == false) {
            var alertbox = $('<div>')
                .addClass('alert alert-danger fade')
                .attr('id', 'alertbox')
                .append($('<span>')
                    .addClass('close')
                    .html('&times;')
            )
                .append($('<strong>'))
                .append($('<p>'));
            $("body").append(alertbox);
            created = true;
            $('#alertbox').find(".close").on("click", hideError);
        }
        $('#alertbox').find("p").text(error);
        if (code == 204) {
            $('#alertbox').attr("class", "alert alert-warning fade in");
            $('#alertbox').find("strong").text("Warning:");
        } else if (groupid != "") {
            $('#alertbox').attr("class", "alert alert-danger fade in");
            $('#alertbox').find("strong").text("Error " + code + ":");
        }
        console.warn("Code " + code + ": " + error);
    } else {
        hideError();
    }
}

function hideError() {
    $('#alertbox').attr("class", "alert fade");
}

///just some filthy markup

<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#panels" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Collapsible Group Item #1
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
        </div>
    </div>
</div>

<div id="alertbox" class="alert alert-danger fade">
    <span class="close">&times;</span>
    <strong>Error #:</strong>
    <p>Shit</p>
</div>
*/