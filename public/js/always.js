$(document).foundation();

$(document).ready(function(){
    // $(".datepicker").datepicker(settings.datepicker);
    // $(".datepicker-yearSelection").datepicker($.extend({},settings.datepicker,{changeMonth: true, changeYear: true}));
    // $(".datepicker-gebYear").attr("autocomplete", "off");
    $(".datepicker").datepicker(settings.datepicker);
    $(".datepicker-yearSelection").datepicker($.extend({},settings.datepicker,{changeMonth: true, changeYear: true}));
    $(".datepicker-gebYear").datepicker($.extend({},settings.datepicker,{changeMonth: true, changeYear: true, yearRange: '1899:'}));
    $(".button-dropdown").click(function(){
        $(this).toggleClass("open");
    })
});