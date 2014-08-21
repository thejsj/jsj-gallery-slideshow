(function ($) {
    'use strict';

    // Ovewrite our tmpl function, because, by default it uses the key to an attribute as the default for a falsy attribute
    $.extend($.fn.cycle.API, {
        tmpl: function( str, opts /*, ... */) {
            var regex = new RegExp( opts.tmplRegex || $.fn.cycle.defaults.tmplRegex, 'g' );
            var args = $.makeArray( arguments );
            args.shift();
            return str.replace(regex, function(_, str) {
                var i, j, obj, prop, names = str.split('.');
                for (i=0; i < args.length; i++) {
                    obj = args[i];
                    if ( ! obj )
                        continue;
                    if (names.length > 1) {
                        prop = obj;
                        for (j=0; j < names.length; j++) {
                            obj = prop;
                            prop = prop[ names[j] ] || ''; /* ONLY MODIFIED LINE */
                        }
                    } else {
                        prop = obj[str];
                    }

                    if ($.isFunction(prop))
                        return prop.apply(obj, args);
                    if (prop !== undefined && prop !== null && prop != str)
                        return prop;
                }
                return str;
            });
        }
    });

    $.extend($.fn.cycle.API, {
        getComponent: function( name ) {
            var opts = this.opts();
            var selector = opts[name];
            if (typeof selector === 'string') {
                // if selector is a child, sibling combinator, adjancent selector then use find, otherwise query full dom
                return (/^\s*[\>|\+|~]/).test( selector ) ? opts.container.parent().find( selector ) : $( selector );
            }
            if (selector.jquery)
                return selector;
            
            return $(selector);
        },
    })

}(window.jQuery));