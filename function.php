<?php

function getCard($nomeTer, $id, $data, $zona, $nome, $cognome)
{
    echo '

    <div class="user-card" id="user-' . $id . '">
    <div class="user-top">
      <div class="user-data">
        <div class="badge-number">' . $nomeTer . '</div>
        <div>
          <div><strong>' . $nome . ' ' . $cognome . '</strong></div>
          <div class="user-info">Rientrato: ' . $data . '</div>
          <div class="user-location">' . $zona . '</div>
        </div>
      </div>
      <div class="user-actions">
        <!-- Occhio -->
        
        <button onclick="showPanel(' . $id . ', \'view\',' . $zona . ',' . $data . ',' . $nome . ',' . $cognome . ')">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
          </svg>
        </button>

        <!-- Upload -->
        <button onclick="showPanel(' . $id . ', \'upload\',' . $zona . ',' . $data . ',' . $nome . ',' . $cognome . ')">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707z" />
          </svg>
        </button>
      </div>
    </div>
  </div>
  ';

}


function convertToEuropean($date)
{
    // Converte la data nel formato europeo
    $timestamp = strtotime($date);
    if ($timestamp) {
        return date("d-m-Y", $timestamp);
    } else {
        return "Formato data non valido";
    }
}



function note($s) {
    // 1. Rimuovi l'ultimo punto e virgola se presente, per evitare elementi vuoti
    $stringa_pulita = rtrim($s, ';');

    // 2. Separa i blocchi di dati usando il punto e virgola
    $blocchi_dati = explode(';', $stringa_pulita);
    
    $output = '';

    // 3. Elabora ogni blocco di dati singolarmente
    foreach ($blocchi_dati as $blocco) {
        // Separa via, numero civico e data usando la virgola
        $dati = explode(',', $blocco);

        // Controlla che il blocco contenga 3 elementi validi
        if (count($dati) === 3) {
            $via = trim($dati[0]);
            $numero_civico = trim($dati[1]);
            $data_non_contattare = trim($dati[2]);
            
            // Concatena la frase al risultato finale
            $output .= "\n".$via . ' n:' . $numero_civico . ' non vuole essere contattato dal ' . $data_non_contattare . '; ';
        }
    }

    // 4. Rimuovi lo spazio e il punto e virgola finali prima di restituire l'output
    if($output == ""){
      return "Nessuna nota per questo territorio";

    }
    return rtrim($output, '; ');
}
function noteInput($s) {
    $i=0;
    // 1. Rimuovi l'ultimo punto e virgola se presente, per evitare elementi vuoti
    $stringa_pulita = rtrim($s, ';');

    // 2. Separa i blocchi di dati usando il punto e virgola
    $blocchi_dati = explode(';', $stringa_pulita);
    
    $output = '';

    // 3. Elabora ogni blocco di dati singolarmente
    foreach ($blocchi_dati as $blocco) {
        // Separa via, numero civico e data usando la virgola
        $dati = explode(',', $blocco);

        // Controlla che il blocco contenga 3 elementi validi
        if (count($dati) === 3) {
            $via = trim($dati[0]);
            $numero_civico = trim($dati[1]);
            $data_non_contattare = trim($dati[2]);
            
            // Concatena la frase al risultato finale
            echo "<div class=\"input-group mb-2\"><input type=\"text\" name=\"$i\" class=\"form-control\" value=\"$via n:$numero_civico non vuole essere contattato dal $data_non_contattare;\"><button type=\"button\" class=\"btn btn-outline-danger\"><i class=\"bi bi-trash\"></i></button></div>";
            $i++;
          }
    }

    // 4. Rimuovi lo spazio e il punto e virgola finali prima di restituire l'output

}
