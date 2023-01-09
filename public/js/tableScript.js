    


            $(document).ready(function() {
                 jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            'locale-compare-asc': function ( a, b ) {
                return a.localeCompare(b, 'cs', { sensitivity: 'accent' })
            },
            'locale-compare-desc': function ( a, b ) {
                return b.localeCompare(a, 'cs', { sensitivity: 'accent' })
            }
            })

            jQuery.fn.dataTable.ext.type.search['locale-compare'] = function (data) {
            return !data
                ? ''
                    : typeof data === 'string'
                    ? data
                    .replace(/\n/g, ' ')
                    .replace(/[éÉěĚèêëÈÊË]/g, 'e')
                    .replace(/[šŠ]/g, 's')
                    .replace(/[čČçÇ]/g, 'c')
                    .replace(/[řŘ]/g, 'r')
                    .replace(/[žŽ]/g, 'z')
                    .replace(/[ýÝ]/g, 'y')
                    .replace(/[áÁâàÂÀ]/g, 'a')
                    .replace(/[íÍîïÎÏ]/g, 'i')
                    .replace(/[ťŤ]/g, 't')
                    .replace(/[ďĎ]/g, 'd')
                    .replace(/[ňŇ]/g, 'n')
                    .replace(/[óÓ]/g, 'o')
                    .replace(/[úÚůŮ]/g, 'u')
                    : data
            }

                $.fn.dataTable.moment( 'DD/MM/YYYY' );

                $('table').DataTable({
                    columnDefs : [
                            { targets: 0, type: 'locale-compare' },
                            { targets: 3, type: 'locale-compare' },
                        ],
                    "pageLength": 20,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    language: {
                         "decimal":        "",
                        "emptyTable":     "No hay datos disponibles",
                        "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "infoEmpty":      "Showing 0 to 0 of 0 entries",
                        "infoFiltered":   "(filtrados desde _MAX_ registros totales)",
                        "infoPostFix":    "",
                        "thousands":      ",",
                        "lengthMenu":     "Mostrar _MENU_ registros",
                        "loadingRecords": "Loading...",
                        "processing":     "",
                        "search":         "Buscar:",
                        "zeroRecords":    "No se encontraron coincidencias.",
                        "paginate": {
                            "first":      "Primera",
                            "last":       "Última",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        "aria": {
                            "sortAscending":  ": activar para ordenar columna ascendente",
                            "sortDescending": ": activar para ordenar columna descendente"
                        }
                    }
                });

                
                     
            });
      