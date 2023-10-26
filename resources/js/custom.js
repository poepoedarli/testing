export default class Custom {
    static initDataTable(table_id, ajax_url, dtColumns, filterColumns, deleteUrl, nthColumn=0, columnOrder = 'asc'){
        $.fn.dataTable.ext.errMode = 'none'; //hide warning message
        table = $('#'+table_id)
                    .on('xhr.dt', function ( e, settings, json, xhr ) {
                        if(json == null){ //after session timeout
                            window.location.reload();
                        }
                    } )
                    .on('processing.dt', function(e, settings, processing) {
                        let dtable_id = e.currentTarget.id
                        if (processing) {
                            $(`#${dtable_id} tbody`).hide()
                        } else {
                            $(`#${dtable_id} tbody`).show();
                        }
                        $('#processingIndicator').css('display', processing ? 'block' : 'none');
                    })
                    
                    .DataTable({
                        //stateSave: true,
                        autoWidth: false,
                        ///scrollX: true,
                        dom: 'Blrtip', //lBfrtip
                        buttons: [
                            //'copy', 'csv', 'excel', 'pdf', 'print'
                            /* {
                                extend: 'excel',
                                text: 'Export Search Results &nbsp; <i class="bi bi-download"></i>',
                                className: 'btn btn-blue-gray btn-sm ',
                                exportOptions: {
                                    columns: ':not(.notexport)'
                                }
                            } */
                        ],
                        oLanguage: {
                            "sInfo" : "Showing _START_ to _END_ of _TOTAL_ entries",// text you want show for info section
                        },
                        pageLength: 10,
                        lengthMenu: [ 5, 10, 25, 50, 75, 100, 500],
                        processing: true,
                        serverSide: true,
                        ajax: ajax_url,
                        columns: dtColumns,
                        order: [ [nthColumn, columnOrder] ],
                        initComplete: function () {
                            Custom.SetupColumnSearch(table, filterColumns);
                        },
                        drawCallback: function(response) {
                            //console.log('drawback')
                            //console.log(response)
                            Custom.initDelete(deleteUrl);
                        },
                        "language": {
                            //"processing": '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="text-primary">Loading Data. Please wait a moment .... </span>'
                        }
                    });
    }

    static SetupColumnSearch(table, filterColumns=null) {
        const criteriaInputs = filterColumns.inputs
        //console.log(criteriaInputs)
        const dropDownKeyValue = filterColumns.selects
        const criteriaSelects = dropDownKeyValue ? Object.keys(dropDownKeyValue) : null //key will be table's column name
        //console.log(criteriaSelects)
        const criteriaDates = filterColumns.dates

        /* Setup column-level search input fields. */
        $(table.table().header()).find('th').each(function(index) {
            var title = $(this).text();
            
           if (criteriaInputs && criteriaInputs.indexOf(title) > -1){
                $(this).html(title + '<br/><input type="text" class="form-control column_search icon"  oninput="Custom.stopPropagation(event)" onclick="Custom.stopPropagation(event);"/>' );
            }
            else if(criteriaSelects && criteriaSelects.indexOf(title) > -1){
                let dropDownList = dropDownKeyValue[title]
                let selectHtml = '<option value="-1">All</option>'
                for (const k in dropDownList) {
                    selectHtml += `<option value="${k}">${dropDownList[k]}</option>`
                }
                $(this).html(title +
                    `<br/><select id="select_${index}" class="form-select dt-column-dropdown form-select-sm" oninput="Custom.stopPropagation(event)" onclick="Custom.stopPropagation(event);">${selectHtml}</select>`);
            }
            /* else if(criteriaDates && criteriaDates.indexOf(title) > -1){
                $(this).html(title +
                    `<input id="datepicker_${index}" class="datepicker" data-date-format="mm/dd/yyyy" oninput="stopPropagation(event)" onclick="stopPropagation(event);">` */
                    /* `<div>
                        <input placeholder="Select date" placeholder="&#61442;" type="text" class="column_search icon" oninput="stopPropagation(event)" onclick="stopPropagation(event);">
                    </div>` 
                );
                
                //initDatePicker(`dp-${index}`, table, index)
                //$(`input[id="dp-${index}"]`).datepicker()
            }   */
        });

        /* Setup column-level searches on enter key only. */
        table.columns().every(function(index) {
            
            var column = this;

            $('input.column_search', column.header()).on('keyup', function(e) {
                //console.log('inpput draw '+this.value+' '+column.visible())
                /* Ignore all keyup events except for return keys */
                if (e.type === 'keyup' && e.keyCode !== 8 && e.keyCode !== 10 && e.keyCode !== 13)
                    return;
                else if (e.keyCode == 8 && this.value != '') return;

                /* Avoid a DataTables bug where invisible columns show up */
                if (column.visible()) {
                    table.column(column.index()).search(this.value).draw();
                }
            });

            $('select.dt-column-dropdown').on('change', function(e){
                let selectedValue = $('#select_'+index).val();
                if( selectedValue == undefined || selectedValue == '') return false;
                
                //if(selectedValue == undefined || selectedValue == -1 && selectedValue == 0) return false;
                if (column.visible()){
                    console.log(column)
                    //alert(selectedValue)
                    if(selectedValue == -1 ){
                        table.column(column.index()).search(' ').draw();
                    }
                    else {
                        table.column(column.index()).search("^" + selectedValue + "$", true, false, true).draw()
                    }
                }
            });

            /* if(criteriaDates){
                var startDate = moment().startOf("week"), endDate = moment();
                $(`#datepicker_${index}`).daterangepicker({
                    startDate: startDate,
                    endDate: endDate,
                    maxDate: moment(),
                }, function(start, end, label) {
                    startDate = start;
                    endDate = end;
                    table.column(column.index()).search('6 days ago').draw();
                    console.log("A new date selection was made: " + startDate.format('YYYY-MM-DD HH:mm') +
                        ' to ' + endDate.format('YYYY-MM-DD HH:mm'));
                    //generateContent(selectedIDs);
                })
            } */
        });
    }

    static stopPropagation(evt) {
        if (evt.stopPropagation !== undefined) {
            evt.preventDefault();
            evt.stopPropagation();
        } else {
            evt.cancelBubble = true;
        }
    }

    static initDelete(path) { //button must have prop: "data-id"
        let uri = window.location.pathname
        $(".dtable-row-action-delete").click(function() {
            if (confirm('Are you sure to delete?')) {
                let id = $(this).data("id");
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: path + id,
                    type: 'DELETE',
                    DataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': "application/json"
                    },
                    data: {
                        "_token": token,
                    },
                    success: function(response) {
                        table.ajax.reload(null, false);
                        $("#session-msg").addClass('d-none')
                        $("#status-message").html(response.message).addClass('alert alert-warning')
                        setTimeout(() => {
                            $("#status-message").html("").removeClass('alert alert-warning')
                        }, 3000);
                    }
                });
            }
        })
    }

    static resizeCharts(){
        console.log('resizeCharts')
        const charts = window.activeCharts
        console.log(charts)
        setTimeout(() => {
            for (const index in charts) {
                let chart = charts[index];
                chart.resize();
            }
        }, 100);
        
    }

    static compareByChillerName(a, b) {
        if (a.chillerName < b.chillerName)
            return -1;
        if (a.chillerName > b.chillerName)
            return 1;
        return 0;
    }


    static clearLogs(type='system') { //type => audit or system
        let path = (type=='system') ? '/system_logs' : '/audit_logs';
        if (confirm('Are you sure to delete?')) {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: path,
                type: 'DELETE',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                },
                success: function(response) {
                    table.ajax.reload(null, false);
                    $("#session-msg").addClass('d-none')
                    $("#status-message").html(response.message).addClass('alert alert-warning')
                    setTimeout(() => {
                        $("#status-message").html("").removeClass('alert alert-warning')
                    }, 3000);
                }
            });
        }
        
    }

}
