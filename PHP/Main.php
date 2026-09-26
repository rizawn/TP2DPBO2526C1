<?php
require_once __DIR__ . '/FilmAnimasi3D.php';

// Setter milik ketiga class dapat dipanggil melalui objek turunan terakhir.
function buatFilm($idFilm, $judul, $genre, $durasi, $studio, $negaraAsal,
    $targetUsia, $software3D, $mesinRender, $formatModel, $foto_produk)
{
    $film = new FilmAnimasi3D();
    $film->setId($idFilm);
    $film->setJudul($judul);
    $film->setGenre($genre);
    $film->setDurasi($durasi);
    $film->setStudio($studio);
    $film->setNegaraAsal($negaraAsal);
    $film->setTargetUsia($targetUsia);
    $film->setSoftware3D($software3D);
    $film->setMesinRender($mesinRender);
    $film->setFormatModel($formatModel);
    $film->setFotoProduk($foto_produk);
    return $film;
}

function barisFilm($film)
{
    return [$film->getId(), $film->getJudul(), $film->getGenre(),
        $film->getDurasi(), $film->getStudio(), $film->getNegaraAsal(),
        $film->getTargetUsia(), $film->getSoftware3D(),
        $film->getMesinRender(), $film->getFormatModel()];
}

function gagalInput($pesan)
{
    fwrite(STDERR, 'Input tidak valid: ' . $pesan . PHP_EOL);
    exit(1);
}

