<?php
// Conexao com o banco PostgreSQL
$conn = pg_connect("host=localhost port=5432 dbname=brasileirao_db user=postgres password=1809");

if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

// Recebe os filtros da pagina
$busca = $_GET['busca'] ?? '';
$ordenacao = $_GET['ordenacao'] ?? 'titulos';

// Opcoes permitidas para ordenacao
$ordens = [
    'nome' => 'clubes.nome ASC',
    'titulos' => 'participacoes.titulos DESC, clubes.nome ASC',
    'vices' => 'participacoes.vices DESC, clubes.nome ASC',
    'participacoes' => 'participacoes.qtd_participacoes DESC, clubes.nome ASC'
];

// Impede ordenacoes nao permitidas
if (!array_key_exists($ordenacao, $ordens)) {
    $ordenacao = 'titulos';
}

$orderSQL = $ordens[$ordenacao];

// Consulta ao banco
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
        AND (
            clubes.nome ILIKE $1
            OR clubes.sigla ILIKE $1
            OR estadios.nome ILIKE $1
        )
        ORDER BY $orderSQL";

// Executa a consulta com parametro de pesquisa
$parametro = "%" . $busca . "%";
$resultado = pg_query_params($conn, $sql, [$parametro]);

if (!$resultado) {
    die("Erro ao executar a consulta.");
}

// Quantidade de resultados
$total = pg_num_rows($resultado);

// Protege os dados exibidos na pagina
function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Estatisticas do Brasileirao</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f4f8;
            color: #222;
            margin: 0;
            padding: 30px;
        }

        main {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        h1 {
            text-align: center;
            color: #174b32;
            margin-top: 0;
        }

        .descricao {
            text-align: center;
            color: #555;
        }

        /* Area de pesquisa */

        .filtros {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        input, select, button, .limpar {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input {
            flex: 2;
            min-width: 180px;
        }

        select {
            flex: 1;
            min-width: 160px;
            background: white;
        }

        button {
            background: #174b32;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #236c48;
        }

        .limpar {
            background: #e9ecef;
            color: #333;
            text-decoration: none;
        }

        .limpar:hover {
            background: #d8dde2;
        }

        /* Contador */

        .contador {
            background: #eaf3ed;
            padding: 12px;
            border-radius: 6px;
            color: #174b32;
            margin-bottom: 15px;
        }

        /* Tabela */

        .tabela-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #174b32;
            color: white;
        }

        tr:nth-child(even) {
            background: #f7f9f8;
        }

        tr:hover {
            background: #eaf3ed;
        }

        .numero {
            text-align: center;
        }

        .vazio {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        footer {
            text-align: center;
            color: #777;
            margin-top: 25px;
            font-size: 13px;
        }

        /* Adaptacao para celular */

        @media (max-width: 700px) {
            body {
                padding: 10px;
            }

            main {
                padding: 14px;
            }

            .filtros {
                flex-direction: column;
            }

            input, select, button, .limpar {
                width: 100%;
            }

            th, td {
                padding: 9px;
                white-space: nowrap;
            }
        }
    </style>

</head>

<body>

<main>

    <h1>Brasileirão – Estatísticas dos Clubes</h1>

    <p class="descricao">
        Consulte informações sobre os clubes do Campeonato Brasileiro Série A.
    </p>

    <!-- Formulario de pesquisa e ordenacao -->

    <form method="GET" class="filtros">

        <input
            type="text"
            name="busca"
            placeholder="Pesquisar clube, sigla ou estádio..."
            value="<?= h($busca) ?>"
        >

        <select name="ordenacao">

            <option value="titulos" <?= $ordenacao == 'titulos' ? 'selected' : '' ?>>
                Maior número de títulos
            </option>

            <option value="vices" <?= $ordenacao == 'vices' ? 'selected' : '' ?>>
                Maior número de vices
            </option>

            <option value="participacoes" <?= $ordenacao == 'participacoes' ? 'selected' : '' ?>>
                Mais participações
            </option>

            <option value="nome" <?= $ordenacao == 'nome' ? 'selected' : '' ?>>
                Ordem alfabética
            </option>

        </select>

        <button type="submit">Pesquisar</button>

        <a href="index.php" class="limpar">Limpar filtros</a>

    </form>

    <!-- Contador de resultados -->

    <div class="contador">
        <strong><?= $total ?></strong>
        clube(s) encontrado(s).
    </div>

    <!-- Tabela de resultados -->

    <div class="tabela-container">

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

            <?php if ($total > 0) { ?>

                <?php while ($linha = pg_fetch_assoc($resultado)) { ?>

                    <tr>

                        <td><?= h($linha['clube']) ?></td>

                        <td><?= h($linha['sigla']) ?></td>

                        <td><?= h($linha['estadio']) ?></td>

                        <td class="numero">
                            <?= h($linha['qtd_participacoes']) ?>
                        </td>

                        <td class="numero">
                            <?= h($linha['titulos']) ?>
                        </td>

                        <td class="numero">
                            <?= h($linha['vices']) ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="6" class="vazio">
                        Nenhum clube encontrado.
                        Tente outra pesquisa.
                    </td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

    <footer>
        Sistema de Consulta – História do Futebol Brasileiro
    </footer>

</main>

</body>
</html>

<?php
// Fecha a conexao com o banco
pg_close($conn);
?>