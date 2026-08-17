<?php
// DATABASE CONNECTIE
$host = "localhost";
$port = 8889;
$dbname = "databank_php";
$username = "root";
$password = "root";

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// INCLUDES HEADER
include 'includes/header.php';

// CONTENT OPHALEN AFHANKELIJK VAN GET PARAMETER
if (isset($_GET['onderwerp']) && is_numeric($_GET['onderwerp'])) {
    // Specifiek onderwerp ophalen
    $id = intval($_GET['onderwerp']);
    $stmt = $pdo->prepare("SELECT * FROM onderwerpen WHERE onderwerpen_id = :id");
    $stmt->execute(['id' => $id]);
    $onderwerpen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Alle onderwerpen ophalen
    $stmt = $pdo->query("SELECT * FROM onderwerpen");
    $onderwerpen = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// CONTENT TONEN
foreach ($onderwerpen as $rij): ?>
    <div style="margin-bottom:30px;">
        <h2><?= htmlspecialchars($rij['name']) ?></h2>
         <div>
        <?= $rij['description'] ?>  <!-- Let op: NIET htmlspecialchars -->
    </div>
		
        <img src="/Dynamische-pagina/<?= $rij['image'] ?>" alt="<?= htmlspecialchars($rij['name']) ?>" width="200">
    </div>
<?php endforeach;

// INCLUDES FOOTER
include 'includes/footer.php';
?>
