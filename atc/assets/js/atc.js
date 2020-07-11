$(document).ready(() => {

    // Work on this tooltip code.
    let active = 0;

    $(document).on('mouseenter', '[data-toggle="tip"]', ({ target }) => {
        if (active == 0) {
            active = 1;
            $(target).tooltip('show');
        }
    });

    $(document).on('mouseleave', '[data-toggle="tip"]', ({ target }) => {
        active = 0;
        $('.tooltip').remove();
    });

    load("");

    function load(value) {
        //$('#tablelist').load("fetch-right.php");
        $('#load-strips').load(`/scripts/fetch-left.php?search=${value}`);
    }

    setInterval(() => {
        load(encodeURI($('#search').val()));
    }, 8000);

    /*

    $('#search').keyup(() => {
        var search = $(this).val();
        load(search);
    });

    $('#squawkModal').on('show.bs.modal', (event) => {
        var button = $(event.relatedTarget)
        var plan_id = button.data('id');
        var squawk = button.data('squawk');
        var modal = $(this)
        modal.find('.modal-body #plan_id').val(plan_id);
        modal.find('.modal-body #code').val(squawk);
    });

    */

    $('#airModal-button').click(() => {
        $('#airModal-body').load('/scripts/airinfoscript.php', (response, status, xhr) => {
            if (status == "error") {
                $('#airModal-body').html(`Error: ${xhr.status}`);
            }
        });
    });

    $('#changeButton').click(() => {
        let input = encodeURI($('#changeAirport').val());
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