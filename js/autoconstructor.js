$(document).ready(function() {
    var form = $('<form id="dynamicForm" method="POST">');//abre la etiqueta del formulario
    $.each(data, function(i, item) {// itera con $.each sobre el json data que contiene la consulta
        // Crea el label llamando al item que contiene preguntaDetalle, este es el atributo Detalle de la tabla preguntas en la base de datos
        if (item.preguntaDetalle) { //Condicion, si la pregunta existe
            form.append('<h5>' + item.preguntaDetalle + '</h5>');//imprime en pantalla como label la pregunta
            form.append('<br>');
        }
        if (item.tipoPregunta != 1) {//Llama al item tipoPregunta que devuelve un numero entero preestablecido en el disenio y guardado en la base de datos
            var opciones = item.respuestasDetalle.split(','); //Asiga a una variable nueva "opciones" el item de data respuestaDetalle... 
            //...que contiene la ID y Detalle de la tabla respuestas, que devuelve la consulta de esta manera (ID:Detalle,ID:Detalle,ID:Detalle)...
            //...esta misma se guarda separando por "," en filas ID:Detalle 
            $.each(opciones, function(j, opcion) {
                if (opcion) {
                    var respuestaData = opcion.split(':');//Asigna a una variable nueva la separacion de esta forma ID:Detalle, siendo ID = respuestaData[0] y Detalle = respuestaData[1]
                }
            });
            if (item.tipoPregunta == 2) {
                        $.each(opciones, function(j, opcion) {
                            if (opcion) {
                                var respuestaData = opcion.split(':');
                                var radio = $('<div class="custom-control custom-radio">');
                                radio.append('<input class="custom-control-input" type="radio" id="customRadio' + i + j + '" name="customRadio' + i + '" value="' + respuestaData[0] + '">');
                                radio.append('<label class="custom-control-label" for="customRadio' + i + j + '">' + respuestaData[1] + '</label>');
                                form.append(radio);
                            }
                        });
            } else if (item.tipoPregunta == 3) {
                $.each(opciones, function(j, opcion) {
                    if (opcion) {
                        var respuestaData = opcion.split(':');
                        var checkbox = $('<div class="form-check form-check-inline">');
                        // Agrega un salto de línea después de cada checkbox
                        form.append('<br>');
                        checkbox.append('<input class="form-check-input" type="checkbox" id="inlineCheckbox' + i + j + '" name="inlineCheckbox' + i + '[]" value="' + respuestaData[0] + '">');
                        checkbox.append('<label class="form-check-label" for="inlineCheckbox' + i + j + '">' + respuestaData[1] + '</label>');
                        form.append(checkbox);
                    }
                });
            } 
            else if (item.tipoPregunta == 4) {
                $.each(opciones, function(j, opcion) {
                    if (opcion) {
                        var respuestaData = opcion.split(':');
                        var radio = $('<div class="custom-control custom-radio">');
                        radio.append('<input class="custom-control-input" type="radio" id="customRadio2' + i + j + '" name="customRadio2' + i + '" value="' + respuestaData[0] + '">');
                        radio.append('<label class="custom-control-label" for="customRadio2' + i + j + '">' + respuestaData[1] + '</label>');
    
                        // Verifica si la opción es 'Otra' y agrega un campo de entrada de texto
                        if (respuestaData[1] === 'Otra') {
                            var otroInput = $('<input type="text" class="form-control otro-input" placeholder="Otra opción" name="textInput4' + i + '-' + j + '-' + respuestaData[0] + '">');
                            otroInput.hide();  // Oculta el campo de entrada de texto inicialmente
                            radio.find('input[type=radio]').on('change', function() {
                                if ($(this).val() === respuestaData[0]) {
                                    otroInput.show();  // Muestra el campo de entrada de texto cuando se selecciona "Otra"
                                } else {
                                    otroInput.hide();  // Oculta el campo de entrada de texto cuando se selecciona otra opción
                                }
                            });
                            radio.append(otroInput);
                        }
    
                        form.append(radio);
                    }
                });
    } else if (item.tipoPregunta == 5) {
        $.each(opciones, function(j, opcion) {
            if (opcion) {
                var respuestaData = opcion.split(':');
                var checkbox = $('<div class="form-check form-check-inline">');
                form.append('<br>');
                checkbox.append('<input class="form-check-input" type="checkbox" id="inlineCheckbox' + i + j + '" name="inlineCheckbox' + i + '[]" value="' + respuestaData[0] + '">');
                checkbox.append('<label class="form-check-label" for="inlineCheckbox' + i + j + '">' + respuestaData[1] + '</label>');
    
                // Verifica si la opción es 'Otra' y agrega un campo de entrada de texto
                if (respuestaData[1] === 'Otra') {
                    var otroInput = $('<input type="text" class="form-control otro-input" placeholder="Otra opción" name="textInput5' + i + '-' + j + '">');
                    otroInput.hide();  // Oculta el campo de entrada de texto inicialmente
                    checkbox.find('input[type=checkbox]').on('change', function() {
                        if ($(this).is(':checked') && $(this).val() === respuestaData[0]) {
                            otroInput.show();  // Muestra el campo de entrada de texto cuando se selecciona "Otra"
                        } else {
                            otroInput.hide();  // Oculta el campo de entrada de texto cuando se deselecciona "Otra"
                        }
                    });
                    checkbox.append(otroInput);
                }
    
                form.append(checkbox);
            }
        });
    } else if (item.tipoPregunta == 6) {
        $.each(opciones, function(j, opcion) {
            if (opcion) {
                var respuestaData = opcion.split(':');
                var label = $('<label for="myRange' + i + '" style="display: inline; text-align: left;">' + respuestaData[1] + '</label>');
                var slider = $('<input type="range" min="1" max="5" class="slider" id="myRange' + i + '" style="width: 60%;">');
                slider.attr('name', 'slider' + i + '[]'); // Cambia el nombre para que sea un array
                slider.attr('data-respuesta-id', respuestaData[0]); // Agrega el ID de respuesta como atributo
    
                // Agrega un campo oculto para enviar el detalle de la respuesta
                var hidden = $('<input type="hidden" name="detalle_respuesta' + i + '[]">');
    
                var datalist = $('<div id="tickmarks' + i + '" style="display: flex; justify-content: space-between; width: 60%;">');
                for (var j = 1; j <= 5; j++) {
                    datalist.append('<span>' + j + '</span>');
                }
    
                // Agrega un evento de cambio para actualizar el campo oculto con el valor seleccionado
                slider.on('input', function() {
                    hidden.val($(this).val());
                });
    
                var sliderContainer = $('<div style="display: flex; flex-direction: column; margin-bottom: 20px;"></div>');
                sliderContainer.append(label);
                sliderContainer.append(slider);
                sliderContainer.append(datalist);
                sliderContainer.append(hidden);
                form.append(sliderContainer);
            }
        });
    }
    } else {
            var opciones = item.respuestasDetalle.split(','); //Asiga a una variable nueva "opciones" el item de data respuestaDetalle... 
            //...que contiene la ID y Detalle de la tabla respuestas, que devuelve la consulta de esta manera (ID:Detalle,ID:Detalle,ID:Detalle)...
            //...esta misma se guarda separando por "," en filas ID:Detalle 
            $.each(opciones, function(j, opcion) {
                if (opcion) {
                    var respuestaData = opcion.split(':');
                    var inputAbierto = $('<input type="text" class="form-control">');
                    inputAbierto.attr({
                        'id': 'textInputAbierta' + i,
                        'name': 'textInputAbierta' + i
                    });
                    // Agrega un campo oculto con el valor de respuestaData[0]
                    var hiddenDynamic = $('<input type="hidden" name="hiddenInput' + i + '">');
                    hiddenDynamic.val(respuestaData[0]);
                    // Agrega un salto de línea después de cada checkbox
                    form.append('<br>');
                    form.append(inputAbierto);
                    form.append(hiddenDynamic);
                }
            });
        }
        form.append('<hr>');  // Add a line break after each question
    });
    // Crea el campo de entrada oculto y lo agrega al formulario
    var hiddenInputId_encuestado = $('<input type="hidden" id="id_encuestado_hidden" name="id_encuestado_hidden" value="' + last_id + '">');
    form.append(hiddenInputId_encuestado);
    // Add a submit button to the form
    form.append('<div class="text-center"><input type="submit" value="Enviar encuesta" id="submitButtonDynamic" style="background-color: #343a40; color: white; border-radius: 30%; width: 200px; height: 50px;"></div>');
    $('#autoconstructor').append(form);
    });