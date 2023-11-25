<?php

function caesarCipherEncrypt($text, $key)
{
  $result = '';

  $textLength = strlen($text);
  for ($i = 0; $i < $textLength; $i++) {
    $char = $text[$i];
    if (ctype_upper($char)) {
      $result .= chr((ord($char) + $key - 65) % 26 + 65);
    } elseif (ctype_lower($char)) {
      $result .= chr((ord($char) + $key - 97) % 26 + 97);
      continue;
    }

    $result .= $char;
  }

  return $result;
}

function caesarCipherDecrypt($text, $key)
{
  $key = -$key;
  return caesarCipherEncrypt($text, $key);
}

$text = '';
$key = 0;
$encryptedText = '';
$decryptedText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = $_POST['text'];
  $key = (int) $_POST['key'];

  if (isset($_POST['encrypt'])) {

    $encryptedText = caesarCipherEncrypt($text, $key);
  } elseif (isset($_POST['decrypt'])) {
    $decryptedText = caesarCipherDecrypt($text, $key);
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
    <label for="key">Enter Key:</label><br>
    <input type="number" id="key" name="key" value="<?php echo $key; ?>"><br><br>
    <input type="submit" name="encrypt" value="Encrypt">
    <input type="submit" name="decrypt" value="Decrypt">
  </form>

  <?php if ($encryptedText || $decryptedText): ?>
    <h2>Result:</h2>
    <?php if (isset($_POST['encrypt'])): ?>
      <p>Encrypted Cipher Text:
        <?php echo htmlentities($encryptedText); ?>
      </p>
    <?php elseif (isset($_POST['decrypt'])): ?>
      <p>Decrypted Plain Text:
        <?php echo htmlentities($decryptedText); ?>
      </p>
    <?php endif; ?>
  <?php endif; ?>
</body>

</html>