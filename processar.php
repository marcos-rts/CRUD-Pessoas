<?php
require_once 'conexao.php';
require_once 'funcoes.php';

$acao = $_GET['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'adicionar':
            $dados = $_POST;
            if (adicionarColaborador($pdo, $dados)) {
                header('Location: index.php?sucesso=1');
            } else {
                header('Location: index.php?erro=1');
            }
            break;
            
        case 'editar':
            $dados = $_POST;
            if (atualizarColaborador($pdo, $dados)) {
                header('Location: index.php?sucesso=2');
            } else {
                header('Location: index.php?erro=2');
            }
            break;
            
        case 'excluir':
            $id = $_POST['id'];
            if (excluirColaborador($pdo, $id)) {
                header('Location: index.php?sucesso=3');
            } else {
                header('Location: index.php?erro=3');
            }
            break;
            
        default:
            header('Location: index.php');
            break;
    }
    exit;
}

// Para requisições AJAX
if (isset($_GET['id']) && in_array($acao, ['visualizar', 'editar'])) {
    $id = $_GET['id'];
    $colaborador = buscarColaborador($pdo, $id);
    
    if (!$colaborador) {
        http_response_code(404);
        exit;
    }
    
    if ($acao === 'visualizar') {
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        echo '<p><strong>ID:</strong> ' . $colaborador['id'] . '</p>';
        echo '<p><strong>Nome:</strong> ' . htmlspecialchars($colaborador['nome']) . '</p>';
        echo '<p><strong>CPF:</strong> ' . formatarCPF($colaborador['cpf']) . '</p>';
        echo '<p><strong>Data de Nascimento:</strong> ' . formatarData($colaborador['data_nascimento']) . '</p>';
        echo '<p><strong>E-mail:</strong> ' . htmlspecialchars($colaborador['email']) . '</p>';
        echo '<p><strong>Telefone:</strong> ' . formatarTelefone($colaborador['telefone']) . '</p>';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<p><strong>Cargo:</strong> ' . htmlspecialchars($colaborador['cargo']) . '</p>';
        echo '<p><strong>Departamento:</strong> ' . htmlspecialchars($colaborador['departamento']) . '</p>';
        echo '<p><strong>Data de Admissão:</strong> ' . formatarData($colaborador['data_admissao']) . '</p>';
        echo '<p><strong>Salário:</strong> ' . formatarMoeda($colaborador['salario']) . '</p>';
        echo '<p><strong>Status:</strong> <span class="badge ' . ($colaborador['ativo'] ? 'bg-success' : 'bg-secondary') . '">';
        echo $colaborador['ativo'] ? 'Ativo' : 'Inativo';
        echo '</span></p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="row mt-3">';
        echo '<div class="col-12">';
        echo '<p><strong>Endereço:</strong></p>';
        echo '<p>' . nl2br(htmlspecialchars($colaborador['endereco'])) . '</p>';
        echo '</div>';
        echo '</div>';
    } elseif ($acao === 'editar') {
        echo '<div class="row">';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_nome" class="form-label">Nome Completo</label>';
        echo '<input type="text" class="form-control" id="editar_nome" name="nome" value="' . htmlspecialchars($colaborador['nome']) . '" required>';
        echo '</div>';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_cpf" class="form-label">CPF</label>';
        echo '<input type="text" class="form-control" id="editar_cpf" name="cpf" value="' . htmlspecialchars($colaborador['cpf']) . '" required>';
        echo '</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_data_nascimento" class="form-label">Data de Nascimento</label>';
        echo '<input type="date" class="form-control" id="editar_data_nascimento" name="data_nascimento" value="' . $colaborador['data_nascimento'] . '" required>';
        echo '</div>';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_email" class="form-label">E-mail</label>';
        echo '<input type="email" class="form-control" id="editar_email" name="email" value="' . htmlspecialchars($colaborador['email']) . '" required>';
        echo '</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_telefone" class="form-label">Telefone</label>';
        echo '<input type="text" class="form-control" id="editar_telefone" name="telefone" value="' . htmlspecialchars($colaborador['telefone']) . '" required>';
        echo '</div>';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_cargo" class="form-label">Cargo</label>';
        echo '<input type="text" class="form-control" id="editar_cargo" name="cargo" value="' . htmlspecialchars($colaborador['cargo']) . '" required>';
        echo '</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_departamento" class="form-label">Departamento</label>';
        echo '<input type="text" class="form-control" id="editar_departamento" name="departamento" value="' . htmlspecialchars($colaborador['departamento']) . '" required>';
        echo '</div>';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_data_admissao" class="form-label">Data de Admissão</label>';
        echo '<input type="date" class="form-control" id="editar_data_admissao" name="data_admissao" value="' . $colaborador['data_admissao'] . '" required>';
        echo '</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_salario" class="form-label">Salário</label>';
        echo '<input type="number" step="0.01" class="form-control" id="editar_salario" name="salario" value="' . $colaborador['salario'] . '" required>';
        echo '</div>';
        echo '<div class="col-md-6 mb-3">';
        echo '<label for="editar_ativo" class="form-label">Status</label>';
        echo '<select class="form-select" id="editar_ativo" name="ativo" required>';
        echo '<option value="1"' . ($colaborador['ativo'] ? ' selected' : '') . '>Ativo</option>';
        echo '<option value="0"' . (!$colaborador['ativo'] ? ' selected' : '') . '>Inativo</option>';
        echo '</select>';
        echo '</div>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="editar_endereco" class="form-label">Endereço Completo</label>';
        echo '<textarea class="form-control" id="editar_endereco" name="endereco" rows="3" required>' . htmlspecialchars($colaborador['endereco']) . '</textarea>';
        echo '</div>';
    }
    exit;
}
?>