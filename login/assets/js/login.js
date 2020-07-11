$(document).ready(() => {

    function val(target) {
        $(target).hasClass('is-invalid') ? $(target).removeClass('is-invalid') : null;
        $(target).addClass('is-valid');
    }

    function inval(target) {
        $(target).hasClass('is-valid') ? $(target).removeClass('is-valid') : null;
        $(target).addClass('is-invalid');
    }

    function vSpec(input, len) {
        if (encodeURI(input).match(/[^a-zA-Z0-9]+/) || input === "" || input.length != len) {
            return false;
        } else {
            return true;
        }
    }

    $('input').keyup(({ target }) => {
        switch (target.name) {
            case 'Airport_ICAO':
                !vSpec(target.value, 4) ? inval(target) : val(target);
                break;
        }
    });
});