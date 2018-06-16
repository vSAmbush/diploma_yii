/**
 *  Main jQuery function
 */
$(document).ready(function () {

    //rotating gears
    var angle = 0;
    var angle_2 = 0;
    setInterval(function() {
        angle += 0.3;
        $('.gear-right').css({
            '-webkit-transform' : 'rotate(' + angle + 'deg)',
            '-moz-transform' : 'rotate(' + angle + 'deg)',
            '-ms-transform' : 'rotate(' + angle + 'deg)',
            'transform' : 'rotate(' + angle + 'deg)'
        });
        angle_2 -= 0.3
        $('.gear-left').css({
            '-webkit-transform' : 'rotate(' + angle_2 + 'deg)',
            '-moz-transform' : 'rotate(' + angle_2 + 'deg)',
            '-ms-transform' : 'rotate(' + angle_2 + 'deg)',
            'transform' : 'rotate(' + angle_2 + 'deg)'
        });
    }, 2);

    //Handling amount counter
    var count = [];
    var cost = [];
    var rowCount = $('#table_prod tr').length;
    for(var i = 0; i < rowCount; i++) {
        var temp = '#counter' + i;
        count[i] = $(temp).val();
    }
    for(var i = 0; i < rowCount; i++) {
        var temp = '#td_cost' + i;
        temp = $(temp).html();
        cost[i] = parseFloat(temp) / count[i];
    }

    var str = $('#total').html();
    if(str)
        str = str.replace('Total:', '');
    var total = parseFloat(str);

    //plussing items for adding to cart
    $('.counter-plus').click(function () {
       var ind = $(this).attr('id');
       ind = ind.replace('counter-plus', '');
       count[ind]++;
       var temp = '#counter' + ind;
       $(temp).val(count[ind]);
       temp = '#td_cost' + ind;
       $(temp).html(cost[ind] * count[ind] + " $");
       total += cost[ind];
       $('#total').html("Total: " + total + " $");
    });

    //subtracting items for adding to cart
    $('.counter-minus').click(function () {
        var ind = $(this).attr('id');
        ind = ind.replace('counter-minus', '');
        if(count[ind] > 1) {
            total -= cost[ind];
            $('#total').html("Total: " + total + " $");
        }
        count[ind]--;
        if(count[ind] <= 1)
            count[ind] = 1;
        var temp = '#counter' + ind;
        $(temp).val(count[ind]);
        temp = '#td_cost' + ind;
        $(temp).html(cost[ind] * count[ind] + " $");
    });

    //display purchase tables
    $('.shower').click(function () {
       var ind = $(this).attr('id');
       ind = ind.replace('display', '');
       var temp = '#tab_display' + ind;
       $(temp).toggleClass('d-none');
       $(this).toggleClass('active');
    });

    //accept purchase item
    $('.checker').click(function () {
        var ind = $(this).attr('id');
        ind = ind.replace('check', '');
        var temp = '#item' + ind;
        $(temp).removeClass('bg-danger');
        $(temp).addClass('bg-success');
    });

    //decline purchase item
    $('.decliner').click(function () {
        var ind = $(this).attr('id');
        ind = ind.replace('decline', '');
        var temp = '#item' + ind;
        $(temp).removeClass('bg-success');
        $(temp).addClass('bg-danger');
    });
});