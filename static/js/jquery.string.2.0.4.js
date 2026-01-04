/* jQueryString v2.0.4
 By James Campbell
 */
(function($){
	$.jQueryString = {Version:"2.0.4", Defaults:{
            URL: location.href,
			Unescape: true,
            onStart: function(Option){
            },
            onError: function(Option){
            },
            onSuccess: function(Option, Result){
            },
            callback: function(Option, Result){
            }
        }, getDefaults: function(){
		return $.extend(this.Defaults, {URL: location.href});
	}};
    $.unserialise = function(Data, Unescape){
        var Data = Data.split("&");
        var Serialised = {};
        $.each(Data, function(){
            var Properties = this.split("=");
            Serialised[Properties[0]] = (Unescape)?unescape(Properties[1]):Properties[1];
        });
        return Serialised;
    };
    $.getAllQueryStrings = function(Option){
        Option = $.extend($.jQueryString.getDefaults(), Option);
		var Result = {};
        try {
            var QS = Option.URL.split("?")[1].split("#")[0];
        } 
        catch (e) {
			Option.callback(Option, Result);
			return Result;
        }
        Result = $.unserialise(QS, Option.Unescape);
        Option.callback(Option, Result);
        return Result;
    }
    $.QueryStringExist = function(Option){
        Option = $.extend($.jQueryString.getDefaults(), Option);
        var Result = (typeof($.getAllQueryStrings({
            URL: Option.URL
        })[Option.ID]) !=
        "undefined");
        Option.callback(Option, Result);
        return Result;
    }
    $.getQueryString = function(Option){
        Option = $.extend($.jQueryString.getDefaults(), Option);
        var Result = Option.DefaultValue;
        Option.onStart(Option);
        if ($.QueryStringExist({
            ID: Option.ID,
            URL: Option.URL
        })) {
            Result = $.getAllQueryStrings({
                URL: Option.URL
            })[Option.ID];
            Option.onSuccess(Option, Result);
        }
        else {
            Option.onError(Option);
        };
        Option.callback(Option, Result);
        return Result;
    };
})(jQuery);

