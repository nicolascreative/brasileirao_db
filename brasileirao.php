<?php
// Conexao com o banco PostgreSQL
$conn = pg_connect("host=localhost port=5432 dbname=brasileirao_db user=postgres password=1809");

if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

// Consulta clubes, estadios e participacoes no Campeonato Brasileiro Serie A
$sql = "SELECT
            clubes.nome AS clube,
            clubes.sigla,
            estadios.nome AS estadio,
            participacoes.qtd_participacoes,
            participacoes.titulos,
            participacoes.vices
        FROM clubes
        INNER JOIN estadios
            ON clubes.id_estadio = estadios.id_estadio
        INNER JOIN participacoes
            ON clubes.id_clube = participacoes.id_clube
        INNER JOIN competicoes
            ON participacoes.id_competicao = competicoes.id_competicao
        WHERE competicoes.nome = 'Campeonato Brasileiro Serie A'
        ORDER BY participacoes.titulos DESC, clubes.nome ASC";

$resultado = pg_query($conn, $sql);

if (!$resultado) {
    die("Erro ao executar a consulta.");
}

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas do Brasileirão</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f4f8; color: #222; margin: 0; padding: 30px; }
        main { max-width: 1100px; margin: auto; background: white; padding: 24px; border-radius: 12px; box-shadow: 0 3px 12px rgba(0,0,0,.08); }
        h1 { text-align: center; color: #174b32; margin-top: 0; }
        p { text-align: center; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #174b32; color: white; }
        tr:nth-child(even) { background: #f7f9f8; }
        tr:hover { background: #eaf3ed; }
        .numero { text-align: center; }
        @media (max-width: 700px) {
            body { padding: 10px; }
            main { padding: 12px; overflow-x: auto; }
            th, td { padding: 8px; white-space: nowrap; }
        }
    </style>
</head>
<body>
<main>
    <h1>Brasileirão – Estatísticas dos Clubes</h1>
    <p>Clubes, estádios, participações, títulos e vice-campeonatos</p>

    <table>
        <thead>
            <tr>
                <th>Clube</th>
                <th>Sigla</th>
                <th>Estádio</th>
                <th class="numero">Participações</th>
                <th class="numero">Títulos</th>
                <th class="numero">Vices</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($linha = pg_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?= h($linha['clube']) ?></td>
                <td><?= h($linha['sigla']) ?></td>
                <td><?= h($linha['estadio']) ?></td>
                <td class="numero"><?= h($linha['qtd_participacoes']) ?></td>
                <td class="numero"><?= h($linha['titulos']) ?></td>
                <td class="numero"><?= h($linha['vices']) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</main>
</body>
</html>
<?php
pg_close($conn);
?>
