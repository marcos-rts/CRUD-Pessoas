<?php
function listarColaboradores($pdo) {
    $sql = "SELECT * FROM colaboradores ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarColaborador($pdo, $id) {
    $sql = "SELECT * FROM colaboradores WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function adicionarColaborador($pdo, $dados) {
    $sql = "INSERT INTO colaboradores (nome, cpf, data_nascimento, email, telefone, cargo, departamento, data_admissao, salario, endereco, ativo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $dados['nome'],
        $dados['cpf'],
        $dados['data_nascimento'],
        $dados['email'],
        $dados['telefone'],
        $dados['cargo'],
        $dados['departamento'],
        $dados['data_admissao'],
        $dados['salario'],
        $dados['endereco'],
        $dados['ativo']
    ]);
}

function atualizarColaborador($pdo, $dados) {
    $sql = "UPDATE colaboradores SET 
            nome = ?,
            cpf = ?,
            data_nascimento = ?,
            email = ?,
            telefone = ?,
            cargo = ?,
            departamento = ?,
            data_admissao = ?,
            salario = ?,
            endereco = ?,
            ativo = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $dados['nome'],
        $dados['cpf'],
        $dados['data_nascimento'],
        $dados['email'],
        $dados['telefone'],
        $dados['cargo'],
        $dados['departamento'],
        $dados['data_admissao'],
        $dados['salario'],
        $dados['endereco'],
        $dados['ativo'],
        $dados['id']
    ]);
}

function excluirColaborador($pdo, $id) {
    $sql = "DELETE FROM colaboradores WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

function formatarCPF($cpf) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
}

function formatarData($data) {
    return date('d/m/Y', strtotime($data));
}

function formatarTelefone($telefone) {
    $tam = strlen($telefone);
    if ($tam == 10) {
        return preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $telefone);
    } elseif ($tam == 11) {
        return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $telefone);
    }
    return $telefone;
}

function formatarMoeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}
?>