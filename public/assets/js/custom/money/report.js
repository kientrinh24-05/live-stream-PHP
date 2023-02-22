$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // INITIALIZATION OF STICKY HEADER
    // =======================================================
    $('.js-sticky-header').HSStickyHeader();

    // INITIALIZATION OF DATERANGEPICKER
    // =======================================================
    $('.js-daterangepicker').daterangepicker();

    $('.js-daterangepicker-times').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'M/DD hh:mm A'
        }
    });

    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end, label) {
        $('#reportDate .js-daterangepicker-predefined-preview').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('#typeDate').val(label);
    }

    $('#reportDate').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $.ajax({
        url: 'transaction/report',
        type: "get",
        success: function (data) {
            $('#content_report').html(data);
            chart_option()
        },
        error: function (data) {
            let errors = data.responseJSON;
            let errorsHtml = "";
            $.each(errors, function (key, value) {
                errorsHtml += "<li>" + value[0] + "</li>";
            });
            toastr.error(errorsHtml, "Lỗi tải dữ liệu!");
            Swal.fire("Error!", errorsHtml, "error");
        }
    });

    $('#reportDate').on('apply.daterangepicker', function (ev, picker) {
        $('#startDate').val(picker.startDate.format('YYYY-MM-DD'));
        $('#endDate').val(picker.endDate.format('YYYY-MM-DD'));
        $.ajax({
            url: 'transaction/report',
            type: "get",
            data: {
                start: picker.startDate.format('YYYY-MM-DD'),
                end: picker.endDate.format('YYYY-MM-DD'),
                type: $('#typeDate').val()
            },
            success: function (data) {
                $('#content_report').html(data);
                chart_option();
            },
            error: function (data) {
                let errors = data.responseJSON;
                let errorsHtml = "";
                $.each(errors, function (key, value) {
                    errorsHtml += "<li>" + value[0] + "</li>";
                });
                toastr.error(errorsHtml, "Tạo report lỗi!");
                Swal.fire("Error!", errorsHtml, "error");
            }
        });
    });

    // Show Invoice
    $('body').on('click', '.invoice', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        show_trans_type_report('transaction/report/invoice/' + id, '#invoiceModal')

    })

    $('body').on('click', '.expense_detail', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        show_trans_detail_report('transaction/expense/edit/' + id, '#invoiceDetailModal');
    })

    // Show Receipt
    $('body').on('click', '.receipt', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        show_trans_type_report('transaction/report/receipt/' + id, '#invoiceModal')
    })

    $('body').on('click', '.income_detail', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        show_trans_detail_report('transaction/income/edit/' + id, '#receiptDetailModal');
    })
});

function show_trans_type_report(url, modal) {
    var start = $('#startDate').val();
    var end = $('#endDate').val();
    $('#item_money').empty();

    $.get(url + '?end=' + end + '&start=' + start, function (data) {
        $("#category").text('Transaction detail: ' + data.cate[0].name);
        $("#start_date").text(data.from);
        $("#end_date").text(data.to);
        if (data.title === 'Expense') {
            $('.titleType').text(' Tribe Team Invoice');
            $('.pay_re').text('Payment date');
            $.each(data.money, function (key, value) {
                $('#item_money').append('' +
                    '<tr>\n' +
                    '   <td> ' + value.id + '</td>\n' +
                    '   <td> ' + value.payment_date + '</td>\n' +
                    '   <td> ' + (value.amount_vnd).toLocaleString() + '</td>\n' +
                    '   <td> ' + parseFloat(value.amount_usd).toLocaleString() + '</td>\n' +
                    '   <td> ' + (value.rate).toLocaleString() + '</td>\n' +
                    '   <td> ' + value.type + '</td>\n' +
                    '   <td> ' + value.note + '</td>\n' +
                    '   </tr>');
            });
        } else if (data.title === 'Income') {
            $('.titleType').text(' Tribe Team Receipt');
            $('.pay_re').text('Received date');
            $.each(data.money, function (key, value) {
                $('#item_money').append('' +
                    '<tr>\n' +
                    '   <td> ' + value.id + '</td>\n' +
                    '   <td> ' + value.received_date + '</td>\n' +
                    '   <td> ' + (value.amount_vnd).toLocaleString() + '</td>\n' +
                    '   <td> ' + parseFloat(value.amount_usd).toLocaleString() + '</td>\n' +
                    '   <td> ' + (value.rate).toLocaleString() + '</td>\n' +
                    '   <td> ' + value.type + '</td>\n' +
                    '   <td> ' + value.note + '</td>\n' +
                    '   </tr>');
            });
        } else {
            alert('Lỗi không xác định');
        }

        $("#sum").text(parseFloat(data.total[0].sum_usd).toLocaleString() + ' USD - ' + parseFloat(data.total[0].sum_vnd).toLocaleString() + ' VND');
        $(modal).modal('toggle');
    });
}

