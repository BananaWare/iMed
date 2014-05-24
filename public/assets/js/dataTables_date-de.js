/*jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "de_datetime-asc": function ( a, b ) {
        var x, y;
        if ($.trim(a) !== '') {
            var deDatea = $.trim(a).split(' ');
            var deTimea = deDatea[1].split(':');
            var deDatea2 = deDatea[0].split('.');
            x = (deDatea2[2] + deDatea2[1] + deDatea2[0] + deTimea[0] + deTimea[1]) * 1;
        } else {
            x = Infinity; // = l'an 1000 ...
        }
 
        if ($.trim(b) !== '') {
            var deDateb = $.trim(b).split(' ');
            var deTimeb = deDateb[1].split(':');
            deDateb = deDateb[0].split('.');
            y = (deDateb[2] + deDateb[1] + deDateb[0] + deTimeb[0] + deTimeb[1]) * 1;
        } else {
            y = Infinity;
        }
        var z = ((x < y) ? -1 : ((x > y) ? 1 : 0));
        return z;
    },
 
    "de_datetime-desc": function ( a, b ) {
        var x, y;
        if ($.trim(a) !== '') {
            var deDatea = $.trim(a).split(' ');
            var deTimea = deDatea[1].split(':');
            var deDatea2 = deDatea[0].split('.');
            x = (deDatea2[2] + deDatea2[1] + deDatea2[0] + deTimea[0] + deTimea[1]) * 1;
        } else {
            x = Infinity;
        }
 
        if ($.trim(b) !== '') {
            var deDateb = $.trim(b).split(' ');
            var deTimeb = deDateb[1].split(':');
            deDateb = deDateb[0].split('.');
            y = (deDateb[2] + deDateb[1] + deDateb[0] + deTimeb[0] + deTimeb[1]) * 1;
        } else {
            y = Infinity;
        }
        var z = ((x < y) ? 1 : ((x > y) ? -1 : 0));
        return z;
    }
} );
*/
$.extend(jQuery.fn.dataTableExt.oSort, {
    "datetime-au-pre": function (a) {
        var x;
        if ($.trim(a) != '') {
            var frDatea = $.trim(a).split(' ');
            var frTimea = frDatea[1].split(':');
            var frDatea2 = frDatea[0].split('/');
            var year = frDatea2[2];
            var month = frDatea2[1];
            var day = frDatea2[0];
            var hour = frTimea[0];
            var minute = frTimea[1];
            var second = frTimea[2];
            var ampm = frDatea[2];
 
            if (day < 10) {
                day = '0' + day;
            }
 
            if (ampm == 'PM' && hour < 12) {
                hour = parseInt(hour, 10) + 12;
            }
 
            if (hour < 10) {
                hour = '0' + hour;
            }
 
            x = (year + month + day + hour + minute + second) * 1;
        } else {
            x = 10000000000000;
        }
 
        return x;
    },
 
    "datetime-au-asc": function (a, b) {
        return a - b;
    },
 
    "datetime-au-desc": function (a, b) {
        return b - a;
    }
});