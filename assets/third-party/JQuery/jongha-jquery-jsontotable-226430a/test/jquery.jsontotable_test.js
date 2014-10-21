﻿(function($) {
    test("Test1 for Array", function() {
        var target = $("#test1");
        var arr = [[1, 2, 3]];

        target.empty();
        $.jsontotable(arr, { id: "#test1", header: false });
        equal(target.find("thead").length, 0);
        equal(target.find("tbody").length, 1);
        equal(target.find("tr").length, 1);
        equal(target.find("td").length, 3);
        equal(target.text(), arr[0].join(""));

        arr = [[1, 2, 3], [1, 2, 3]];
        target.empty();
        $.jsontotable(arr, { id: "#test1", header: false });
        equal(target.find("thead").length, 0);
        equal(target.find("tbody").length, 2);
        equal(target.find("tr").length, 2);
        equal(target.find("td").length, 6);
        equal(target.text(), arr[0].join("") + arr[1].join(""));

        target.empty();
        $.jsontotable(arr, { id: "#test1" });
        equal(target.find("thead").length, 1);
        equal(target.find("tbody").length, 2);
        equal(target.find("tr").length, 3);
        equal(target.find("td").length, 6);
        equal(target.text(), arr[0].join("") + arr[0].join("") + arr[1].join(""));
    });

    test("Test2 for String", function() {
        var target = $("#test2");
        var str = "[[1, 2, 3]]";

        target.empty();
        $.jsontotable(str, { id: "#test2", header: false });
        equal(target.find("thead").length, 0);
        equal(target.find("tbody").length, 1);
        equal(target.find("tr").length, 1);
        equal(target.find("td").length, 3);
        equal(target.text(), str.replace(/[\[\], ]/gi, ""));

        str = "[[1, 2, 3], [1, 2, 3]]";
        target.empty();
        $.jsontotable(str, { id: "#test2", header: false });
        equal(target.find("thead").length, 0);
        equal(target.find("tbody").length, 2);
        equal(target.find("tr").length, 2);
        equal(target.find("td").length, 6);
        equal(target.text(), str.replace(/[\[\], ]/gi, ""));

        target.empty();
        $.jsontotable(str, { id: "#test2" });
        equal(target.find("thead").length, 1);
        equal(target.find("tbody").length, 2);
        equal(target.find("tr").length, 3);
        equal(target.find("td").length, 6);
        equal(target.find("tbody").text(), str.replace(/[\[\], ]/gi, ""));
    });

    test("Test3 for Dictionary", function() {
        var target = $("#test3");
        var str = '[{ "a": 1, "b": 2, "c": 3 }]';

        target.empty();
        $.jsontotable(str, { id: "#test3", header: false });
        equal(target.find("thead").length, 0);
        equal(target.find("tbody").length, 1);
        equal(target.find("tr").length, 1);
        equal(target.find("td").length, 3);
        equal(target.text(), str.replace(/[\{\}\"\[\], abc:]/gi, ""));

        str = '[{ "a": 1, "b": 2, "c": 3 }, { "a": 1, "b": 2, "c": 3 }]';
        target.empty();
        $.jsontotable(str, { id: "#test3", header: false });
        equal(target.find("thead").length, 0);
        equal(target.find("tbody").length, 2);
        equal(target.find("tr").length, 2);
        equal(target.find("td").length, 6);
        equal(target.text(), str.replace(/[\{\}\"\[\], abc:]/gi, ""));

        target.empty();
        $.jsontotable(str, { id: "#test3" });
        equal(target.find("thead").length, 1);
        equal(target.find("tbody").length, 2);
        equal(target.find("tr").length, 3);
        equal(target.find("td").length, 6);
        equal(target.find("tbody").text(), str.replace(/[\{\}\"\[\], abc:]/gi, ""));
    });
}(jQuery));
