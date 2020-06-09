$(document).ready(() => {
    $('#airModal-button').click(() => {
        $('#airModal-body').load('/scripts/airinfoscript.php', (response, status, xhr) => {
            if (status == "error") {
                $('#airModal-body').html(`Error: ${xhr.status}`);
            }
        });
    });

    $('#changeButton').click(() => {
        let input = $('#changeAirport').val().toUpperCase();
        $.post('/scripts/airinfoscript.php', { icao: input })
            .done(() => {
                alert("Airport changed successfully!");
                $('#airModal-button')[0].innerText = input;
                $('.modal-title')[0].innerText = `${input} Information`;
                $('#changeAirport').val('');
                $('#airDrop').dropdown('hide');
            })
            .fail((reason) => { alert(`Airport not changed! ${reason.responseText}`) });
    });

    $(() => {
        $('[data-toggle="tooltip"]').tooltip();
    });
});