<?php 
    session_start();
    if (!(isset($_SESSION['id']))){
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Integrantes Cadastrados</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/solicitacoes_v2.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    <link href="../css/header.css" rel="stylesheet">
    <link href="../css/sidebar.css" rel="stylesheet">
    <link href="../css/cadastro.css" rel="stylesheet">
    <link href="../css/suporte.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <?php 
            include('../elements/sidebar.php'); 
            include('../elements/alert.php');
        ?>
    </div>
    <div class="main">
        <?php include('../elements/header.php'); ?>
        <div class="content">
            <div class="text-center">
				<div class="logo-circle" style="font-weight: 600; font-size: 2.5rem; color: white; background-color: #2563eb;">
					?
				</div>
				<h1 class="title">Registre um chamado</h1>
				<p class="subtitle">Preencha o formulário abaixo para enviar uma notificação ao suporte</p>
			</div>

		<div class="card">
		<div class="card-header">
			<h2>Suporte</h2>
		</div>

		<form class="form" method="POST" action="cadastro_transportadora_php.php" enctype="multipart/form-data">
			<div class="card-body">

			<div class="tab-content" id="empresa">
				<div class="form-group">
					<label>Motivo</label>
					<textarea maxlength="250" style="height: 150px" oninput="atualizarContador()" placeholder="Detalhe aqui o motivo de sua chamada" id="motivo" name="motivo"> </textarea>
					<p class="hint">Explique detalhadamente o ocorrido para receber o suporte mais eficiente. (<span id="contador">Caracteres restantes: 250</span>)</p>
				</div>
				<br>
				<div class="form-group">
					<label>Anexos</label>
					<input style="display: none" type="file" name="anexo[]" id="anexo" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" multiple>
					<label style="width: fit-content; font-size: 0.8rem" for="anexo" class="btn">Selecionar arquivo</label>
					<br>
					<div>Arquivos</div>
					<p class="hint" id="file-list" name="file-list">Nenhum arquivo selecionado</p>
					<br>
					<p class="hint">Você pode anexar imagens (JPG, PNG) ou documentos (PDF, DOC).</p>
				</div>
				
				<div class="form-actions right">
				<button class="btn primary" type="button" onclick="alterarAba('empresa', 'pessoal')">Enviar chamado</button>
				</div>

			</div>
			</div>
		</form>
		</div>
	</div>
    </div>	

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/index.js"></script>

  <script>
	const icons = {
		x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
	}

    let selectedFiles = []

    document.getElementById('anexo').addEventListener('change', function () {
		for (let file of this.files) {
			selectedFiles.push(file)
		}
		renderFileList()
		resetFileInput()
    })

    function renderFileList() {
		const fileList = document.getElementById('file-list')
		fileList.innerHTML = ''

		if (selectedFiles.length === 0) {
			fileList.innerHTML = '<p class="hint">Nenhum arquivo selecionado</p>'
			return
		}

		selectedFiles.forEach((file, index) => {
			const item = document.createElement('div')
			item.className = 'file-list-item'
			item.innerHTML = `
			<span>${file.name}</span>
			<button class="btn-icon btn-deny" onclick="removeFile(${index})">
				${icons.x}
			</button>
			`
			fileList.appendChild(item)
		})
    }

    function removeFile(index) {
		selectedFiles.splice(index, 1)
		renderFileList()
		resetFileInput()
    }

    function resetFileInput() {
		const dataTransfer = new DataTransfer()
		selectedFiles.forEach(file => dataTransfer.items.add(file))
		const input = document.getElementById('anexo')
		input.files = dataTransfer.files
    }

	function atualizarContador() {
		const textarea = document.getElementById('motivo')
		const contador = document.getElementById('contador')
		const length = textarea.value.length
		contador.textContent = `Caracteres restantes: ${250 - length}`
		if (length > 220){
			contador.style.color = "red"
		} else {
			contador.style.color = "#333"
		}
	}
  </script>
</body>
</html>
