$(document).ready(function () {

    load("");

    function load(value) {
        $('#tablelist').load("fetch-right.php");
        $('#load_strips').load(`fetch-left.php?search=${value}`);
    }

    $('#search').keyup(function () {
        var search = $(this).val();
        load(search);
    });

    setInterval(function () {
        load($('#search').val());
    }, 8000);

    $('#squawkModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var plan_id = button.data('id');
        var squawk = button.data('squawk');
        var modal = $(this)
        modal.find('.modal-body #plan_id').val(plan_id);
        modal.find('.modal-body #code').val(squawk);
    });

});