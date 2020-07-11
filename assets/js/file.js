$(document).ready(() => {

    /**
     * PHP htmlspecialchars equivalent.
     * @param text 
     */
    function escapeHTML(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    /**
     * Removes the 'is-invalid' class and adds the 'is-valid' class.
     * @param target
     */
    function val(target) {
        $(target).hasClass('is-invalid') ? $(target).removeClass('is-invalid') : null;
        $(target).addClass('is-valid');
    }

    /**
     * Removes the 'is-valid' class and adds the 'is-invalid' class.
     * @param target 
     */
    function inval(target) {
        $(target).hasClass('is-valid') ? $(target).removeClass('is-valid') : null;
        $(target).addClass('is-invalid');
    }

    // JavaScript equivalents of the Validate class functions.
    function vSpec(input, len) {
        if (encodeURI(input).match(/[^a-zA-Z0-9]+/) || input === "" || input.length != len) {
            return false;
        } else {
            return true;
        }
    }

    function vMax(input, len, space = false) {
        let match;
        (space) ? match = /[^\w\s]+/: match = /[^\w]+/

        if (escapeHTML(input).match(match) || input === "" || input.length > len) { // escapeHTML fixes issues with spaces.
            return false;
        } else {
            return true;
        }
    }

    function vMinMax(input, minlen, maxlen) {
        if (encodeURI(input).match(/[^a-zA-Z0-9]+/) || input === "" || input.length < minlen || input.length > maxlen) {
            return false;
        } else {
            return true;
        }
    }


    $('input').keyup(({ target }) => {
        switch (target.name) {
            case 'Callsign':
                !vMax(target.value, 10) ? inval(target) : val(target);
                break;
            case 'Aircraft':
                !vMinMax(target.value, 2, 4) ? inval(target) : val(target);
                break;
            case 'Departure_ICAO':
                !vSpec(target.value, 4) ? inval(target) : val(target);
                break;
            case 'Arrival_ICAO':
                !vSpec(target.value, 4) ? inval(target) : val(target);
                break;
            case 'Altitude':
                !vMax(target.value, 5) ? inval(target) : val(target);
                break;
            case 'Route':
                !vMax(target.value, 100, true) ? inval(target) : val(target);
                break;
            case 'Remarks':
                !vMax(target.value, 20, true) ? null : val(target);
                break;
        }
    });

});