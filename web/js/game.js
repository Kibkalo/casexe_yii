/**
 * Created by Френки on 12.01.19.
 */

$( "button[name='startGame']" ).click(
    function()
    {
        var gameId = this.getAttribute('id');

        $.ajax(
            {
                url: 'index.php?r=game/play',
                data: {id: gameId},
                type: 'POST',
                success: function(res)
                {
                    location.reload();
                },
                error: function(er)
                {
                    alert(er);
                }
            }
        );
    }
);

$( "button[name='sellItem']" ).click(
    function()
    {
        var gameId = this.getAttribute('id');

        $.ajax(
            {
                url: 'index.php?r=game/sell',
                data: {id: gameId},
                type: 'POST',
                success: function(res)
                {
                    //alert(res);
                    location.reload();
                },
                error: function(er)
                {
                    alert(er);
                }
            }
        );
    }
);