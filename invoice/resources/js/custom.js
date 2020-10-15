"use strict";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

var picker = new Lightpick({
    field: document.getElementById("date"),
    onSelect: function(date) {
        document.getElementById("date").innerHTML = date.format("Do MMMM YYYY");
    }
});
