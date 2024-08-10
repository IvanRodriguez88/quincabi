window.autocomplete = (name, data, placeholder, onSelect, onInput) => {
    // Almacenar la instancia de autoComplete para eliminar eventos previos
    if (window[`autoCompleteJS_${name}`]) {
        window[`autoCompleteJS_${name}`].unInit();
    }

    // Eliminar cualquier evento previo de input para evitar duplicados
    $(`#${name}_name`).off("input");

    // Crear una nueva instancia de autoComplete
    window[`autoCompleteJS_${name}`] = new autoComplete({
        selector: `#${name}_name`,
        placeHolder: placeholder ?? "",
        data: {
            src: data,
            keys: ["name"],
            cache: true,
        },
        resultsList: {
            element: (list, data) => {
                if (!data.results.length) {
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span>No items found for "${data.query}"</span>`;
                    list.prepend(message);
                }
            },
            noResults: true,
        },
        resultItem: {
            highlight: {
                render: true
            }
        },
        events: {
            input: {
                focus() {
                    if (window[`autoCompleteJS_${name}`].input.value.length) {
                        window[`autoCompleteJS_${name}`].start();
                    }
                },
                selection(event) {
                    const feedback = event.detail;
                    const selection = feedback.selection.value;
                    $(`#${name}_id`).val(selection.id);
                    window[`autoCompleteJS_${name}`].input.value = selection.name;
                    if (typeof onSelect === "function") {
                        onSelect();
                    }
                },
            },
        },
    });

    // Añadir el nuevo evento input
    $(`#${name}_name`).on("input", function(e) {
        if (typeof onInput === "function") {
            onInput();
        }else{
            $(`#${name}_id`).val("");
        }
    });
};
