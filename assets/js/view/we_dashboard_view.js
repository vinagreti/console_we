function we_dashboard_view() {

    var self = this;

    // lista os canais em uma tabela
    self.plotarGraficoDiario = function( chart, resumo ){

        var dias = [];
        var totais= [];

        var totalChart = 0;

        $.each( resumo, function( dia, total ){
            totalChart +=total;
            dias.push(dia);
            totais.push(total);
        });

        if( dias.length == 1 ){

            dias.unshift(0);

            totais.unshift(0);

        }

        $("#daily-"+chart+"-total").html( totalChart );

        var data = {
            labels: dias,
            datasets: [{
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                data: totais
            }]
        }

        var options = {
            animation : true,
            sliceVisibilityThreshold : 0
        };

        //Get the context of the canvas element we want to select
        var c = $('#daily-'+chart+'-chart');
        var ct = c.get(0).getContext('2d');
    /*************************************************************************/

    //Run function when window resizes
        $(window).resize(respondCanvas);

        function respondCanvas() {
            c.attr('width', jQuery('#daily-'+chart).width());
            c.attr('height', jQuery('#daily-'+chart).height());
            //Call a function to redraw other content (texts, images etc)
            myNewChart = new Chart(ct).Line(data, options);
        }

        //Initial call 
        respondCanvas();

    };

};
