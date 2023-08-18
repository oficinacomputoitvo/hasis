
function customAlert(msg) {
    var m = document.getElementById('alert-message');
    m.textContent = String(msg);

    var me = document.getElementById('alertWindow');
    var alertModal = new bootstrap.Modal(me, {
        keyboard: false,
        backdrop: 'static'
    });
    alertModal.show();
}

(function(proxied) {
    window.alert = function() {
        return proxied.apply(this, arguments);
    };
})(customAlert);