function aman($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Poster ilustrasi disimpan dalam atribut, tanpa file gambar tambahan.
function buatPoster($judul, $nomor)
{
    $warna = ['#087f8c', '#4565ab', '#267b9b', '#488057', '#7752a5'];
    $latar = $warna[$nomor % count($warna)];
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="150" viewBox="0 0 120 150">'
        . '<title>' . aman($judul) . '</title>'
        . '<rect width="120" height="150" rx="10" fill="' . $latar . '"/>'
        . '<circle cx="84" cy="39" r="21" fill="#ffffff" opacity=".3"/>'
        . '<path d="M0 120 L43 51 L86 120 Z" fill="#ffffff" opacity=".6"/>'
        . '<path d="M44 120 L87 72 L120 120 Z" fill="#ffffff" opacity=".3"/>'
        . '<text x="12" y="28" fill="white" font-family="sans-serif" font-size="12">ANIMASI 3D</text>'
        . '<text x="12" y="140" fill="white" font-family="sans-serif" font-size="11">FILM '
        . ($nomor + 1) . '</text></svg>';
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

// Main: tepat lima objek awal sebelum penambahan dari file testcase.
$data = [
    buatFilm('F001', 'Petualangan Awan', 'Fantasi', 95,
        'Studio Langit', 'Indonesia', 'Semua umur', 'Blender', 'Cycles', 'FBX',
        buatPoster('Petualangan Awan', 0)),
    buatFilm('F002', 'Robot Kota', 'Fiksi ilmiah', 100,
        'Studio Mesin', 'Indonesia', '7+', 'Maya', 'Arnold', 'OBJ',
        buatPoster('Robot Kota', 1)),
    buatFilm('F003', 'Laut Biru', 'Petualangan', 88,
        'Studio Ombak', 'Indonesia', 'Semua umur', 'Blender', 'Eevee', 'GLTF',
        buatPoster('Laut Biru', 2)),
    buatFilm('F004', 'Hutan Cahaya', 'Fantasi', 105,
        'Studio Rimba', 'Indonesia', '7+', 'Maya', 'Arnold', 'FBX',
        buatPoster('Hutan Cahaya', 3)),
    buatFilm('F005', 'Jejak Bintang', 'Petualangan', 110,
        'Studio Orbit', 'Indonesia', '13+', 'Blender', 'Cycles', 'OBJ',
        buatPoster('Jejak Bintang', 4)),
];

// PHP boleh hardcode. Mode CLI tambahan: php Main.php file.txt > hasil.html
if (PHP_SAPI === 'cli') {
    if ($argc > 2) {
        gagalInput('Pemakaian: php Main.php [file.txt]');
    }
    if ($argc === 2) {
        if (!is_file($argv[1]) || !is_readable($argv[1])) {
            gagalInput('File input tidak ditemukan atau tidak dapat dibaca.');
        }
        $barisInput = @file($argv[1], FILE_IGNORE_NEW_LINES);
        if ($barisInput === false) {
            gagalInput('Gagal membaca file input.');
        }
        foreach ($barisInput as $index => $baris) {
            $nomor = $index + 1;
            for ($i = 0; $i < strlen($baris); $i++) {
                $kode = ord($baris[$i]);
                if ($kode < 32 || $kode === 127) {
                    gagalInput("Baris $nomor: karakter kontrol tidak diizinkan.");
                }
            }
            $kolom = explode('|', $baris);
            if (count($kolom) !== 10) {
                gagalInput("Baris $nomor: wajib 10 atribut, dipisahkan |.");
            }
            for ($i = 0; $i < count($kolom); $i++) {
                $kolom[$i] = trim($kolom[$i]);
                if ($kolom[$i] === '') {
                    gagalInput("Baris $nomor: atribut tidak boleh kosong.");
                }
            }
            if (!ctype_digit($kolom[3]) || strlen($kolom[3]) > 3
                || (int) $kolom[3] < 1 || (int) $kolom[3] > 999) {
                gagalInput("Baris $nomor: durasi wajib bilangan bulat 1 sampai 999.");
            }
            foreach ($data as $film) {
                if ($film->getId() === $kolom[0]) {
                    gagalInput("Baris $nomor: ID film sudah digunakan.");
                }
            }
            $data[] = buatFilm($kolom[0], $kolom[1], $kolom[2], (int) $kolom[3],
                $kolom[4], $kolom[5], $kolom[6], $kolom[7], $kolom[8], $kolom[9],
                buatPoster($kolom[1], count($data)));
        }
    }
} else {
    // Mode Web interaktif: menggunakan session untuk menampung film tambahan dari form.
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['film_tambahan'])) {
        $_SESSION['film_tambahan'] = [];
    }

    $pesanSukses = $_SESSION['pesan_sukses'] ?? '';
    $pesanError = $_SESSION['pesan_error'] ?? '';
    unset($_SESSION['pesan_sukses'], $_SESSION['pesan_error']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $aksi = trim($_POST['aksi'] ?? '');
        if ($aksi === 'reset') {
            $_SESSION['film_tambahan'] = [];
            $_SESSION['pesan_sukses'] = 'Data tabel berhasil di-reset ke 5 objek awal.';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } elseif ($aksi === 'tambah') {
            $id = trim($_POST['id_film'] ?? '');
            $judul = trim($_POST['judul'] ?? '');
            $genre = trim($_POST['genre'] ?? '');
            $durasi = trim($_POST['durasi'] ?? '');
            $studio = trim($_POST['studio'] ?? '');
            $negara = trim($_POST['negara_asal'] ?? '');
            $usia = trim($_POST['target_usia'] ?? '');
            $software = trim($_POST['software_3d'] ?? '');
            $mesin = trim($_POST['mesin_render'] ?? '');
            $format = trim($_POST['format_model'] ?? '');

            $daftarSemua = array_merge($data, $_SESSION['film_tambahan']);
            $idSudahAda = false;
            foreach ($daftarSemua as $f) {
                if ($f->getId() === $id) {
                    $idSudahAda = true;
                    break;
                }
            }

            if ($id === '' || $judul === '' || $genre === '' || $durasi === '' ||
                $studio === '' || $negara === '' || $usia === '' ||
                $software === '' || $mesin === '' || $format === '') {
                $_SESSION['pesan_error'] = 'Semua field wajib diisi dan tidak boleh kosong.';
            } elseif ($idSudahAda) {
                $_SESSION['pesan_error'] = "ID '$id' sudah digunakan! Masukkan ID unik lain.";
            } elseif (!ctype_digit($durasi) || strlen($durasi) > 3 || (int) $durasi < 1 || (int) $durasi > 999) {
                $_SESSION['pesan_error'] = 'Durasi harus berupa bilangan bulat positif 1 - 999 menit.';
            } else {
                $nomorPoster = count($daftarSemua);
                $poster = buatPoster($judul, $nomorPoster);
                $filmBaru = buatFilm($id, $judul, $genre, (int) $durasi, $studio, $negara, $usia, $software, $mesin, $format, $poster);
                $_SESSION['film_tambahan'][] = $filmBaru;
                $_SESSION['pesan_sukses'] = "Film '$judul' ($id) berhasil ditambahkan ke tabel!";
            }
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (!empty($_SESSION['film_tambahan'])) {
        $data = array_merge($data, $_SESSION['film_tambahan']);
    }
}

$header = ['ID Film', 'Judul', 'Genre', 'Durasi (menit)', 'Studio',
    'Negara Asal', 'Target Usia', 'Software 3D', 'Mesin Render', 'Format Model'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Film Animasi 3D — TP2</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f1f6f8; color: #203448; font: 15px/1.5 Arial, sans-serif; }
        main { max-width: 1700px; margin: 42px auto; padding: 0 24px; }
        .label { color: #087f8c; font-size: 12px; font-weight: bold; letter-spacing: 2px; }
        h1 { margin: 6px 0 10px; font-size: 32px; line-height: 1.2; }
        .intro { margin: 0 0 22px; color: #526779; }
        .info { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 14px; }
        .count { background: #deeff0; color: #075f68; padding: 7px 12px; border-radius: 6px; font-weight: bold; }
        .relation { font-size: 14px; color: #526779; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; font-size: 14px; }
        .alert-success { background: #e6f6ee; color: #0e623b; border: 1px solid #b7e4cf; }
        .alert-error { background: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; }
        .table-wrap { overflow-x: auto; border: 1px solid #cfdee4; border-radius: 10px; background: white; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; table-layout: auto; }
        caption { text-align: left; padding: 14px 18px; font-weight: bold; color: #294a5b; }
        th { background: #183b4b; color: white; text-align: left; font-size: 13px; }
        th, td { padding: 12px 14px; white-space: nowrap; border-bottom: 1px solid #e0e9ed; }
        tbody tr:nth-child(even) { background: #f6fafb; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #eaf5f5; }
        .poster { display: block; width: 64px; height: 80px; border-radius: 6px; }
        
        .form-card { background: white; border: 1px solid #cfdee4; border-radius: 10px; padding: 24px; margin-bottom: 30px; }
        .form-card h2 { margin: 0 0 6px; font-size: 20px; color: #183b4b; }
        .form-card p { margin: 0 0 20px; font-size: 14px; color: #526779; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: bold; color: #294a5b; }
        .form-group .source-class { font-size: 11px; font-weight: normal; color: #087f8c; margin-left: 4px; }
        .form-group input { padding: 9px 12px; border: 1px solid #cfdee4; border-radius: 6px; font-size: 14px; color: #203448; outline: none; }
        .form-group input:focus { border-color: #087f8c; box-shadow: 0 0 0 2px rgba(8, 127, 140, 0.15); }
        .form-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn { padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: bold; cursor: pointer; border: none; transition: 0.2s; }
        .btn-primary { background: #087f8c; color: white; }
        .btn-primary:hover { background: #066570; }
        .btn-secondary { background: #e4edf1; color: #294a5b; }
        .btn-secondary:hover { background: #d0dee4; }
        footer { color: #526779; font-size: 13px; margin-top: 16px; }
        @media (max-width: 640px) { main { margin: 24px auto; padding: 0 16px; } h1 { font-size: 26px; } .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<main>
    <div class="label">TP2 · PEMROGRAMAN BERORIENTASI OBJEK</div>
    <h1>Katalog Film Animasi 3D</h1>
    <p class="intro">Seluruh atribut film, animasi, dan produksi 3D dalam satu tabel.</p>

    <?php if (!empty($pesanSukses)): ?>
        <div class="alert alert-success"><?= aman($pesanSukses) ?></div>
    <?php endif; ?>
    <?php if (!empty($pesanError)): ?>
        <div class="alert alert-error"><?= aman($pesanError) ?></div>
    <?php endif; ?>

    <div class="info">
        <span class="count">Jumlah data: <?= aman(count($data)) ?></span>
        <span class="relation">Film → FilmAnimasi → FilmAnimasi3D</span>
    </div>
    <div class="table-wrap" role="region" aria-label="Tabel film, dapat digeser secara horizontal" tabindex="0">
        <table>
            <caption>Daftar film dan atribut lengkap</caption>
            <thead><tr>
                <?php foreach ($header as $judulKolom): ?>
                    <th scope="col"><?= aman($judulKolom) ?></th>
                <?php endforeach; ?>
                <th scope="col">Foto Produk</th>
            </tr></thead>
            <tbody>
            <?php foreach ($data as $film): ?>
                <tr>
                    <?php foreach (barisFilm($film) as $nilai): ?>
                        <td><?= aman($nilai) ?></td>
                    <?php endforeach; ?>
                    <td><img class="poster" src="<?= aman($film->getFotoProduk()) ?>"
                        alt="<?= aman('Poster ilustrasi ' . $film->getJudul()) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <section class="form-card">
        <h2>Tambah Data Film Animasi 3D (Add Saja)</h2>
        <p>Input data objek baru ke dalam sistem untuk menguji pewarisan atribut dari <code>Film</code>, <code>FilmAnimasi</code>, dan <code>FilmAnimasi3D</code>.</p>
        <form method="POST" action="">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-grid">
                <div class="form-group">
                    <label for="id_film">ID Film <span class="source-class">(Class Film)</span></label>
                    <input type="text" id="id_film" name="id_film" placeholder="misal: F006" required>
                </div>
                <div class="form-group">
                    <label for="judul">Judul Film <span class="source-class">(Class Film)</span></label>
                    <input type="text" id="judul" name="judul" placeholder="misal: Garuda Perkasa" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre <span class="source-class">(Class Film)</span></label>
                    <input type="text" id="genre" name="genre" placeholder="misal: Aksi Petualangan" required>
                </div>
                <div class="form-group">
                    <label for="durasi">Durasi (Menit, 1–999) <span class="source-class">(Class Film)</span></label>
                    <input type="number" id="durasi" name="durasi" min="1" max="999" placeholder="misal: 110" required>
                </div>
                <div class="form-group">
                    <label for="studio">Studio Animasi <span class="source-class">(Class FilmAnimasi)</span></label>
                    <input type="text" id="studio" name="studio" placeholder="misal: Studio Nusantara" required>
                </div>
                <div class="form-group">
                    <label for="negara_asal">Negara Asal <span class="source-class">(Class FilmAnimasi)</span></label>
                    <input type="text" id="negara_asal" name="negara_asal" placeholder="misal: Indonesia" required>
                </div>
                <div class="form-group">
                    <label for="target_usia">Target Usia <span class="source-class">(Class FilmAnimasi)</span></label>
                    <input type="text" id="target_usia" name="target_usia" placeholder="misal: Semua umur / 13+" required>
                </div>
                <div class="form-group">
                    <label for="software_3d">Software 3D <span class="source-class">(Class FilmAnimasi3D)</span></label>
                    <input type="text" id="software_3d" name="software_3d" placeholder="misal: Blender" required>
                </div>
                <div class="form-group">
                    <label for="mesin_render">Mesin Render <span class="source-class">(Class FilmAnimasi3D)</span></label>
                    <input type="text" id="mesin_render" name="mesin_render" placeholder="misal: Cycles" required>
                </div>
                <div class="form-group">
                    <label for="format_model">Format Model 3D <span class="source-class">(Class FilmAnimasi3D)</span></label>
                    <input type="text" id="format_model" name="format_model" placeholder="misal: GLTF / FBX" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">+ Tambah Film</button>
                <button type="submit" name="aksi" value="reset" class="btn btn-secondary" formnovalidate>Reset ke 5 Data Awal</button>
            </div>
        </form>
    </section>

    <footer>Data contoh fiktif. Foto produk berupa poster ilustrasi SVG dinamis. Geser tabel ke samping pada layar kecil.</footer>
</main>
</body>
</html>
