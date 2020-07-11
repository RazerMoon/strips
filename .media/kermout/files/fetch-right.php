
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<!-- Tooltips-->
<script>
    $(document).ready(function() {
        $('.tooltip').remove();
        $('[data-toggle="tip"]').tooltip('enable');
    });
</script>


<!-- Live Edit Snippet -->
<script type="text/javascript">
    $(document).ready(function() {

        // Add Class
        $('.edit').click(function(e) {

            e.preventDefault();

            $(this).addClass('editMode');
        });

        // Save data
        $(".edit").focusout(function(e) {

            e.preventDefault();

            $(this).removeClass("editMode");
            var id = this.id;
            var split_id = id.split("/");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).text();

            jQuery.ajax({
                type: 'POST',
                url: 'update.php',
                data: {
                    field: field_name,
                    value: value,
                    id: edit_id,
                },
                dataType: "text",
                success: function(data) {
                    location.reload();
                },
                error(data) {
                    alert("Error");
                }
            });

        });

    });
</script>


