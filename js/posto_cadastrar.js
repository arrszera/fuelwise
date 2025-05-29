const validations = {
    "input[name='nomePosto']": [
        {
            validate: (value) => value.trim().length == 0,
            message: "Campo obrigatório."
        },
        {
            validate: (value) => value.trim().length >= 2,
            message: "O nome deve conter pelo menos 2 caracteres."
        }
    ],
    "input[name='enderecoPosto']": [
        {
            validate: (value) => value.trim().length != 0,
            message: "Campo obrigatório."
        },
        {
            validate: (value) => value.trim().length >= 8,
            message: "Endereço Inválido."
        }
    ],
    "input[name='coordenadasPosto']": [
        {
            validate: (value) => value.trim().length != 0,
            message: "Campo obrigatório."
        },
    ],
}

document.addEventListener("DOMContentLoaded", () => {
    Object.keys(validations).forEach(name => {
        const field = document.querySelector(`${name}`)
        if (!field) return
        field.addEventListener("blur", () => {
            const rules = validations[name]
            let hint = field.parentElement.querySelector("p.hint")

            // verificar todas as regras, pegar a primeira que falhar
            const erro = rules.find(rule => !rule.validate(field.value))

            if (erro) {
                hint.textContent = erro.message
                hint.classList.remove("hidden")
                hint.classList.add("input-error")
            } else {
                hint.textContent = ""
                hint.classList.add("hidden")
                hint.classList.remove("input-error")
            }
        })
    })
})

function validarPosto(event, button){
    event.preventDefault(); // impede envio automático

    let valido = true;
    const form = button.closest("form"); // forma mais robusta

    Object.keys(validations).forEach(selector => {
        const field = form.querySelector(selector); // escopado ao form correto
        if (!field) return;

        const rules = validations[selector];
        const hint = field.parentElement.querySelector("p.hint");

        const erro = rules.find(rule => !rule.validate(field.value));

        if (erro) {
            hint.textContent = erro.message;
            hint.classList.remove("hidden");
            hint.classList.add("input-error");
            valido = false;
        } else {
            hint.textContent = "";
            hint.classList.add("hidden");
            hint.classList.remove("input-error");
        }
    })
    if (valido){
        form.submit()
    }
}