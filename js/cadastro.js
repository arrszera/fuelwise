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
            validate: (value) => value.replace(/\D/g, '').length == 8,
            message: "Formato de CEP inválido."
        }
    ],
    "input[name='nomePessoal']":[
        {
            validate: (value) => value.length >= 2,
            message: "Nome muito Curto."
        }
    ],
    "input[name='sobrenome']":[
        {
            validate: (value) => value.length >= 2,
            message: "Sobrenome muito Curto."
        }
    ],
    "input[name='senha']":[
        {
            validate: (value) => value.length >= 8,
            message: "Senha muito curta."
        },
        {
            validate: (value) => /[!@#$%^&*()\-_=+\[\]{};:,.?\/|~`]/.test(value),
            message: "Sua senha deve conter ao menos um caractere especial."
        },
    ],
    "input[name='confirmarSenha']":[
        {
            validate: (value) => value == document.querySelector('[name="senha"]').value,
            message: "As senhas não coincidem."
        }
    ],
}

document.addEventListener("DOMContentLoaded", () => {
    // adiciona as regras conforme o elemento
    Object.keys(validations).forEach(name => {
        const field = document.querySelector(`${name}`);
        if (!field) return
        field.addEventListener("blur", () => {
            const rules = validations[name];
            let hint = field.parentElement.querySelector("p.hint");

            // verificar todas as regras, pegar a primeira que falhar
            const erro = rules.find(rule => !rule.validate(field.value));

            if (erro) {
                hint.textContent = erro.message;
                hint.classList.remove("hidden");
                hint.classList.add("input-error");
            } else {
                hint.textContent = "";
                // hint.classList.add("hidden");
                hint.classList.remove("input-error");
                switch (field.name) {
                    case 'cnpj':
                        hint.textContent = 'Número de Identificação Fiscal da Empresa';
                        break;
                    case 'email':
                        hint.textContent = 'Este será seu usuário para login';
                        break;
                    case 'senha':
                        hint.textContent = 'A senha deve ter ao menos 8 caracteres';
                        break;
                    default:
                        hint.textContent = '';
                }
            }
        })
    })

    // verificacao na troca de aba
    // document.querySelector('#pessoal form').addEventListener('submit', (e) => {
    //     const inputs = document.querySelectorAll('input, textarea');
    //     let isValid = true;

    //     inputs.forEach(input => {
    //         const name = input.getAttribute('name');
    //         const selector = input.tagName.toLowerCase() === 'textarea'
    //         ? `textarea[name="${name}"]`
    //         : `input[name="${name}"]`;

    //         const rules = validations[selector];
    //         const hint = input.parentElement.querySelector("p.hint");

    //         if (rules) {
    //             const error = rules.find(rule => !rule.validate(input.value));
    //             if (error) {
    //                 hint.textContent = error.message;
    //                 hint.classList.remove("hidden");
    //                 hint.classList.add("input-error");
    //                 isValid = false;
    //             } else {
    //                 hint.textContent = "";
    //                 hint.classList.add("hidden");
    //                 hint.classList.remove("input-error");
    //             }
    //         }
    //     })

    //     if (!isValid) {
    //         e.preventDefault(); // impede o envio se houver erros
    //     }
    // })

    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const alvo = button.getAttribute('data-tab');
            const ativo = document.querySelector('.tab-btn.active').getAttribute('data-tab');

            // só executa se clicar em uma aba diferente
            if (alvo === ativo) return;

            // se a aba atual for "empresa", exige validação antes de mudar
            if (ativo === 'empresa') {
                alterarAba('empresa', 'pessoal');
            } else {
                alterarAba('pessoal', 'empresa', false); // permite voltar sem validação
            }
        });
    })

    // autocomplete do cep
    let elementoCep = document.querySelector('[name="cep"]')
    elementoCep.addEventListener('blur', () =>{
        const cep = elementoCep.value.replace(/\D/g, '');
        if (cep.length === 8) {
            buscarCEP(cep)
        }
    })

    // verificacao de formularios nos envios
    // TODO
    // document.querySelector('#pessoal form').addEventListener('submit', (e) => {
    //     if (!validarFormularioCompleto()) {
    //         e.preventDefault();
    //         alert('Corrija os erros no formulário antes de enviar.')
    //     }
    // })

    // document.querySelector('#empresa form').addEventListener('submit', (e) => {
    //     if (!validarFormularioCompleto()) {
    //         e.preventDefault();
    //         alert('Corrija os erros no formulário antes de enviar.')
    //     }
    // })
})

function validarFormularioCompleto(event, button) {
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
        // hint.classList.add("hidden");
        hint.classList.remove("input-error");
        switch (field.name) {
            case 'cnpj':
                hint.textContent = 'Número de Identificação Fiscal da Empresa';
                break;
            case 'email':
                hint.textContent = 'Este será seu usuário para login';
                break;
            case 'senha':
                hint.textContent = 'A senha deve ter ao menos 8 caracteres';
                break;
            default:
                hint.textContent = '';
        }
    }
  });

  if (valido) {
    form.submit();
  } else {
    Swal.fire({
        title:'Preencha corretamente os dados', 
        text:'Há dados que precisam de alteração', 
        icon:'question', 
        iconColor: "#fedf00"
    })
  }
}

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

async function buscarCEP(cep) {
    try {
      const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
      const data = await response.json();
      if (data.erro) {
        return;
      }
      
      document.querySelector('[name="cidade"]').value = data.localidade
      document.querySelector('[name="estado"]').value = data.uf
      document.querySelector('[name="endereco"]').value = data.logradouro


    } catch (error) {
      console.error(error);
    }
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
                switch (input.name) {
                    case 'cnpj':
                        hint.textContent = 'Número de Identificação Fiscal da Empresa';
                        break;
                    case 'email':
                        hint.textContent = 'Este será seu usuário para login';
                        break;
                    case 'senha':
                        hint.textContent = 'A senha deve ter ao menos 8 caracteres';
                        break;
                    default:
                        hint.textContent = '';
                }
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
