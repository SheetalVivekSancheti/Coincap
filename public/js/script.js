
//
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table){
    var $table             = table.table().node();
    var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
    var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
    var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

    // If none of the checkboxes are checked
    if($chkbox_checked.length === 0){
        chkbox_select_all.checked = false;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
        }

        // If all of the checkboxes are checked
    } else if ($chkbox_checked.length === $chkbox_all.length){
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
        }

        // If some of the checkboxes are checked
    } else {
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = true;
        }
    }
}

$(document).ready(function (){

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr');
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
            return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
        });

        $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','false');
        });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','true');
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $('.counter').text(jobCount + ' item');

        if(jobCount == '0') {$('.no-result').show();}
        else {$('.no-result').hide();}
    });

    // Array holding selected row IDs
    var rows_selected = [];
    var table = $('#example').DataTable({
        responsive : true,
        'columnDefs': [{
            'targets': 0,
            'searchable':false,
            'orderable':false,
            'width':'1%',
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                // console.log(full)
                // console.log($(data).val());

                if($(data).val() == 1 && jQuery.inArray($(full[2]).text().trim(), rows_selected) == -1) {
                    // console.log(full);
                    rows_selected.push($(full[2]).text().trim());
                }
                return '<input type="checkbox">';
            }
        }],
        'order': [1, 'asc'],
        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data[2];
            rowId = $(rowId).text().trim();
            // console.log(rows_selected);
            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }
        }
    });

    // Handle click on checkbox
    $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');

        // Get row data
        var data = table.row($row).data();

        // Get row ID
        var rowId = data[2];
        rowId = $(rowId).text().trim();
        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray(rowId, rows_selected);


        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
            rows_selected.push(rowId);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
            rows_selected.splice(index, 1);
        }

        if(this.checked){
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }

        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    // Handle click on table cells with checkboxes
    $('#example').on('click', 'tbody td, thead th:first-child', function(e){
        $(this).parent().find('input[type="checkbox"]').trigger('click');
    });

    // Handle click on "Select all" control
    $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
        if(this.checked){
            $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('#example tbody input[type="checkbox"]:checked').trigger('click');
        }

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    // Handle table draw event
    table.on('draw', function(){
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);
    });

    // Handle form submission event
    $('#frm-example').on('submit', function(e){
        var form = this;

        // Iterate over all selected checkboxes
        $.each(rows_selected, function(index, rowId){
            // Create a hidden element
            $(form).append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'selected_coins[]')
                    .val( rowId )
            );
        });
        // Remove added elements
        $('input[name="id\[\]"]', form).remove();
        // console.log(rows_selected);
    });

});
