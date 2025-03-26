<script>
    function imgPathToBase64(imagePath, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', imagePath, true);
        xhr.responseType = 'blob';  // Solicitar la imagen como un blob

        xhr.onload = function(e) {
            if (this.status === 200) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const base64Data = event.target.result;
                    callback(base64Data); // Llamar a la función de devolución de llamada con la cadena Base64
                };
                reader.readAsDataURL(this.response);
            } else {
                console.error('Error al cargar la imagen:', imagePath);
                callback(undefined); // Handle error in callback
            }
        };

        xhr.onerror = function() {
            console.error('Error XHR al cargar la imagen:', imagePath);
            callback(undefined); // Handle error in callback
        };

        xhr.send();
    }

    function mostrar_tabla() {
        //console.log('hola luis');
        $.ajax({
            type: 'POST',
            url: '{{ route('dashListaraAsig') }}',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {

                var spinner =
                    `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                $("#contenedorRegistros").html(spinner);

            },
            error: function(data) {

                let errorJson = JSON.parse(data.responseText);

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errorJson.message,
                    footer: '<a href="">Vuelva a intentarlo</a>'
                });
            },
            success: function(data) {
                //console.log(data.html);
                $("#contenedorRegistros").html(data.html);
                InicializacionTabla();
            }
        });

    }

    function InicializacionTabla() {
        const imagePath1 = "{{url('Images/Gore/logoFile.png')}}";
        const imagePath2 = "{{url('Images/Gore/logo-GORE.png')}}";

        imgPathToBase64(imagePath1, function(base64Data1) {
            if (base64Data1) {
                imgPathToBase64(imagePath2, function(base64Data2) {
                    if (base64Data2) {
                        $("#datatable-buttons").DataTable({
                            pagingType: "full_numbers",
                            language: {
                                paginate: {
                                    first: "Primero",
                                    last: "Último",
                                    previous: "<i class='mdi mdi-chevron-left'>",
                                    next: "<i class='mdi mdi-chevron-right'>"
                                },
                                lengthMenu: "Mostrar _MENU_ registros por página",
                                search: "Buscar:", // Cambia el texto del buscador
                                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                                infoFiltered: "(filtrado de _MAX_ registros totales)",
                                zeroRecords: "No se encontraron registros coincidentes"
                            },
                            order: [
                                [4, 'desc']
                            ],
                            lengthMenu: [5, 10, 25, 50, 100], // Opciones de cuántos registros mostrar por página
                            responsive: true,
                            //scrollX: true,
                            dom:
                                // Botones en una fila superior y debajo el lengthMenu alineado con el buscador
                                "<'row'<'col-md-12'B>>" + // Botones en una fila independiente con margen superior
                                "<'row mt-2'<'col-md-6'l><'col-md-6'f>>" + // LengthMenu y buscador alineados en la misma fila
                                "<'row'<'col-sm-12'tr>>" + // Tabla de datos
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", // Información y paginación en la última fila
                            buttons: [{
                                    extend: 'copyHtml5', // Copia al portapapeles
                                    text: 'Copiar',
                                    className: 'btn btn-secondary'
                                },
                                {
                                    extend: 'excelHtml5', // Exporta a Excel
                                    text: 'Exportar a Excel',
                                    className: 'btn btn-success'
                                },
                                /*{
                                    extend: 'csvHtml5', // Exporta a CSV
                                    text: 'Exportar a CSV',
                                    className: 'btn btn-warning'
                                },*/
                                {
                                    extend: 'pdfHtml5', // Exporta a PDF
                                    text: 'Exportar a PDF',
                                    className: 'btn btn-danger',
                                    orientation: 'landscape', // Opción para orientación horizontal
                                    pageSize: 'A4', // Tamaño de página PDF
                                    customize: function (doc) {
                                        doc.pageMargins = [30, 70, 30, 50];
                                       
                                        const headerHeight = 60;

                                        // Encabezado
                                        doc['header'] = (currentPage, pageCount, pageSize) => {
                                            return {
                                                margin: [10, 0, 10, 0], 
                                                height: headerHeight,
                                                columns: [
                                                    {
                                                        image: base64Data1,
                                                        width: 50,
                                                        height: 50,
                                                        margin: [30, 10, 0, 0], 
                                                        alignment: 'left'  
                                                    },
                                                    {
                                                        stack: [ 
                                                            {
                                                                text: 'Gobierno Regional de Apurímac',
                                                                fontSize: 13,
                                                                margin: [0, 15, 0, 0], // Ajuste del margen superior
                                                                alignment: 'center'
                                                            },
                                                            {
                                                                text: 'Sub Gerencia de Desarrollo Institucional Estadística e Informática',
                                                                fontSize: 10,
                                                                margin: [0, 5, 0, 0], // Menor margen superior para moverlo más abajo
                                                                alignment: 'center'
                                                            }
                                                        ]
                                                        
                                                    },
                                                    {
                                                        image: base64Data2,
                                                        width: 50,
                                                        height: 50,
                                                        absolutePosition: { x: pageSize.width - 80, y: 10 }
                                                    }
                                                ],
                                            };
                                        };

                                        // Pie de página
                                        doc['footer'] = (currentPage, pageCount) => {
                                            return {
                                                columns: [
                                                    {
                                                        text: 'Página ' + currentPage + ' de ' + pageCount,
                                                        alignment: 'right',
                                                        margin: [0, 0, 20, 0]
                                                    }
                                                ],
                                                margin: [20, 10]
                                            };
                                        };

                                        // Personaliza el archivo PDF
                                        doc.styles.title = {
                                            color: '#1B4F72',
                                            fontSize: 20,
                                            alignment: 'center',
                                        };
                                        doc.styles.tableHeader = {
                                            fillColor: '#2874A6',
                                            color: 'white',
                                            alignment: 'center',
                                        };
                                        doc.styles.tableBodyEven = {
                                            fillColor: '#f3f3f3',
                                        };
                                        doc.styles.tableBodyOdd = {
                                            fillColor: '#fff',
                                        };

                                        // Ajusta el padding de las celdas
                                        doc.content[1].table.body.forEach(function(row) {
                                            row.forEach(function(cell) {
                                                cell.margin = [5, 5, 5, 5]; // margen de 5 unidades en todos los lados
                                            });
                                        });
                                    }
                                },
                                {
                                    extend: 'print', // Vista para imprimir
                                    text: 'Imprimir',
                                    className: 'btn btn-info',
                                    //title: 'Tickets | Asistencia Técnica - Gobierno Regional Apurímac',
                                    customize: function(win) {
                                        // Configura el estilo del cuerpo del documento
                                        $(win.document.body)
                                            .css('font-size', '10pt')
                                            .prepend(
                                                '<div id="printHeader" style="margin: 30px 0;">' + // Encabezado
                                                '<img src="' + base64Data1 + '" style="width:70px; height:70px; float:left; margin-right:50px; margin-top: -20px"/>' +
                                                '<h3 style="text-align: center;">Gobierno Regional de Apurímac</h3>' +
                                                '<h4 style="text-align: center;">Sub Genrencia de Desarrollo Institucional Estadística e Informática</h4>' +
                                                '<img src="' + base64Data2 + '" style="width:70px; height:70px; float:right; margin-left:50px; margin-top: -80px"/>' +
                                                '</div>'
                                            );

                                        // Añadir estilos para asegurar que el encabezado se repita en cada página
                                        $(win.document.head).append(
                                            '<style>' +
                                            '@media print {' +
                                            '  @page { margin: 5mm; }' + // Define el margen de 20mm en la página
                                            '  body { -webkit-print-color-adjust: exact; }' + // Asegura que los colores se impriman correctamente
                                            '  #printHeader {' +
                                            '    position: relative;' + // Deja que el encabezado se posicione relativo al flujo de contenido
                                            '    margin-bottom: 10px;' + // Añade un margen inferior para separarlo del contenido
                                            '    width: 100%;' +
                                            '    height: 100px;' + // Ajusta la altura del encabezado si es necesario
                                            '    background-color: white;' +
                                            '    text-align: center;' +
                                            '    z-index: 1000;' + // Asegura que el encabezado esté encima de otros elementos si es necesario
                                            '  }' +
                                            '  table { margin-top: 20px; }' + // Añade un margen superior para que no se superponga con el contenido
                                            '}' +
                                            '</style>'
                                        );

                                        // Estilo para la tabla
                                        const table = $(win.document.body).find('table');
                                        table.addClass('compact').css('font-size', 'inherit');

                                        // Agregar pie de página
                                        $(win.document.body).append(
                                            '<div style="margin-top: 20px; text-align: right; position: absolute; bottom: 0; width: 100%;">Página ' + $(win.document.body).find('table').length + '</div>'
                                        );
                                    }
                                },
                            ],
                            drawCallback: function() {
                                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                            }
                        });
                    }
                });
            }
        });
    }


    function listar_personal() {
        $.ajax({
            type: 'POST',
            url: '{{ route('dashListaPersonal') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let personals = data.personals;
                    let select = $('#selectPersonal'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Personal</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    personals.forEach(function(personal) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = personal.nombreCompletoPersonal;
                        select.append(
                            $('<option></option>')
                            .val(personal.id_personal)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar personal:', data);
            }
        });
    }

    function listar_usuario() {
        $.ajax({
            type: 'POST',
            url: '{{ route('dashListaUsuario') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let usuarios = data.usuarios;
                    let select = $('#selectUsuario'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Usuarios</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    usuarios.forEach(function(usuario) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = usuario.nombreCompleto;
                        select.append(
                            $('<option></option>')
                            .val(usuario.id_usuario)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar usuario:', data);
            }
        });
    }

    function listar_incidencia() {
        $.ajax({
            type: 'POST',
            url: '{{ route('dashListaIncidencia') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let incidencias = data.incidencias;
                    let select = $('#selectIncidencia'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Incidencia</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    incidencias.forEach(function(incidencia) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = incidencia.nombre;
                        select.append(
                            $('<option></option>')
                            .val(incidencia.id_soporte)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar usuario:', data);
            }
        });
    }

    function listar_oficina() {
        $.ajax({
            type: 'POST',
            url: '{{ route('dashListaOficinas') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let oficinas = data.oficinas;
                    let select = $('#selectOficina'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Oficina</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    oficinas.forEach(function(oficina) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = oficina.nombre;
                        select.append(
                            $('<option></option>')
                            .val(oficina.id_oficina)
                            .text(optionText)
                        );
                    });

                    /*select.select2({
                        dropdownParent: $('#modal-nueva-oficina')
                    });*/

                }
            },
            error: function(data) {
                console.error('Error en listar_categoria:', data);
            }
        });
    }

    function aplicarFiltros() {
        let id_personal = $('#selectPersonal').val();
        let id_usuario = $('#selectUsuario').val();
        let id_soporte = $('#selectIncidencia').val();
        let id_oficina = $('#selectOficina').val();
        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_fin = $('#fecha_fin').val();

        if (fecha_inicio && fecha_fin) {
            let fechaInicioDate = new Date(fecha_inicio);
            let fechaFinDate = new Date(fecha_fin);

            if (fechaFinDate < fechaInicioDate) {
                $('#fecha_fin').val('');
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "La fecha de fin no puede ser menor que la fecha de inicio.",
                    timer: 3000,
                    timerProgressBar: true,
                });
                return; // Detener la ejecución si las fechas no son válidas
            }
        }

        $.ajax({
            type: 'POST',
            url: '{{ route('dashFiltrar') }}', // Unifica las rutas de filtrado
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_personal: id_personal,
                id_usuario: id_usuario,
                id_soporte: id_soporte,
                id_oficina: id_oficina,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin
            },
            success: function(data) {
                if (data.code === 200) {
                    $("#contenedorRegistros").html(data.html);
                    InicializacionTabla();
                }
            },
            error: function(data) {
                console.error('Error al filtrar asignaciones:', data);
            }
        });
    }

    // Llamar a la función cuando cambie cualquiera de los selectores o las fechas
    //$('#selectPersonal, #selectUsuario, #selectIncidencia, #selectOficina, #fecha_inicio, #fecha_fin').on('change', aplicarFiltros);


</script>
