<?php

class RentalMotor
{
    private static $pajak = 10000;
    private static $motorTypes = ['Motor Sport', 'Motor Klasik', 'Motor Matic', 'Motor Touring'];
    private static $hargaMotorPerHari = [
        'Motor Sport' => 70000,
        'Motor Klasik' => 500000,
        'Motor Matic' => 150000,
        'Motor Touring' => 200000
    ];

    private static $members = ['Aditya', 'Hansen', 'Nabil'];

    private static $harga;
    private static $keterangan;
    private static $hargaMotor;

    public function __construct($member, $motor, $waktu)
    {
        $hargaMotorPerHari = self::$hargaMotorPerHari[$motor];
        $totalHarga = $hargaMotorPerHari * $waktu;

        if (static::isMember($member)) {
            $diskon = $totalHarga * 0.05;
            $totalHarga -= $diskon;
            self::$keterangan = " (Member dapat Diskon 5%)";
        } else {
            self::$keterangan = " (Non Member)";
        }

        $totalHarga += self::$pajak;
        self::$harga = $totalHarga;
        self::$hargaMotor = $hargaMotorPerHari;
    }

    public static function isMember($member)
    {
        return in_array($member, self::$members);
    }

    public static function addMember($member)
    {
        self::$members[] = $member;
    }

    public static function getHarga()
    {
        return self::$harga;
    }

    public static function getHargaMotor()
    {
        return self::$hargaMotor;
    }

    public static function keterangan()
    {
        return self::$keterangan;
    }

    public static function getMotorTypes()
    {
        return self::$motorTypes;
    }
}

// Tambah member baru
RentalMotor::addMember('saep');

// Proses form submission
if (isset($_POST['submit'])) {
    $member = $_POST['member'];
    $waktu = $_POST['waktu'];
    $motor = $_POST['motor'];

    $rental = new RentalMotor($member, $motor, $waktu);

    $harga = RentalMotor::getHarga();
    $keterangan = RentalMotor::keterangan();
    $hargaMotorPerHari = RentalMotor::getHargaMotor();

    $result =
        "Nama Member: <b>$member " . RentalMotor::keterangan() . "</b> <br>
    Jenis motor yang dirental adalah <b>$motor selama $waktu hari</b> <br>
    Harga rental motor jenis $motor per hari adalah: Rp. " . number_format($hargaMotorPerHari, 2, ',', '.') . "<br>
    Pajak yang harus dibayarkan adalah: Rp. " . number_format(RentalMotor::getHarga() - RentalMotor::getHargaMotor() * $waktu, 2, ',', '.') . "
    <br>
    <br>
    <b>Besar Yang Harus Dibayarkan: Rp. " . number_format(RentalMotor::getHarga(), 2, ',', '.');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Motor</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: red;
            color: #fff;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 300px;
        }

        input,
        select {
            padding: 0.5rem;
            border: none;
            background-color: #2D3748;
            color: #fff;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1792 1792'%3E%3Cpath fill='grey' d='M1427 727q0 13-10 23l-466 466q-10 10-23 10t-23-10l-50-50q-10-10-10-23t10-23l393-393-393-393q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l466 466q10 10 10 23z'/%3E%3C/svg%3E");
            background-repeat: no-repeat, repeat;
            background-position: right 1em top 50%, 0 0;
            background-size: .65em auto, 100%;
            cursor: pointer;
        }

        button {
            padding: 0.5rem 1rem;
            border: none;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #00C853;
            border-radius: 0.5rem;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>Rental Motor</h1>
    <form action="" method="post">
        <label for="member">Nama</label>
        <input type="text" name="member" id="member" placeholder="Nama" required>
        <label for="waktu">Waktu Penyewaan Perhari</label>
        <input type="number" name="waktu" id="waktu" placeholder="Waktu" required>
        <label for="motor">Jenis Motor</label>
        <select name="motor" id="motor" required>
            <?php foreach (RentalMotor::getMotorTypes() as $motor) : ?>
                <option value="<?= $motor ?>"><?= $motor ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="submit">Submit</button>
    </form>

    <?php if (isset($result)) : ?>
        <div class="result">
            <?= $result ?>
        </div>
    <?php endif; ?>
</body>

</html>