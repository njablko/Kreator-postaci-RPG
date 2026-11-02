<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kreator postaci RPG</title>
    <style>
        body {
            font-family: Trebuchet MS,sans-serif;
            background-color: #171717;
            color: black;
            margin: 0;
            min-height: 100vh;
            align-items: center;
            justify-content: flex-start;
            display: flex;
            flex-direction: column;
        }

        .container {
            background-color: #292522;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            width: 400px;
            border: 3px solid #59472D;
            transition: border-color 0.3 ease;
        }

        h2 {
            text-align: center;
            color: #C6A66B;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            color: #C6A66B;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #292522;
            width: 400px;
            height: 600px;
            padding: 40px;
            border-radius: 10px;
            box-sizing: border-box;
            border: 1px solid #292522;
            justify-content: center;
            box-shadow: 0 0 25px rgba(0,0,0,0.3);
            margin: 60px;
        }

        label {
            font-weight: bold;
            color: #C6A66B;
        }

        input, select {
            padding: 8px;
            border-radus: 5px;
            border: 1px solid #59472D;
            background-color: #211E1A;
            color: #E8DFC9;
        }

        input:focus, select:focus {
            border-color: #C6A66B;
            outline: none;
        }

        input::placeholder {
            color: #8E8372;
        }

        button {
            padding: 10px;
            background-color: #59472D;
            color: #C6A66B;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s
        }

        button:hover {
            background-color: #806536;
        }

        .card {
            background-color: #211E1A;
            color: #E8DFC9;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #806536;
            margin-top: 20px;
        }

        .stats-grid {
            display: grid;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
            margin: 60px;
        }

        .stat {
            background-color: #211E1A;
            border: 1px solid #59472D;
            border-radius: 8px;
            padding: 15px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 300px;
            color: #E8DFC9;
        }

        .error {
            color: #FF7777;
            background-color: rgba(255,77,77,0.1);
            border: 1px solid #8F3B35;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        </style>
</head>
<body>
    

    <?php
    $errors = [];
    $submitted = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $imie = trim($_POST['imie'] ?? '');
        $klasa = $_POST['klasa'] ?? '';
        $sila = filter_var($_POST['sila'] ?? null, FILTER_VALIDATE_INT);
        $zrecznosc = filter_var($_POST['zrecznosc'] ?? null, FILTER_VALIDATE_INT);
        $inteligencja = filter_var($_POST['inteligencja'] ?? null, FILTER_VALIDATE_INT);

        if (empty($imie)) {
            $errors[] = "Imię jest wymagane.";
        }
        if (!in_array($klasa, ['Wojownik', 'Mag', 'Łotrzyk'])) {
            $errors[] = "Nieprawidłowa klasa postaci.";
        }
        if ($sila === false || $sila < 1 || $sila > 20) {
            $errors[] = "Siła musi być liczbą całkowitą od 1 do 20.";
        }
        if ($zrecznosc === false || $zrecznosc < 1 || $zrecznosc > 20) {
            $errors[] = "Zręczność musi być liczbą całkowitą od 1 do 20.";
        }
        if ($inteligencja === false || $inteligencja < 1 || $inteligencja > 20) {
            $errors[] = "Inteligencja musi być liczbą całkowitą od 1 do 20.";
        }
        if (empty($errors)) {
            $submitted = true;
            $hp = ($sila * 10) + ($zrecznosc * 2);
        }
    }
    ?>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err); ?></li>  
            <?php endforeach; ?>
        </ul>
    <?php endif; ?> 

    <?php if ($submitted): ?>
        <div class="stats-grid">
        <h3>Karta postaci</h3>
            <div class="stat">
                <span class="stat-name">IMIĘ</span>
                <span class="stat-value"><?php echo htmlspecialchars($imie); ?></span>
            </div>

            <div class="stat">
                <span class="stat-name">KLASA</span>
                <span class="stat-value"><?php echo htmlspecialchars($klasa); ?></span>
            </div>

            <div class="stat">
                <span class="stat-name">SIŁA</span>
                <span class="stat-value"><?php echo $sila; ?></span>
            </div>

            <div class="stat">
                <span class="stat-name">ZRĘCZNOŚĆ</span>
                <span class="stat-value"><?php echo $zrecznosc; ?></span>
            </div>

            <div class="stat">
                <span class="stat-name">INTELIGENCJA</span>
                <span class="stat-value"><?php echo $inteligencja; ?></span>
            </div>

            <div class="stat">
                <span class="stat-name">HP</span>
                <span class="stat-value"><?php echo $hp; ?></span>
            </div>
        <br>
        <a href=""><button style="width: 100%;">Stwórz nową postać</button></a>
        </div>
    <?php else: ?>

        <form action="" method="POST" id="rpg-form">
            <h2>Kreator postaci RPG</h2>
            <label for="imie">Imię postaci:</label>
            <input type="text" name="imie" id="imie" value="<?php echo htmlspecialchars($_POST['imie'] ?? ''); ?>" required>

            <label for="klasa">Klasa postaci:</label>
            <select name="klasa" id="klasa" required>
                <option value="" disabled selected>Wybierz klasę</option>
                <option value="Wojownik" <?php echo (($_POST['klasa'] ?? '') === 'Wojownik') ? 'selected' : ''; ?>>Wojownik</option>
                <option value="Mag" <?php echo (($_POST['klasa'] ?? '') === 'Mag') ? 'selected' : ''; ?>>Mag</option>
                <option value="Łotrzyk" <?php echo (($_POST['klasa'] ?? '') === 'Łotrzyk') ? 'selected' : ''; ?>>Łotrzyk</option>
            </select>

            <label for="sila">Siła (1-20):</label>
            <input type="number" name="sila" id="sila" min="1" max="20" value="<?php echo htmlspecialchars($_POST['sila'] ?? ''); ?>" required>

            <label for="zrecznosc">Zręczność (1-20):</label>
            <input type="number" name="zrecznosc" id="zrecznosc" min="1" max="20" value="<?php echo htmlspecialchars($_POST['zrecznosc'] ?? ''); ?>" required>

            <label for="inteligencja">Inteligencja (1-20):</label>
            <input type="number" name="inteligencja" id="inteligencja" min="1" max="20" value="<?php echo htmlspecialchars($_POST['inteligencja'] ?? ''); ?>" required>
            <br>
            <button type="submit">Generuj kartę</button>
        </form>
    <?php endif; ?>

    <script>
        const klasaSelect = document.getElementById('klasa');
        const container = document.getElementById('main-container');

        function updateBorderColor() {
            const selectedValue = klasaSelect.value;
            if (selectedValue === 'Wojownik') {
                container.style.borderColor = 'red';
            } else if (selectedValue === 'Mag') {
                container.style.borderColor = 'blue';
            } else if (selectedValue === 'Łotrzyk') {
                container.style.borderColor = 'green';
            } else {
                container.style.borderColor = '#444';
            }
        }

        klasaSelect.addEventListener('change', updateBorderColor);
    </script>
</body>
</html>