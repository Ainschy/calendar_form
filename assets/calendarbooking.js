/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   calendar_form
 * @author    Oliver Willmes
 * @license   GNU/LGPL
 * @copyright Oliver Willmes 2017
 */
function calendarbooking(option) {

    var url = option.setUrl;
    var calTemp = $(option.calTemp).html();
    var resTemp = $(option.resTemp).html();
    var setReload = option.setReload;
    var sheet = option.sheet;
    var resList = option.resList;
    var bookable = option.bookable;
    var selected = option.selector;
    var baseData = {
        'rt': option.rt,
        'ft': option.ft
    };

    Mustache.tags = ['<%', '%>'];

    $(function () {
        var sendAction = {
            'action': 'initialLoad'
        };
        sendAjax(sendAction);
        loadReservations();
    });
    function reloadAfterAdd() {
        var sendAction = {
            'action': 'initialLoad'
        };
        sendAjax(sendAction);
        $(resList).empty();
        loadReservations();
    }

    function sendAjax(sa) {
        var sendAction = $.extend(sa, baseData);
        $.ajax({
            type: "post",
            url: url,
            data: sendAction,
            success: function (response) {
                var rendered = Mustache.render(calTemp, response);
                $(sheet).html(rendered);
            },
            error: function (xhr, error) {
                console.log('Error', error);
                console.log('XHR', xhr);
            }
        });
    }

    function loadReservations() {
        var sa = {
            'action': 'loadReservations'
        };
        var sendAction = $.extend(sa, baseData);
        $.ajax({
            type: "post",
            url: url,
            data: sendAction,
            success: function (response) {
                $.each(response, function (i, data) {
                    appendReservation(data);
                });
            },
            error: function (xhr, error) {
                console.log('Error', error);
                console.log('XHR', xhr);
                //location.reload();
            }
        });
    }

    function appendReservation(response) {
        $(resList).find("[data-id='" + response.id + "']").remove();
        $(resList).append(Mustache.render(resTemp, response));
        $(resList + ' li').sort(function (a, b) {
            return $(a).data('id') > $(b).data('id');
        }).appendTo(resList);
    }

    $(sheet).on("touchstart click", "a.prev", function (e) {
        e.preventDefault();
        var $a = $(this).closest('a');
        var sendAction = {
            'action': 'prev',
            'data-id': $a.attr('data-id')
        };
        sendAjax(sendAction);
    });

    $(sheet).on("touchstart click", "a.next", function (e) {
        e.preventDefault();
        var $a = $(this).closest('a');
        var sendAction = {
            'action': 'next',
            'data-id': $a.attr('data-id')
        };
        sendAjax(sendAction);
    });

    $(sheet).on("change", "select.current", function (e) {
        e.preventDefault();
        var value = $(this).val();
        var sendAction = {
            'action': 'next',
            'data-id': value
        };
        sendAjax(sendAction);
    });

    $(sheet).on("touchstart click", "div." + bookable, function (e) {
        e.preventDefault();
        $(sheet).find('div.loadingContainer').show(250);
        var self = $(this);
        var dataID = self.attr('data-id');
        var addRes = {
            'action': 'addReservation',
            'data-id': dataID
        };
        var sendAction = $.extend(addRes, baseData);
        $.ajax({
            type: "post",
            url: url,
            data: sendAction,
            success: function (response) {
                if (response == 'false') return;
                appendReservation(response);
                $(self).removeClass(bookable).addClass(selected);
                if (setReload == 'true') {
                    reloadAfterAdd();
                }
            },
            error: function (xhr, error) {
                console.log('Error', error);
                console.log('XHR', xhr);
            }
        });
        $(sheet).find('div.loadingContainer').hide(250);
    });

    $(sheet).on("touchstart click", "div." + selected, function (e) {
        e.preventDefault();
        $(sheet).find('div.loadingContainer').show(250);
        var self = $(this);
        var dataID = self.attr('data-id');
        var rmRes = {
            'action': 'rmReservation',
            'data-id': dataID
        };
        var sendAction = $.extend(rmRes, baseData);
        $.ajax({
            type: "post",
            url: url,
            data: sendAction,
            success: function (response) {
                $(resList).find("[data-id='" + response + "']").remove();
                $(self).removeClass(selected).addClass(bookable);
            },
            error: function (xhr, error) {
                console.log('Error', error);
                console.log('XHR', xhr);
            }
        });
        $(sheet).find('div.loadingContainer').hide(250);
    });

    $(resList).on("touchstart click", ".remove", function () {
        var self = $(this);
        var $li = self.closest('li');
        var dataID = self.attr('data-id');
        var rmRes = {
            'action': 'rmReservation',
            'data-id': dataID
        };
        var sendAction = $.extend(rmRes, baseData);
        $.ajax({
            type: "post",
            url: url,
            data: sendAction,
            success: function (response) {
                $li.remove();
                $(sheet).find("[data-id='" + response + "']").removeClass(selected).addClass(bookable);
            },
            error: function (xhr, error) {
                console.log('Error', error);
                console.log('XHR', xhr);
            }
        });
    });

    $(sheet).on("mouseenter", "div." + bookable, function () {
        $(this).addClass('hover');
    }).on("mouseleave", "div." + bookable + ".hover", function () {
        $(this).removeClass('hover');
    });
    $(sheet).on("mouseenter", "div." + selected, function () {
        $(this).addClass('hover');
    }).on("mouseleave", "div." + selected + ".hover", function () {
        $(this).removeClass('hover');
    });
    $(sheet).on("click", "button.removeAll", function () {
        $(sheet).find('div.loadingContainer').show(250);
        var remAll = {
            'action': 'removeAll'
        };
        var sendAction = $.extend(remAll, baseData);
        $.ajax({
            type: "post",
            url: url,
            data: sendAction,
            success: function (response) {
                if (response == true) {
                    reloadAfterAdd();
                }
            },
            error: function (xhr, error) {
                console.log('Error', error);
                console.log('XHR', xhr);
            }
        });
        $(sheet).find('div.loadingContainer').hide(250);
    });
}