$(function() {

    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2000;  //time in ms, 2 second for example
    //on keyup, start the countdown
    $('#q').keyup(function() {
        clearTimeout(typingTimer);
        if ($('#q').val) {
            var postData = [];
            postData.push({name: "q", value: $('#q').val()});
            postData.push({name: "auto", value: 1});
            console.log(postData);
            typingTimer = setTimeout(function() {
                search(postData, $(this))
            }, doneTypingInterval);
        }
    });

    $("#newsearch").submit(function(event) {
        var postData = $(this).serializeArray();
        postData.push({name: "auto", value: 0});
        search(postData, $(this));
        event.preventDefault();
    });
});

function search(postData, thisObj) {

    var formURL = thisObj.attr("action");
    var submitButton = thisObj.find(':submit');
    submitButton.attr("value", "Please Wait...");
    submitButton.attr("disabled", "disabled");
    $("#q").attr("disabled", "disabled");

    $("#blocks").empty();

    $.ajax({
        url: formURL,
        type: "POST",
        data: postData,
        dataType: 'json',
        success: function(data, textStatus, jqXHR)
        {
            if (data == null || !data.length) {
                content = '<p> No Results. </p>';
                $(content).appendTo("#blocks");
                return;
            }
            $.each(data, function(i, block) {
                content = '<p> title : ' + block.title + '</p>';
                content += '<br/>';
                $(content).appendTo("#blocks");
            });
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            content = '<p> Error Occured. </p>';
            $(content).appendTo("#blocks");
            return;
        },
        complete: function() {
            submitButton.removeAttr("disabled");
            submitButton.val("search");
            $("#q").removeAttr("disabled");
        }
    });
}