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
    return "badge-dark";
  }
}

function badge_soft_status_color($statusId)
{
  if ($statusId == 1) {
    return "badge-secondary-soft text-secondary";
  } elseif ($statusId == 2) {
    return "badge-warning-soft text-warning";
  } elseif ($statusId == 3) {
    return "badge-primary-soft text-primary";
  } elseif ($statusId == 4) {
    return "badge-info-soft text-info";
  } elseif ($statusId == 5) {
    return "badge-success-soft text-success";
  } elseif ($statusId == 6) {
    return "badge-danger-soft text-danger";
  } else {
    return "badge-dark-soft text-dark";
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
    return "text-dark";
  }
}

function status_text_by_id($statusId)
{
  if ($statusId == 1) {
    return "Обробка оператором";
  } elseif ($statusId == 2) {
    return "Прийнято";
  } elseif ($statusId == 3) {
    return "Оплачено";
  } elseif ($statusId == 4) {
    return "Очікує в пункті видачі";
  } elseif ($statusId == 5) {
    return "Виконано";
  } elseif ($statusId == 6) {
    return "Відмінено";
  } else {
    return "Невідомий";
  }
}