function show_trans_detail_report(url, modal) {
    $.get(url, function (data) {
        $("#id").val(data.id);
        if (data.description.account !== null && data.description.name !== null && data.description.bank !== null) {
            $(".bank_info").text(data.description.account + ' - ' + data.description.name + ' - ' + data.description.bank);
        } else {
            $(".bank_info").text('');
        }
        $(".vnd_amount").text((data.amount_vnd).toLocaleString());
        $(".usd_amount").text((data.amount_usd).toLocaleString());
        if (data.description.type === 'E-Cash') {
            $('.payment_method_icon').attr("src", '/assets/images/vi_dien_tu.png');
            $(".payment_method").text('Ví điện tử');
        } else if (data.description.type === 'Transfer') {
            $('.payment_method_icon').attr("src", '/assets/images/chuyen_khoan.png');
            $(".payment_method").text('Chuyển khoản');
        } else if (data.description.type === 'Cash') {
            $('.payment_method_icon').attr("src", '/assets/images/tien_mat.png');
            $(".payment_method").text('Tiền mặt');
        } else {
            $('.payment_method_icon').attr("src", '/assets/images/payment_khac.jpg');
            $(".payment_method").text('Không xác định');
        }
        if (data.title === 'Income') {
            $(".created_at").text(data.received_date);
        } else if (data.title === 'Expense') {
            $(".created_at").text(data.payment_date);
        } else {
            alert('Lỗi không xác định');
        }
        $(".payment_to").text(data.category[0].name);
        $(".amount_usd_vnd").text((data.amount_usd).toLocaleString() + ' USD - ' + (data.amount_vnd).toLocaleString() + ' VND');
        $(".exchange_rate").text((data.rate).toLocaleString() + ' VND');
        $(".details").text(data.description.note);
        $(".amount_paid").text((data.amount_vnd).toLocaleString() + ' VND');
        $(modal).modal('toggle');
    });
}

function chart_option() {
    $('.js-chart').each(function () {
        $.HSCore.components.HSChartJS.init($(this), {
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function (value) {
                                if (value >= 100000 && value < 1000000) {
                                    return (value / 1000).toLocaleString() + "K";
                                } else if (value >= 1000000 && value < 1000000000) {
                                    return (value / 1000000).toLocaleString() + "M";
                                } else if (value >= 1000000000) {
                                    return (value / 10000000).toLocaleString() + "B";
                                } else {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    postfix: " VND",
                    hasIndicator: true,
                    mode: "index",
                    intersect: false,
                    lineMode: true,
                    lineWithLineColor: "rgba(19, 33, 68, 0.075)",
                    yearStamp: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel.toLocaleString("vi-VI");
                        }
                        // ,
                        // footer: function (tooltipItems, data) {
                        //     var sum = 0;
                        //     tooltipItems.forEach(function (tooltipItem) {
                        //         sum += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        //     });
                        //     console.log(sum)
                        //     return "Sum:" + sum;
                        // },
                    }
                }
            }
        });
    });
}
