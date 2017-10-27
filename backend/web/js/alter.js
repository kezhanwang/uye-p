function alert(msg, title, callback) {
    if (!title) {
        title = '提示';
    }
    var dialogHTML = '<div id="selfAlert" class="modal fade bs-example-modal-sm" style="padding-top: 300px;">';
    dialogHTML += '<div class="modal-dialog modal-sm" style="width: 300px; height: 200px">';
    dialogHTML += '<div class="modal-content">';
    dialogHTML += '<div class="modal-header">';
    dialogHTML += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    dialogHTML += '<span aria-hidden="true">&times;</span>';
    dialogHTML += '</button>';
    dialogHTML += '<h4 class="modal-title">' + title + '</h4>';
    dialogHTML += '</div>';
    dialogHTML += '<div class="modal-body">';
    dialogHTML += '<p style="text-align: center">' + msg + '</p>';
    dialogHTML += '</div>';
    dialogHTML += '<div class="modal-footer">';
    dialogHTML += '<button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>';
    dialogHTML += '</div>';
    dialogHTML += '</div>';
    dialogHTML += '</div>';
    dialogHTML += '</div>';

    if ($('#selfAlert').length <= 0) {
        $('body').append(dialogHTML);
    }

    $('#selfAlert').on('hidden.bs.modal', function () {
        $('#selfAlert').remove();
        if (typeof callback == 'function') {
            callback();
        }
    }).modal('show');
}


$("body").append("<!-- loading -->" +
    "<div class='modal fade' id='loading' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' data-backdrop='static'>" +
    "<div class='modal-dialog' role='document'>" +
    "<div class='modal-content'>" +
    "<div class='modal-header'>" +
    "<h4 class='modal-title' id='myModalLabel'>提示</h4>" +
    "</div>" +
    "<div id='loadingText' class='modal-body'>" +
    "<span class='glyphicon glyphicon-refresh' aria-hidden='true'>1</span>" +
    "处理中，请稍候。。。" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>"
);


function showLoading(text) {
    $("#loadingText").html(text);
    $("#loading").modal("show");
}

function hideLoading() {
    $("#loading").modal("hide");
}