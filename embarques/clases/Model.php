<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Model extends Conexion
{

    // This function is used to import data from an Excel file into the database
        public function import()
        {
            $numeroLista = $_GET['lista'] ?? 1; // valor por defecto si no se pasa nada
            $rutaArchivo = "./excels/lista reservas ($numeroLista).xlsx";
        
            if (!file_exists($rutaArchivo)) {
                die("El archivo <strong>$rutaArchivo</strong> no existe.");
            }

            $query = 'INSERT INTO pasajeros 
            (id, creacion, f_entrada, f_actualizada, n_noches, origen, usuario, anulada_por,
            producto, hora, ocupacion, nombre, apellido_1, apellido_2, e_mail, telefono,
            comentario, comentario_interno, estado, importe, factura, adultos, ninos, senior, gratis)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = $this->getConn()->prepare($query);
            $spreadsheet = IOFactory::load($rutaArchivo);
            $sheet = $spreadsheet->getActiveSheet();
            $totalRows = $sheet->getHighestRow();

            for ($row = 3; $row <= $totalRows; $row++) {
                $id = $sheet->getCell("A$row")->getValue();
                $creacion = $sheet->getCell("B$row")->getValue();
                $f_entrada = $sheet->getCell("C$row")->getValue();
                $f_actualizada = $sheet->getCell("E$row")->getValue();
                $n_noches = $sheet->getCell("F$row")->getValue();
                $origen = $sheet->getCell("G$row")->getValue();
                $usuario = $sheet->getCell("H$row")->getValue();
                $anulada_por = $sheet->getCell("I$row")->getValue();
                $producto = $sheet->getCell("J$row")->getValue();
                $hora = $sheet->getCell("K$row")->getValue();
                $ocupacion = $sheet->getCell("L$row")->getValue();

                $adultos = $ninos = $senior = $gratis = 0;
                $ocupaciones = explode(',', $ocupacion);
                foreach ($ocupaciones as $item) {
                    $item = trim($item);
                    if (preg_match('/^A(\d+)/', $item, $match)) {
                        $adultos = (int)$match[1];
                    } elseif (preg_match('/^N(\d+)/', $item, $match)) {
                        $ninos = (int)$match[1];
                    } elseif (preg_match('/^S(\d+)/', $item, $match)) {
                        $senior = (int)$match[1];
                    } elseif (preg_match('/^G(\d+)/', $item, $match)) {
                        $gratis = (int)$match[1];
                    }
                }

                $nombre = $sheet->getCell("M$row")->getValue();
                $apellido_1 = $sheet->getCell("N$row")->getValue();
                $apellido_2 = $sheet->getCell("O$row")->getValue();
                $e_mail = $sheet->getCell("P$row")->getValue();
                $telefono = $sheet->getCell("Q$row")->getValue();
                $comentario = $sheet->getCell("R$row")->getValue();
                $comentario_interno = $sheet->getCell("S$row")->getValue();
                $estado = $sheet->getCell("T$row")->getValue();
                $importe = $sheet->getCell("U$row")->getValue();
                $factura = $sheet->getCell("V$row")->getValue();

                $f_entrada = self::convertToDate($f_entrada);
                $f_actualizada = self::convertToDate($f_actualizada);
                $creacion = self::convertToDate($creacion);

                $stmt->execute([
                    $id, $creacion, $f_entrada, $f_actualizada, $n_noches, $origen, $usuario, $anulada_por,
                    $producto, $hora, $ocupacion, $nombre, $apellido_1, $apellido_2, $e_mail, $telefono,
                    $comentario, $comentario_interno, $estado, $importe, $factura,
                    $adultos, $ninos, $senior, $gratis
                ]);
            }
        }

        private static function convertToDate($value, $format = 'Y-m-d')
        {
            if ($value instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                $value = $value->getPlainText();
            }

            if (trim($value) === '-' || trim($value) === '') {
                return null;
            }

            $value = trim($value);

            if (preg_match('/\d{2}-\d{2}-\d{4}/', $value)) {
                $date = DateTime::createFromFormat('d-m-Y', $value);
            } elseif (preg_match('/\d{2}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $value)) {
                $date = DateTime::createFromFormat('d-m-y H:i:s', $value);
            } else {
                return null;
            }

            return $date ? $date->format($format) : null;
        }

        public function deleteList()
        {
            $query = 'DELETE FROM pasajeros';
            $this->getConn()->query($query);
        }

        //Backups
        public function backupPasajeros($nombreArchivo = null){
            $numeroLista = $_GET['lista'] ?? 1; // valor por defecto si no se pasa nada
        
            if ($nombreArchivo === null) {
                $nombreArchivo = "backups/backup_lista$numeroLista.sql";
            }
        
            $datos = $this->getAllPasajeros();
            if (empty($datos)) return;
        
            $sql = "";
            foreach ($datos as $fila) {
                $columnas = array_keys($fila);
                $valores = array_map(function ($valor) {
                    return is_null($valor) ? 'NULL' : "'" . addslashes($valor) . "'";
                }, array_values($fila));
        
                $sql .= "INSERT INTO pasajeros (" . implode(", ", $columnas) . ") VALUES (" . implode(", ", $valores) . ");\n";
            }
        
            if (!is_dir('backups')) {
                mkdir('backups', 0777, true);
            }
        
            file_put_contents($nombreArchivo, $sql);
        }
        
        public function restoreBackup(){
            if (!isset($_GET['lista'])) {
                throw new Exception("No se indicó el número de lista por GET.");
            }
        
            $lista = intval($_GET['lista']); // Sanitizar el valor
            $backupDir = 'backups';
            $nombreArchivo = "$backupDir/backup_lista$lista.sql";
        
            if (!file_exists($nombreArchivo)) {
                throw new Exception("No se encontró el archivo de backup para la lista $lista.");
            }
        
            $this->deleteList(); // Borrar datos actuales
            $sql = file_get_contents($nombreArchivo);
            if ($sql) {
                $sentencias = explode(";", $sql);
            foreach ($sentencias as $sentencia) {
                $sentencia = trim($sentencia);
                if (!empty($sentencia)) {
                    $this->getConn()->exec($sentencia . ";");
                }
            }
                } else {
                    throw new Exception("Error al leer el archivo de backup.");

                }

        }

        //Backups
        

        public function init()
        {
            try {
                $this->backupPasajeros();
                $this->deleteList();
                $this->import();
            } catch (Exception $e) {
                die("Error: " . $e->getMessage());
            }
        }



    // This function is used to import data from an Excel file into the database

    // This function is used to get all passengers from the database
        public function getAllPasajeros()
        {
            $query = 'SELECT * FROM pasajeros order by producto desc, estado asc';
            $stmt = $this->getConn()->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function showAllPasajeros()
        {
            $result = $this->getAllPasajeros();

            $Checks = [
                'id' => 'Checkid',
                'creacion' => 'Checkcreacion',
                'f_entrada' => 'Checkf_entrada',
                'f_actualizada' => 'Checkf_actualizada',
                'n_noches' => 'Checkn_noches',
                'origen' => 'Checkorigen',
                'usuario' => 'Checkusuario',
                'anulada_por' => 'Checkanulada_por',
                'producto' => 'Checkproducto',
                'hora' => 'Checkhora',
                'ocupacion' => 'Checkocupacion',
                'nombre' => 'Checknombre',
                'apellido_1' => 'Checkapellido_1',
                'apellido_2' => 'Checkapellido_2',
                'e_mail' => 'Checke_mail',
                'telefono' => 'Checktelefono',
                'comentario' => 'Checkcomentario',
                'comentario_interno' => 'Checkcomentario_interno',
                'estado' => 'Checkestado',
                'importe' => 'Checkimporte',
                'factura' => 'Checkfactura',
                'adultos' => 'Checkadultos',
                'ninos' => 'Checkninos',
                'senior' => 'Checksenior',
                'gratis' => 'Checkgratis'
            ];

            $camposDisponibles = [
                'id' => 'ID',
                'creacion' => 'Creación',
                'f_entrada' => 'F. Entrada',
                'f_actualizada' => 'F. Actualizada',
                'n_noches' => 'Nº Noches',
                'origen' => 'Origen',
                'usuario' => 'Usuario',
                'anulada_por' => 'Anulada por',
                'producto' => 'Producto',
                'hora' => 'Hora',
                'ocupacion' => 'Ocupación',
                'nombre' => 'Nombre',
                'apellido_1' => 'Apellido 1',
                'apellido_2' => 'Apellido 2',
                'e_mail' => 'E-mail',
                'telefono' => 'Teléfono',
                'comentario' => 'Comentario',
                'comentario_interno' => 'Comentario Interno',
                'estado' => 'Estado',
                'importe' => 'Importe',
                'factura' => 'Factura',
                'adultos' => 'Adultos',
                'ninos' => ' Niños>12',
                'gratis' => 'Gratuidad'
            ];



            if (isset($_POST['accion']) && $_POST['accion'] == 'reiniciar') {
                $camposMostrar = [
                    'id', 'producto', 'nombre', 'apellido_1',
                    'apellido_2', 'telefono', 'comentario', 'comentario_interno', 'estado',
                    'adultos', 'ninos', 'gratis'
                ];
            }else{
            if (isset($_POST['campos'])) {
                $_SESSION['campos'] = $_POST['campos']; // Guardamos en sesión si viene por POST
            }
            
            $camposMostrar = $_SESSION['campos'] ?? [
                'id', 'producto', 'nombre', 'apellido_1',
                'apellido_2', 'telefono', 'comentario', 'comentario_interno', 'estado',
                'adultos', 'ninos', 'gratis'
            ];}

            echo '<div id="tabla">';
            echo '</div>';
            echo '<table class="greenTable">';
            echo '<thead><tr>';
            //Cabezales
                foreach ($camposMostrar as $campo) {
                    if (isset($camposDisponibles[$campo])) {
                        echo '<th>' . htmlspecialchars($camposDisponibles[$campo]) . '</th>';
                    }
                }
                echo '<th> Check-Parcial </th>';
                echo '<th> Check-in </th>';
                echo '</tr></thead>';
            //Cabezales
            //Cuerpo
                echo '<tbody>';
                foreach ($result as $row) {
                    if ($row['checked'] == 0){
                        echo '<tr>';}
                    elseif($row['checked'] == 1){
                        echo '<tr style="background-color:rgb(46, 185, 0);">';
                    }elseif($row['checked'] == 2){
                        echo '<tr style="background-color:rgb(229, 255, 0);">';}

                        foreach ($camposMostrar as $campo) {
                            if (in_array($campo, ['adultos', 'ninos'])) {
                                $cantidad = (int)($row[$campo] ?? 0);
                                if ($cantidad == 0) {
                                echo "<td></td>";
                                }else{
                                $imgSrc = "IMG/{$campo}.png";  // nombres deben coincidir
                                $htmlImg = '';
                                
                                $htmlImg .= "<img src='$imgSrc' alt='$campo' style='height: 24px; margin-right: 2px;'>";
                                
                                echo "<td>$htmlImg x $cantidad</td>";
                            }} elseif (in_array($campo, ['gratis'])) {
                                $cantidad = (int)($row[$campo] ?? 0);
                                if ($cantidad == 0) {
                                    echo "<td></td>";
                                    }else{
                                $imgSrc = "IMG/grat.png";  // nombres deben coincidir
                                $htmlImg = '';
                                $htmlImg .= "<img src='$imgSrc' alt='$campo' style='height: 24px; margin-right: 2px;'>";
                                echo "<td>$htmlImg x $cantidad</td>";
                            }} elseif (in_array($campo, ['senior'])) {} else {
                                echo '<td>' . htmlspecialchars($row[$campo] ?? '') . '</td>';
                            }
                        }
                        //casilla check-in parcial
                            echo '<td style="text-align: center;">';
                            echo '<form method="POST" action="#tabla">';
                            echo '<select name="cantidad" id="personasSelect">';

                            $personas = $row['adultos'] + $row['ninos'] + $row['gratis'];


                            if($row['checked'] == 0 || $row['checked'] == 1){


                                for ($i = 0; $i <= $personas - 1; $i++) {
                                    echo "<option value=\"$i\">$i</option>";
                                }
                                
                                echo "<option selected value=\"$i\">$i</option>";
                                echo '</select>';}
                            elseif($row['checked'] == 2){

                            $value = $row['subidos'];
            

                                for ($i = 0; $i <= $value - 1; $i++) {
                                    echo "<option value=\"$i\">$i</option>";
                                }

                                echo "<option selected value=\"$value\">$value</option>";


                                for ($i = $value + 1; $i <= $personas; $i++ ){
                                    echo "<option value=\"$i\">$i</option>";
                                }



                                
                                
                                echo '</select>';
                            }
                        


                        //casilla check-in parcial
                        //casilla check-in
                            echo '<td style="text-align: center;">';
                            foreach ($Checks as $campo => $nombreCampo) {
                            
                                $row[$campo] = htmlspecialchars($row[$campo] ?? '');

                                echo '<input type="hidden" name="' . $nombreCampo .'" value="' . $row[$campo] . '">';

                            }
                            echo '<input type="submit" class="bononcheck" name="checkin" value="Check-in">';
                            echo '</form>';
                            echo '</tr>';
                        //casilla check-in
                    }
                    echo '</tbody>';
                    echo '</table>';
            //Cuerpo
        }       

    // This function is used to get all passengers from the database

    // Contar personas en el barco
        public function contarPersonas()
        {
            $query = 'SELECT SUM(adultos) AS total_adultos, SUM(ninos) AS total_ninos, SUM(gratis) AS total_gratis FROM pasajeros';
            $stmt = $this->getConn()->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function cojerSubidosDeCheckeadasAMedias(){
            $query = 'SELECT id, subidos FROM pasajeros WHERE checked = 2';
            $stmt = $this->getConn()->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarPersonasCheckeadas()
        {
            $query = 'SELECT SUM(adultos) AS total_adultos, SUM(ninos) AS total_ninos, SUM(gratis) AS total_gratis FROM pasajeros WHERE checked = 1';
            $stmt = $this->getConn()->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function showContarPersonas()
        {
            $resultDatos = $this->getAllPasajeros();
            $result = $this->contarPersonas();
            $total = $result['total_adultos'] + $result['total_ninos'] + $result['total_gratis'];

            echo '<div class="contarPersonas">';
            echo '<h2 style="color:black; margin-bottom:10px;">' . $resultDatos[0]['f_entrada'] . '</h2>';
            echo '<h2 style="margin-top:0px;">Total de Personas en el Barco | ' . $resultDatos[0]['hora'] . '</h2>';
            echo '<p>Total Adultos: ' . htmlspecialchars($result['total_adultos']) . '</p>';
            echo '<p>Total Niños: ' . htmlspecialchars($result['total_ninos']) . '</p>';
            echo '<p>Total Gratis: ' . htmlspecialchars($result['total_gratis']) . '</p>';
            echo '<p><b>Total Barco: ' . $total . '</b></p>';
            echo '</div>';
        }


        public function showBalance()
        {
            $result = $this->contarPersonas();
            $resultCheckeados = $this->contarPersonasCheckeadas();
            $total = $result['total_adultos'] + $result['total_ninos'] + $result['total_gratis'];
            $totalCheckeados = $resultCheckeados['total_adultos'] + $resultCheckeados['total_ninos'] + $resultCheckeados['total_gratis'];
            $sinCheck = $total - $totalCheckeados;


            //recoger los ID de los pasajeros que tienen el check = 2
            //Luego los sumamos y los guardamos
            $Subidos = $this->cojerSubidosDeCheckeadasAMedias();
            $totalSubidosaMedias = 0;

            foreach ($Subidos as $subido) {
                $totalSubidosaMedias += $subido['subidos'];
            }

            $totalCheckeados = $totalCheckeados + $totalSubidosaMedias;


            echo '<div class="contarPersonas">';
            echo '<h2>BALANCE</h2>';
            echo '<p>Personas CON check-in: <span style="background-color: #50ff18; font-weight: bold;">' . $totalCheckeados . '</span></p>';
            echo '<p>Personas SIN check-in: <span style="background-color:rgb(255, 67, 67); font-weight: bold;">' . $sinCheck . '</span></p>';
            echo '<p><b>Total Barco: ' . $total . '</b></p>';
            echo '</div>';
        }

    // Contar personas en el barco
        
    

    public function checkPasageros()
        {
            if (isset($_POST['Checkid'])) {
                $id = $_POST['Checkid'];


                // Consulta para obtener el estado actual del pasajero
                $query = 'SELECT checked FROM pasajeros WHERE id = ?';
                $stmt = $this->getConn()->prepare($query);
                $stmt->execute([$id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifica si se obtuvo un resultado
                if ($result) {
                    $currentChecked = $result['checked'];

                    // Cambia el estado de checked
                    $newChecked = ($currentChecked == 0) ? 1 : 0;

                    // Actualiza el estado en la base de datos
                    $updateQuery = 'UPDATE pasajeros SET checked = ? WHERE id = ?';
                    $updateStmt = $this->getConn()->prepare($updateQuery);
                    $updateStmt->execute([$newChecked, $id]);
                }

                // Contamos el total de el form que se este enviando.
                $total = $_POST['Checkninos'] + $_POST['Checkadultos'] + $_POST['Checkgratis'];

                //Si se ha cambiado el N de personas le ponemos de tipo 2.
                if ($_POST['cantidad'] < $total) {
                    $updateQuery = 'UPDATE pasajeros SET checked = 2 WHERE id = ?';
                    $updateStmt = $this->getConn()->prepare($updateQuery);
                    $updateStmt->execute([$id]);


                    // Actualiza el número de personas subidas a medias
                    $updateQuery = 'UPDATE pasajeros SET subidos = ? WHERE id = ?';
                    $updateStmt = $this->getConn()->prepare($updateQuery);
                    $updateStmt->execute([$_POST['cantidad'], $id]);
                }

                echo '<button onclick="toggleContarPersonas()" type="button" class="boton-anadir-pasante" style="background-color:#8ac926;">👥 Mostrar/Ocultar Información del barco</button>';
                echo '<div id="contarPersonasContainer" style="display:none;">';
                $this->showContarPersonas();
                echo '</div>';
                $this->showAllPasajeros();
                $this->showBalance();

            }
        }


        public function pasante() {
            $query = 'INSERT INTO pasajeros 
                (id, creacion, f_entrada, f_actualizada, n_noches, origen, usuario, anulada_por,
                producto, hora, ocupacion, nombre, apellido_1, apellido_2, e_mail, telefono,
                comentario, comentario_interno, estado, importe, factura, adultos, ninos, senior, gratis)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
            $stmt = $this->getConn()->prepare($query);
        
            // Valores por defecto del formulario
            $defaults = [
                "nombre" => "pasante",
                "apellido_1" => "pasante",
                "apellido_2" => "pasante",
                "telefono" => "+34666666666",
                "adultos" => 0,
                "ninos" => 0,
                "gratis" => 0
            ];
        
            // Sobrescribimos con los datos del POST si existen
            if (isset($_POST['pasante']) && is_array($_POST['pasante'])) {
                $postData = $_POST['pasante'];
                foreach ($defaults as $key => $value) {
                    if (isset($postData[$key])) {
                        $defaults[$key] = $postData[$key];
                    }
                }
            }
        
            // Valores automáticos o vacíos
            $now = date("Y-m-d H:i:s");
        
            $stmt->execute([
                null,                    // id (auto-incremental en la base de datos)
                $now,                    // creacion
                $now,                    // f_entrada
                $now,                    // f_actualizada
                1,                       // n_noches
                "pasante",              // origen
                "pasante",                 // usuario
                "",                      // anulada_por
                "CRUCERO POR EL JÚCAR",              // producto
                date("H:i"),             // hora
                "Pasante",             // ocupacion
                $defaults["nombre"],
                $defaults["apellido_1"],
                $defaults["apellido_2"],
                "",                      // e_mail
                $defaults["telefono"],
                "",                      // comentario
                "",                      // comentario_interno
                "pasante",            // estado
                0.00,                    // importe
                0,                       // factura
                $defaults["adultos"],
                $defaults["ninos"],
                0,                       // senior
                $defaults["gratis"]
            ]);
        
        }

        public function delpasante(){

        }
    
}
