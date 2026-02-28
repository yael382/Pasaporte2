let tblDataList = null;
let datatblDataList = null;

document.addEventListener('DOMContentLoaded', () => {
    $.extend($.fn.dataTable.defaults, {
        searching: true,
        ordering: true,
        pageLength: 50,
        language: {
            "decimal": "",
            "emptyTable": "No hay filas que mostrar",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "orderable": "Ordenar de forma Ascendente",
                "orderableReverse": "Ordenar de forma Descendente"
            }
        },
        layout: {
            topStart: null,
            bottomStart: {
                pageLength: {
                    menu: [10, 25, 50, 100],
                    label: "Mostrar _MENU_ entradas"
                }
            },
        }
    });

    tblDataList = $('table#data-list');
    datatblDataList = tblDataList.DataTable({"responsive": true});
});
