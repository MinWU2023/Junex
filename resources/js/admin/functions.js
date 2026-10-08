formatDate= function(date) {
    var date = new Date(date);
    var YY = date.getFullYear() + '-';
    var MM = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    var DD = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate());
    var hh = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
    var mm = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
    var ss = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds());
    return YY + MM + DD + " " + hh + mm + ss;
}
sendHtml = function (data, type) {
    var html = '';
    var innerHtml = '';
    if(!type){
        html = $('<li>').addClass(data.msg_id);
        innerHtml = '<p class="i-name">you,'+ formatDate(new Date().getTime()) +'</p>'+
            '<div class="i-text">'+ data['message-data'] +'</div>' +
            '<i class="status loading"></i>';
        $('#msg-box').val('');
        $('.info-box').append(html.html(innerHtml)).scrollTop($('.info-box')[0].scrollHeight);
    }else{
        html = $('<li>').addClass('other');
        innerHtml = '<img class="user-img" src="'+ data.icon +'" />' +
            '<p class="i-name">'+ data.name +','+ formatDate(new Date().getTime()) +'</p>'+
            '<div class="i-text">'+ data.message.replace(/<[^<>]+>/g,'') +'</div>';
        var iframeDom = $(".layadmin-iframe").contents().find('.chat-iframe').contents().find('.info-box');
        iframeDom.append(html.html(innerHtml)).scrollTop(iframeDom[0].scrollHeight);
    }
}

