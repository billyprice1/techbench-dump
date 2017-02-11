﻿<?php
// TechBench dump
// Copyright (C) 2017  mkuba50

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

$skuId = isset($_GET['skuId']) ? $_GET['skuId'] : '6PC-00020';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en-us';
require 'lang/core.php';
require 'shared/get.php';
require 'shared/style.php';

$downList = getDownload($skuId);
if(isset($downList['error'])) {
    echo 'There was an error processing your request.';
    die();
}

styleTop('downloads');

echo '<h1>'.$translation['tbDumpDownload']."</h1>\n";
echo "<h3><span class=\"glyphicon glyphicon-file\" aria-hidden=\"true\"></span> ".$downList['osName']."</h3>\n";
$index = 0;
foreach ($downList['downloadLinks'] as &$curr) {
    if ($index == 0) {
        $btnType = 'btn-primary';
    } else {
        $btnType = 'btn-default';
    }
    switch ($curr['architecture']) {
        case 'x64':
            $btnText = $translation['archx64'];
            break;
        case 'x86':
            $btnText = $translation['archx86'];
            break;
        default:
            $btnText = $translation['downloadName'];
            break;
    }
    echo '<a class="btn '.$btnType.'" href="'.$curr['url'].'"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> '.$btnText."</a>\n";
    $index++;
}
echo '</table>'
?> 

<div class="alert alert-success" style="margin-top: 1.5em">
    <h4><span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php echo $translation['linkExpireTitle'];?></h4>
    <p><?php echo $translation['linkExpire1'];?><br>
    <?php echo $translation['linkExpire2'].': <b>'.gmdate("Y-m-d H:i:s e", $downList['expiration']); ?></b></p>
</div>

<div class="alert alert-info" style="margin-top: 1.5em">
    <h4><span class="glyphicon glyphicon-link" aria-hidden="true"></span> <?php echo $translation['directLinksTitle'];?></h4>
    <p><?php echo $translation['directLinksLine1'];?></p>
    <pre style="margin-top: 1em"><code><?php 
        foreach ($downList['downloadLinks'] as &$iso)
        {
        echo 'https://mdl-tb.ct8.pl/getDirect.php?fileName='.$iso['fileName']."\n";
        }
    ?></code></pre>
</div>

<?php styleBottom(); ?>
