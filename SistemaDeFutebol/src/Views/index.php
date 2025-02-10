<?php

require __DIR__ . '/../Controller/index.php';
require __DIR__ . '/../../env.php';

$nomeTime = (string) "";
$contador = (int) 0;
$data = [];
if (isset($_POST["btnBuscar"])) {

  $nomeTime = $_POST['nomeTime'];

}

if (isset($_POST["btnlimpar"])) {

  $contador = (int) null;
  $nomeTime = (string) null;
}

$res = ApiController();
$data = $res;

if (!empty($nomeTime)) {
  $data = array_filter($data, function ($jogo) use ($nomeTime) {
    $homeTeam = strtolower($jogo["homeTeam"]["name"]);
    $awayTeam = strtolower($jogo["awayTeam"]["name"]);
    $nomeTimeLower = strtolower($nomeTime);

    return strpos($homeTeam, $nomeTimeLower) !== false || strpos($awayTeam, $nomeTimeLower) !== false;
  });
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../public/css/index.css">
  <title>Document</title>
</head>

<body>


  <div>
    <form name="buscarTime" class="container-form" method="post" action="">
      <input type="text" name="nomeTime" placeholder="nome">
      <input type="submit" name="btnBuscar" value="Buscar" placeholder="Buscar">
      <input type="submit" name="btnlimpar" value="Limpar" placeholder="Buscar">
    </form>
  </div>

  <main>
    <section>
      <table>
        <h1>Jogos <?= $nomeTime ? $nomeTime : "" ?> </h1>
        <tr>
          <th>Casa</th>
          <th>x</th>
          <th>Fora</th>
          <th>Data</th>
        </tr>

        <?php
        if ((!empty($data))) {
          foreach ($data as $jogo) {
            if (
              $jogo["homeTeam"] == null || $jogo["homeTeam"]["id"] == null || $jogo["homeTeam"]["id"] == null ||
              $jogo["awayTeam"] == null || $jogo["awayTeam"]["id"] == null || $jogo["awayTeam"]["id"] == null
            ) {
            }
            ?>
            <tr>
              <?php
              $jogo["id"]
                ?>
              <td>
                <img src='<?php echo $jogo["homeTeam"]["crest"]; ?>' />
                <?php echo htmlspecialchars($jogo['homeTeam']['name']);
                $jogo["homeTeam"]["id"] ?>
              </td>

              <td>⚽ X</td>

              <td>
                <img src='<?php echo $jogo["awayTeam"]["crest"]; ?>' />
                <?php echo htmlspecialchars($jogo["awayTeam"]["name"]);
                $jogo["homeTeam"]["id"] ?>
              </td>

              <td>
                <?php
                $data_iso = $jogo["utcDate"];
                $dataHora = new DateTime($data_iso, new DateTimeZone("UTC"));
                $dataHora->setTimezone(new DateTimeZone("America/Sao_Paulo"));

                echo $dataHora->format("d/m/Y H:i:s");

                ?>
              </td>

            </tr>

            <tr>
              <td>
                <?php echo $jogo["score"]["fullTime"]["home"] + $jogo["score"]["halfTime"]["home"] ?>
              </td>
              <td>
                x
              </td>
              <td>
                <?php echo $jogo["score"]["fullTime"]["away"] + $jogo["score"]["halfTime"]["away"] ?>
              </td>
              <td>
                <?php
                if ($jogo["score"]["winner"] == "HOME_TEAM") {
                  echo $jogo["homeTeam"]["name"];
                } elseif ($jogo["score"]["winner"] == "AWAY_TEAM") {
                  echo $jogo["awayTeam"]["name"];
                } else if ($jogo["score"]["winner"] == "DRAW") {
                  echo "Empate";
                } else {
                  echo "Em breve";
                }
                ?>
              </td>
            </tr>

            <?php $contador++;
          } ?>

        <?php } else { ?>
          <tr>
            <td colspan="6">Nenhum jogo encontrado para "<?php echo htmlspecialchars($nomeTime); ?>"</td>
          </tr>
        <?php } ?>

      </table>

    </section>

  </main>
</body>

</html>