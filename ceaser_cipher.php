<?php

function caesarCipherEncrypt($text, $shift)
{
  $result = '';

  $textLength = strlen($text);
  for ($i = 0; $i < $textLength; $i++) {
    $char = $text[$i];
    if (ctype_upper($char)) {
      $result .= chr((ord($char) + $shift - 65) % 26 + 65);
    }

    elseif (ctype_lower($char)) {
      $result .= chr((ord($char) + $shift - 97) % 26 + 97);
      continue; // Skip to the next iteration
    }
    // Non-alphabetic characters remain unchanged
    $result .= $char;
  }

  return $result;
}

function caesarCipherDecrypt($text, $shift)
{
  // To decrypt a Caesar cipher, the shift value is negated
  $shift = -$shift;
  return caesarCipherEncrypt($text, $shift);
}

// Initialize variables
$text = '';
$shift = 0;
$encryptedText = '';
$decryptedText = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = $_POST['text'];
  $shift = (int) $_POST['shift'];

  if (isset($_POST['encrypt'])) {
    // Encrypt
    $encryptedText = caesarCipherEncrypt($text, $shift);
  } elseif (isset($_POST['decrypt'])) {
    // Decrypt
    $decryptedText = caesarCipherDecrypt($text, $shift);
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Caesar Cipher Encryption & Decryption</title>
</head>

<body>
  <h1>Caesar Cipher Encryption & Decryption</h1>
  <form method="post" action="">
    <label for="text">Enter text:</label><br>
    <textarea id="text" name="text"><?php echo htmlentities($text); ?></textarea><br><br>
    <label for="shift">Enter shift value:</label><br>
    <input type="number" id="shift" name="shift" value="<?php echo $shift; ?>"><br><br>
    <input type="submit" name="encrypt" value="Encrypt">
    <input type="submit" name="decrypt" value="Decrypt">
  </form>

  <?php if ($encryptedText || $decryptedText): ?>
    <h2>Result:</h2>
    <?php if (isset($_POST['encrypt'])): ?>
      <p>Encrypted Text:
        <?php echo htmlentities($encryptedText); ?>
      </p>
    <?php elseif (isset($_POST['decrypt'])): ?>
      <p>Decrypted Text:
        <?php echo htmlentities($decryptedText); ?>
      </p>
    <?php endif; ?>
  <?php endif; ?>
</body>

</html>