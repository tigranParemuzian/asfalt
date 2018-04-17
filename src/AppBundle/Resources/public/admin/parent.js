var source = [];
getGroups();
function getGroups() {
    jQuery.ajax({
        url: "/api/items/groups",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: false,
        success: function (resultData) {
            source = resultData;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

$(function(){
    //local source
    $('.property-group').editable({
        source:source,
        select2: {
            multiple: true
        }
    });
    //remote source (simple)

});
