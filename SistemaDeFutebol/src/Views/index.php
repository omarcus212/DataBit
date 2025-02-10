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
              $data[$contador]["homeTeam"] == null || $data[$contador]["homeTeam"]["id"] == null || $data[$contador]["homeTeam"]["id"] == null ||
              $data[$contador]["awayTeam"] == null || $data[$contador]["awayTeam"]["id"] == null || $data[$contador]["awayTeam"]["id"] == null
            ) {
            }
            ?>
            <tr>
              <?php
              $data[$contador]["id"]
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
                $data_iso = $data[$contador]["utcDate"];
                $dataHora = new DateTime($data_iso, new DateTimeZone("UTC"));
                $dataHora->setTimezone(new DateTimeZone("America/Sao_Paulo"));

                echo $dataHora->format("d/m/Y H:i:s");

                ?>
              </td>

            </tr>

            <tr>
              <td>
                <?php echo $data[$contador]["score"]["fullTime"]["home"] + $data[$contador]["score"]["halfTime"]["home"] ?>
              </td>
              <td>
                x
              </td>
              <td>
                <?php echo $data[$contador]["score"]["fullTime"]["away"] + $data[$contador]["score"]["halfTime"]["away"] ?>
              </td>
              <td>
                <?php
                if ($data[$contador]["score"]["winner"] == "HOME_TEAM") {
                  echo $data[$contador]["homeTeam"]["name"];
                } elseif ($data[$contador]["score"]["winner"] == "AWAY_TEAM") {
                  echo $data[$contador]["awayTeam"]["name"];
                } else if ($data[$contador]["score"]["winner"] == "DRAW") {
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