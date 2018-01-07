</body>
<script>

    $(document).ready(function() {

        $('a').click(function() {
           var data = $(this).data('attr');
            $.ajax({
                url: "request.php",
                type: "post",
                data: data,
                success: function (data) {
                    var obj = jQuery.parseJSON( data );
                    var i = 0;
                    $("tbody tr").each(function(){
                        $("th",this).each(function(){
                             cur = $(this).data('attr');
                            $(this).html((obj[i][cur]));
                        });
                        i++;
                    });
                }
            });
        });
    });

</script>
</html>