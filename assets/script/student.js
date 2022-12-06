$(document).ready(function() {
    $('#material-tabs').each(function() {
        var $active, $content, $links = $(this).find('a');
        var tab = sessionStorage.getItem("tab");
        if(tab!=null){
            if(tab=="tab2-tab"){
                $active = $($links[1]);
            }else{
                $active = $($links[0]);
            }
        }else{
            $active = $($links[0]);
        }
        $active.addClass('active');

        $content = $($active[0].hash);

        $links.not($active).each(function() {
            $(this.hash).hide();
        });

        $(this).on('click', 'a', function(e) {
            sessionStorage.setItem("tab", e.target.id);
            $active.removeClass('active');
            $content.hide();

            $active = $(this);
            $content = $(this.hash);

            $active.addClass('active');
            $content.show();

            e.preventDefault();
        });
    });
});