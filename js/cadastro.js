document.addEventListener("DOMContentLoaded", () => {
    const validations = {
        "textarea[name='endereco']": [
            {
            validate: (value) => value.trim().length > 0,
            message: "Campo obrigatório."
            }
        ],
        "input[name='nomeEmpresa']": [
            {
            validate: (value) => value.trim().length > 1,
            message: "O nome deve ter ao menos 2 caracteres."
            }
        ],
        "input[name='telefoneEmpresa']": [
            {
            validate: (value) => /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(value),
            message: "Formato de telefone inválido. Ex: (11) 98765-4321"
            }
        ],
        "input[name='telefonePessoal']": [
            {
            validate: (value) => /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(value),
            message: "Formato de telefone inválido. Ex: (11) 98765-4321"
            }
        ],
        "input[name='cnpj']": [
            {
            validate: (value) => /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/.test(value),
            message: "Formato de CNPJ inválido."
            },
            {
            validate: (value) => validarCNPJ(value),
            message: "CNPJ inválido."
            }
        ],
        "input[name='email']": [
            {
            validate: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: "E-mail inválido."
            }
        ],
        "input[name='senha']": [
            {
            validate: (value) => value.length >= 8,
            message: "A senha deve ter pelo menos 8 caracteres."
            }
        ],
        "input[name='cidade']": [
            {
            validate: (value) => value.length >= 2,
            message: "Formato inválido."
            }
        ],
        "input[name='estado']": [
            {
            validate: (value) => value.length == 2,
            message: "Formato de estado inválido."
            }
        ],
        "input[name='cep']": [
            {
            validate: (value) => value.length >= 8,
            message: "Formato de CEP inválido."
            }
        ]
    };

    Object.keys(validations).forEach(name => {
        const field = document.querySelector(`${name}`);
        if (!field) return
        field.addEventListener("blur", () => {
            const rules = validations[name];
            let hint = field.parentElement.querySelector("p.hint");
            if (!hint) {
                hint = document.createElement("p");
                hint.classList.add("hint");
                field.parentElement.appendChild(hint);
            }

            // verificar todas as regras, pegar a primeira que falhar
            const erro = rules.find(rule => !rule.validate(field.value));

            if (erro) {
                hint.textContent = erro.message;
                hint.classList.remove("hidden");
                hint.classList.add("input-error");
            } else {
                hint.textContent = "";
                hint.classList.add("hidden");
                hint.classList.remove("input-error");
            }
        })
    })

    // botoes do cadastro
    document.querySelector('.btn.primary').addEventListener('click', (e) => {
      e.preventDefault();
      alterarAba('empresa', 'pessoal');
    });

    document.querySelector('.form-actions .btn[type="button"]').addEventListener('click', () => {
      alterarAba('pessoal', 'empresa', false);
    });
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const alvo = button.getAttribute('data-tab');
            const ativo = document.querySelector('.tab-btn.active').getAttribute('data-tab');

            // Só executa se clicar em uma aba diferente
            if (alvo === ativo) return;

            // Se a aba atual for "empresa", exige validação antes de mudar
            if (ativo === 'empresa') {
                alterarAba('empresa', 'pessoal');
            } else {
                alterarAba('pessoal', 'empresa', false); // permite voltar sem validação
            }
        });
    })
});

function validarCNPJ(cnpj){
    cnpj = cnpj.replace(/[^\d]+/g,'');

  if(cnpj.length !== 14)
    return false;

  let tamanho = 12;
  let numeros = cnpj.substring(0, tamanho);
  let digitos = cnpj.substring(tamanho);
  let soma = 0;
  let pos = tamanho - 7;

  for(let i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if(pos < 2) pos = 9;
  }

  let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
  if(resultado != digitos.charAt(0))
    return false;

  tamanho = 13;
  numeros = cnpj.substring(0, tamanho);
  soma = 0;
  pos = tamanho - 7;

  for(let i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if(pos < 2) pos = 9;
  }

  resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
  if(resultado != digitos.charAt(1))
    return false;

  return true;
}

function alterarAba(de, para, validar=true){
    const abaAtual = document.getElementById(de);
    const inputs = abaAtual.querySelectorAll('input, textarea');
    
    if (validar) {
        let valido = true;
        inputs.forEach(input => {
        const hint = input.nextElementSibling;
        if (input.value.trim() === '') {
                valido = false;
                hint.textContent = 'Campo obrigatório';
                hint.classList.remove('hidden');
                hint.classList.add('input-error');
        } else {
                hint.classList.add('hidden');
                hint.textContent = '';
        }
        });
        
        if (!valido) return;
    }

    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    document.getElementById(para).classList.remove('hidden');
    document.querySelector(`.tab-btn[data-tab="${para}"]`).classList.add('active');
    document.querySelector(`.tab-btn[data-tab="${para}"]`).disabled = false;
}
