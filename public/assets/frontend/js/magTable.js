// var magTable = function (selector, options) {
jQuery.fn.magTable = function (options) {
    let selector = $(this);
    let classIdentifier = $(this).hasClass("div-table") ? "div" : "rac";
    let rowClass = classIdentifier + "-row";
    let colClass = classIdentifier + "-column";
    let errClass = classIdentifier + "-error";
    let wrapperClass = classIdentifier + "-table-wrapper";
    let isAjax = options.ajax;
    if (isAjax) {
        ajaxMagTable(selector, wrapperClass, options, rowClass, colClass, errClass);
    }
};

function ajaxMagTable(selector, wrapperClass, options, rowClass, colClass, errClass, data = {}) {
    let ajaxOptions = options.ajax;
    let ajaxData = ajaxOptions.data;
    // let finalData = ajaxData.concat(data);
    let finalData = { ...ajaxData, ...data };
    let search = (ajaxData && ajaxData.search) ? ajaxData.search : "";
    let noDataMsg = options.noDataMsg?options.noDataMsg:"No records found";
    let noSearchMsg = options.noSearchMsg?options.noSearchMsg:"No records found for your search criteria";
    noDataMsg = search ? noSearchMsg : noDataMsg;
    // console.log(search);
    $.ajax({
        url: ajaxOptions.url,
        type: ajaxOptions.type,
        data: finalData,
        success: function (response) {
            ajaxResponse = response;
            let currentPage = response.currentPage;
            let recordsFiltered = response.recordsFiltered;
            let recordPerPage = response.recordPerPage;
            let ajaxData = response.data;
            let htmlConstructed = "";
            let htmlConstructedError = "";
            selector.parent().find("." + errClass).remove();
            let ColumnLength = selector.find(
                "." + rowClass + ":first ." + colClass
            ).length;
            if (options.columns) {
                let columnData = options.columns;
                if (ajaxData && ajaxData.length > 0) {
                    $.each(ajaxData, function (index, value) {
                        let datalength = 0;
                        let type = typeof value;
                        if (type == "object") {
                            datalength = $.map(value, function (n, i) {
                                return i;
                            }).length;
                        } else {
                            datalength = value.length;
                        }
                        // let datalength = value.length
                        if (ColumnLength != datalength) {
                            alert("column mismatch");
                        }
                        htmlConstructed += "<div class=" + rowClass + ">";
                        $.each(value, function (index2, value2) {
                            let obj = columnData.find((o) => o.name == index2);
                            if (obj) {
                                let objcolClass = obj.colClass
                                    ? obj.colClass
                                    : "";
                                let divClass = colClass + " " + objcolClass;
                                htmlConstructed +=
                                    '<div class="' + divClass + '">';
                                if (obj.render) {
                                    htmlConstructed += obj.render(value2);
                                } else {
                                    htmlConstructed += value2;
                                }
                            } else {
                                htmlConstructed +=
                                    "<div class=" + colClass + ">";
                                htmlConstructed += value2;
                            }
                            htmlConstructed += "</div>";
                        });
                        htmlConstructed += "</div>";
                    });
                } else {
                    htmlConstructedError += "<div class=" +errClass + "><p class='ll blur-color'>"+noDataMsg+"</p></div>";
                    // htmlConstructed +=
                    //     "<div class=" +
                    //     rowClass +
                    //     "><div class=" +
                    //     colClass +
                    //     "><p class='ll blur-color' style='width:100px !important;'>No Data found</p></div></div>";
                }
            } else {
                if (ajaxData.length > 0) {
                    $.each(ajaxData, function (index, value) {
                        let datalength = 0;
                        let type = typeof value;
                        if (type == "object") {
                            datalength = $.map(value, function (n, i) {
                                return i;
                            }).length;
                        } else {
                            datalength = value.length;
                        }
                        // let datalength = value.length
                        if (ColumnLength != datalength) {
                            alert("column mismatch");
                        }
                        htmlConstructed += "<div class=" + rowClass + ">";
                        $.each(value, function (index2, value2) {
                            htmlConstructed += "<div class=" + colClass + ">";
                            htmlConstructed += value2;
                            htmlConstructed += "</div>";
                        });
                        htmlConstructed += "</div>";
                    });
                } else {
                    // htmlConstructed += "<div class=" + rowClass + "><div class=" + colClass + "><p class='ll blur-color'>No Data found</p></div></div>";
                    htmlConstructedError += "<div class=" +errClass + "><p class='ll blur-color'>"+noDataMsg+"</p></div>";
                }
            }
            selector
                .find("." + rowClass)
                .not(":first")
                .remove();
            selector.append(htmlConstructed);
            selector.after(htmlConstructedError);
            paginateMagTable(
                selector,
                wrapperClass,
                currentPage,
                recordsFiltered,
                recordPerPage
            );
            selector
                .closest("." + wrapperClass)
                .find(".page-item a")
                .click(function (e) {
                    e.preventDefault();
                    if (!$(this).parent().hasClass("disabled")) {
                        var isPrevious = $(this).parent().hasClass("previous");
                        var isNext = $(this).parent().hasClass("next");
                        var pageNumber = 0;
                        if (isPrevious) {
                            pageNumber = parseInt(currentPage) - 1;
                        } else if (isNext) {
                            pageNumber = parseInt(currentPage) + 1;
                        } else {
                            pageNumber = $(this).text();
                        }
                        let data = { page: pageNumber };
                        ajaxMagTable(
                            selector,
                            wrapperClass,
                            options,
                            rowClass,
                            colClass,
                            errClass,
                            data
                        );
                    }
                });
        },
    });
}
function paginateMagTable(selector, wrapperClass, currentPage, recordsFiltered, recordPerPage) {
    var pageLength = Math.ceil(recordsFiltered / recordPerPage);

    let htmlConstructed = '<div class="req-paginations">';
    htmlConstructed += '<nav aria-label="Page navigation example">';
    htmlConstructed += '<ul class="pagination">';
    // Prev Button
    htmlConstructed += '<li class="page-item previous ' + (currentPage == "1" ? "disabled" : "") + ' "> <a class="page-link" href="#" aria-label="Previous"></a> </li>';
    for (let i = 0; i < pageLength; i++) {
        let page = i + 1;
        let active = (page == currentPage) ? "active" : "";
        let currentDisabled = (page == currentPage) ? "disabled" : "";
        htmlConstructed += '<li class="page-item ' + currentDisabled + '"> <a class="page-link ' + active + '" href="#">' + page + '</a></li>';
    }
    // Next Button
    htmlConstructed += '<li class="page-item next ' + (currentPage == pageLength ? "disabled" : "") + '"> <a class="page-link" href="#" aria-label="Next"></a> </li>';


    htmlConstructed += '</ul>';
    htmlConstructed += '</nav>';
    htmlConstructed += '</div>';

    selector.closest("." + wrapperClass).find('.req-paginations').remove();
    selector.closest("." + wrapperClass).append(htmlConstructed);
}

// (function ($, window, document, undefined) {
// });