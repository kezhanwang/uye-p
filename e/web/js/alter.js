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