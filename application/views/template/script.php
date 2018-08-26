<script>
//== Class definition
    var m_datatable_avaliable_banknote;
    var m_datatable_log_withdraw;
    var jsScript = function () {
        var datatableAvaliableBankNote = function (reload) {
            if ($('#m_datatable_avaliable_banknote').length === 0) {
                return;
            }
            var url = window.location.origin + window.location.pathname + 'Api';
            url = url.replace("Welcome", "");
            if (reload) {
                m_datatable_avaliable_banknote.reload();
            } else {
                m_datatable_avaliable_banknote = $('#m_datatable_avaliable_banknote').mDatatable({
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: url + "/banknote_avaliable",
                            }
                        },
                        pageSize: 20,
                        saveState: {
                            cookie: true,
                            webstorage: true
                        },
                        serverPaging: true,
                        serverFiltering: true,
                        serverSorting: true
                    },
                    layout: {
                        theme: 'default',
                        class: '',
                        scroll: true,
                        height: 380,
                        footer: false
                    },
                    sortable: false,
                    filterable: false,
                    pagination: false,
                    columns: [{
                            field: "name",
                            title: "Bank Note",
                            textAlign: 'center'
                        }, {
                            field: "remain",
                            title: "Remain",
                            textAlign: 'center'
                        }]
                });
            }
        }

        var datatableLogWithdraw = function (reload) {
            if ($('#m_datatable_log_withdraw').length === 0) {
                return;
            }
            var url = window.location.origin + window.location.pathname + 'Api';
            url = url.replace("Welcome", "");
            if (reload) {
                m_datatable_log_withdraw.reload();
            } else {
                m_datatable_log_withdraw = $('#m_datatable_log_withdraw').mDatatable({
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: url + "/log_withdraw",
                            }
                        },
                        pageSize: 20,
                        saveState: {
                            cookie: true,
                            webstorage: true
                        },
                        serverPaging: true,
                        serverFiltering: true,
                        serverSorting: true
                    },
                    layout: {
                        theme: 'default',
                        class: '',
                        scroll: true,
                        height: 380,
                        footer: false
                    },
                    sortable: false,
                    filterable: false,
                    pagination: false,
                    columns: [{
                            field: "datetime",
                            title: "Date Time",
                            textAlign: 'center'
                        }, {
                            field: "detail",
                            title: "Detail",
                            textAlign: 'left'
                        }]
                });
            }
        }

        return {
            //== Init
            init: function () {
                datatableAvaliableBankNote(false);
                datatableLogWithdraw(false);
            },
            functionCall: function (function_name, param1, param2) {
                switch (function_name) {
                    case 'datatableAvaliableBankNote':
                        datatableAvaliableBankNote(true);
                        break;
                    case 'datatableLogWithdraw':
                        datatableLogWithdraw(true);
                        break;
                    default:
                        console.log('default');
                }
            }
        };
    }();

//== Class initialization on page load
    jQuery(document).ready(function () {
        jsScript.init();
    });
</script>