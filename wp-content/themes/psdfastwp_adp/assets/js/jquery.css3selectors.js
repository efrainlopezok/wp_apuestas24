(function($) {
    jQuery.fn.css3selectors = function(t,s){
        var e = jQuery(this);
        jQuery('input[type="text"]', e).addClass('type-text');
        jQuery('input[type="password"]', e).addClass('type-password');
        jQuery('input[type="reset"]', e).addClass('type-reset');
        jQuery('input[type="button"]', e).addClass('type-button');
        jQuery('input[type="submit"]', e).addClass('type-submit');
        jQuery('input[type="checkbox"]', e).addClass('type-checkbox');
        jQuery('input[type="radio"]', e).addClass('type-radio');
        jQuery('ul, ol', e).children(':last-child').addClass('last-child');
        jQuery('ul, ol', e).children(':first-child').addClass('first-child');
        jQuery('ul, ol', e).children(':nth-child(even)').addClass('nth-child-even');
        jQuery('ul, ol', e).children(':nth-child(odd)').addClass('nth-child-odd');
        jQuery('dl', e).children('dt:nth-child(even), dd:nth-child(even)').addClass('nth-child-even');
        jQuery('dl', e).children('dt:nth-child(odd), dd:nth-child(odd)').addClass('nth-child-odd');
        jQuery('dl', e).children('dt:first-child, dd:first-child').addClass('first-child');
        jQuery('dl', e).children('dt:last-child, dd:last-child').addClass('last-child');
        jQuery('tbody, thead, tfooter', e).children(':last-child').addClass('last-child');
        jQuery('tbody, thead, tfooter', e).children(':first-child').addClass('first-child');
        jQuery('tbody, thead, tfooter', e).children(':nth-child(even)').addClass('nth-child-even');
        jQuery('tbody, thead, tfooter', e).children(':nth-child(odd)').addClass('nth-child-odd');
        jQuery('div', e).children(':last-child').addClass('last-child');
        jQuery('div', e).children(':first-child').addClass('first-child');
        jQuery('div:empty, span:empty, p:empty', e).addClass('empty');

        if(t !== undefined && s !== undefined){
            s = (s + '').replace(' ','').split(',');
            for(x in s){
                jQuery(t).children(s[x] + ':last-child').addClass('last-child');
                jQuery(t).children(s[x] + ':first-child').addClass('first-child');
            }
        }

        return e;
    }

    jQuery.css3selectors = function(t,s){
        return jQuery(document).css3selectors(t,s);
    };
})(jQuery);