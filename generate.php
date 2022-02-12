<?php

$x = $_POST["howmany"];

function generate()
{
  // Obtain a random string of 32 hex characters.
  $hex = bin2hex(random_bytes(16));

  // The variable names $time_low, $time_mid, $time_hi_and_version,
  // $clock_seq_hi_and_reserved, $clock_seq_low, and $node correlate to
  // the fields defined in RFC 4122 section 4.1.2.
  //
  // Use characters 0-11 to generate 32-bit $time_low and 16-bit $time_mid.
  $time_low = substr($hex, 0, 8);
  $time_mid = substr($hex, 8, 4);

  // Use characters 12-15 to generate 16-bit $time_hi_and_version.
  // The 4 most significant bits are the version number (0100 == 0x4).
  // We simply skip character 12 from $hex, and concatenate the strings.
  $time_hi_and_version = '4' . substr($hex, 13, 3);

  // Use characters 16-17 to generate 8-bit $clock_seq_hi_and_reserved.
  // The 2 most significant bits are set to one and zero respectively.
  $clock_seq_hi_and_reserved = base_convert(substr($hex, 16, 2), 16, 10);
  $clock_seq_hi_and_reserved &= 0b111111;
  $clock_seq_hi_and_reserved |= 0b10000000;

  // Use characters 18-19 to generate 8-bit $clock_seq_low.
  $clock_seq_low = substr($hex, 18, 2);

  // Use characters 20-31 to generate 48-bit $node.
  $node = substr($hex, 20);

  // Re-combine as a UUID. $clock_seq_hi_and_reserved is still an integer.
  $uuid = sprintf(
    '%s-%s-%s-%02x%s-%s',
    $time_low,
    $time_mid,
    $time_hi_and_version,
    $clock_seq_hi_and_reserved,
    $clock_seq_low,
    $node
  );
  return $uuid;
}


function get_ids($x)
{
  for ($i = 0; $i < $x; $i++) {
    $uuid = generate();
    echo $uuid . "<br />";
  }
}

return get_ids($x);
