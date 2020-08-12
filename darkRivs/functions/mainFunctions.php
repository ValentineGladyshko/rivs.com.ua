<?php
function penny_price_to_normal_price($penny_price)
{
  if ($penny_price < 100) {
    $normal_price = sprintf("%03d", $penny_price);
    $str = substr_replace($normal_price, '.', (strlen($normal_price) - 2), 0). " ₴";
    return $str;
  } else {
    $normal_price = sprintf("%d", $penny_price);
    $str = substr_replace($normal_price, '.', (strlen($normal_price) - 2), 0). " ₴";
    return $str;
  }
}

function badge_status_color($statusId)
{
  if ($statusId == 1) {
    return "badge-secondary";
  } elseif ($statusId == 2) {
    return "badge-warning";
  } elseif ($statusId == 3) {
    return "badge-primary";
  } elseif ($statusId == 4) {
    return "badge-info";
  } elseif ($statusId == 5) {
    return "badge-success";
  } elseif ($statusId == 6) {
    return "badge-danger";
  } else {
    return "badge-secondary";
  }
}

function text_status_color($statusId)
{
  if ($statusId == 1) {
    return "text-secondary";
  } elseif ($statusId == 2) {
    return "text-warning";
  } elseif ($statusId == 3) {
    return "text-primary";
  } elseif ($statusId == 4) {
    return "text-info";
  } elseif ($statusId == 5) {
    return "text-success";
  } elseif ($statusId == 6) {
    return "text-danger";
  } else {
    return "text-secondary";
  }
}