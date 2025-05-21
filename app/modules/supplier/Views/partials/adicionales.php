<?php
function removeHttpPrefix($url)
{
  return preg_replace('#^https?://#i', '', $url);
}
