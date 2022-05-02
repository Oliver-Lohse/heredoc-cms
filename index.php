<?php

//-----------------------------------------------------------------------------
// Der serielle Content unterteilt in einzelne  Sektionen die der Reihe nach in 
// die {#}-Tokens des Templates eingesetzt werden
//-----------------------------------------------------------------------------

$data = <<<EOD
HeredocParser - home
---
HeredocParser
---
Eigenständig lauffähiger Heredoc-Template Parser in PHP
---
Content
---
Der Content ist Bestandteil der PHP-Datei und liegt in der Heredoc-Syntax vor.
Der Content wird dabei mit drei Bindestrichen in Blöcke unterteilt. Alternativ
können andere Platzhalter genutzt werden.
---
HTML Template
---
Das HTML-Template befindet sich im zweiten Teil der PHP-Datei ebenfalls in der
Heredoc Syntax verfasst. Das Template ist mit {#} Tokens angereichert, in denen
der spätere Content eingesetzt wird.
---
Tokens
---
Die {#}-Tokens stellen alle Stellen im Template dar, in denen Content der Reihe
nach eingesetzt werden soll. Der Parser wandelt alle normalen {#}-Tokens in
nummerierte {#1}, {#2},... um.
EOD;

//-----------------------------------------------------------------------------
// Das vollständige HTML-Template mit den {#}-Token
//-----------------------------------------------------------------------------

$template = <<<EOD
<!doctype html>
<html lang="de">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>{#}</title>
    </head>
    <body>

        <div class="container-fluid py-5 bg-secondary text-light shadow">
            <div class="container">
                <h1>{#}</h1>
                <p class="lead">{#}</p>
            </div>
        </div>

        <div class="container py-5">
            <div class="row">
                <div class="col-sm"> <h2>{#}</h2> <p>{#}</p> </div>
                <div class="col-sm"> <h2>{#}</h2> <p>{#}</p> </div>
                <div class="col-sm"> <h2>{#}</h2> <p>{#}</p> </div>
            </div>
            <div class="row">
                <div class="col-sm"> <h2>{#}</h2> <p>{#}</p> </div>
                <div class="col-sm"> <h2>{#}</h2> <p>{#}</p> </div>
                <div class="col-sm"> <h2>{#}</h2> <p>{#}</p> </div>
            </div>
        </div>

    </body>
</html>
EOD;

//-----------------------------------------------------------------------------
// Der Parser und Renderer ersetzt alle {#}-Tokens durch die nummerierten {#1}, 
// {#2},... Tokens und fügt den Content der Reihe nach in jeden Token ein.
//-----------------------------------------------------------------------------

$data                  = explode("---", trim($data));   // teilt den Content in einzelne Blöcke auf
$template              = explode('{#}', $template);     // zerlegt das Template anhand der {#}-Tokens
$token_count                 = 0;                             // zählt die {#}-Tokens
$template_order        = '';                            // nimmt das neue Template mit {#1}, {#2}... auf
$template_target_array = array();                       // nimmt das Ziel-Array {#1}, {#2},... auf

foreach ($template as $value) {
    $template_order .= $value.'{#'.$token_count.'}';          // konkatiniert string{#1}string{#2}string...
    $template_target_array[] = '{#'.$token_count.'}';         // erzeugt Array Inhalte {#1}, {#2},...
    $token_count = $token_count+1;
}

$template = str_replace($template_target_array, $data, $template_order);
echo $template;
?>