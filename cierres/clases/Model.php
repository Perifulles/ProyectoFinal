<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Model extends ConexionCierre
{

    // This function is used to import data from an Excel file into the database
    public function import()
    {
        $rutaArchivo = "./excels/cierre.xlsx";
    
        if (!file_exists($rutaArchivo)) {
            die("El archivo <strong>$rutaArchivo</strong> no existe.");
        }
    
        $conn = $this->getConn();
        $spreadsheet = IOFactory::load($rutaArchivo);
        $sheet = $spreadsheet->getActiveSheet();
        $totalRows = $sheet->getHighestRow();
    
        $queryCliente = 'INSERT INTO clientes (id_cliente, nombre, apellido1, apellido2, email, telefono)
                         VALUES (?, ?, ?, ?, ?, ?)
                         ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), apellido1=VALUES(apellido1), apellido2=VALUES(apellido2),
                                                 email=VALUES(email), telefono=VALUES(telefono)';
    
        $queryReserva = 'INSERT INTO reservas (
            id_reserva, fecha_creacion, fecha_entrada, fecha_salida, fecha_actualizada,
            origen, usuario, anulada_por, producto, hora, ocupacion,
            comentario, comentario_interno, estado, importe, factura, visa, efectivo, id_cliente
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    
        $stmtCliente = $conn->prepare($queryCliente);
        $stmtReserva = $conn->prepare($queryReserva);
    
        for ($row = 3; $row <= $totalRows; $row++) {
            $id = $sheet->getCell("A$row")->getValue();
            $creacion = $sheet->getCell("B$row")->getValue();
            $f_entrada = $sheet->getCell("C$row")->getValue();
            $f_salida = $sheet->getCell("D$row")->getValue();
            $f_actualizada = $sheet->getCell("E$row")->getValue();
            $n_noches = $sheet->getCell("F$row")->getValue();
            $origen = $sheet->getCell("G$row")->getValue();
            $usuario = $sheet->getCell("H$row")->getValue();
            $anulada_por = $sheet->getCell("I$row")->getValue();
            $producto = $sheet->getCell("J$row")->getValue();
            $hora = $sheet->getCell("K$row")->getValue();
            $ocupacion = $sheet->getCell("L$row")->getValue();
            $nombre = $sheet->getCell("M$row")->getValue();
            $apellido_1 = $sheet->getCell("N$row")->getValue();
            $apellido_2 = $sheet->getCell("O$row")->getValue();
            $email = $sheet->getCell("P$row")->getValue();
            $telefono = $sheet->getCell("Q$row")->getValue();
            $comentario = $sheet->getCell("R$row")->getValue();
            $comentario_interno = $sheet->getCell("S$row")->getValue();
            $estado = $sheet->getCell("T$row")->getValue();
            $importe = $sheet->getCell("U$row")->getValue();
            $factura = $sheet->getCell("V$row")->getValue();
            $visaefect = $this->procesarImporte($importe);
            $visa = $visaefect['visa'];
            $efectivo = $visaefect['efectivo'];
    
            // Conversión de fechas
            $f_entrada = self::convertToDate($f_entrada);
            $f_salida = self::convertToDate($f_salida);
            $f_actualizada = self::convertToDate($f_actualizada);
            $creacion = self::convertToDate($creacion);
    
            // Insertar cliente
            $stmtCliente->execute([
                $id, $nombre, $apellido_1, $apellido_2, $email, $telefono
            ]);
    
            // Insertar reserva
            $stmtReserva->execute([
                $id, $creacion, $f_entrada, $f_salida, $f_actualizada,
                $origen, $usuario, $anulada_por, $producto, $hora, $ocupacion,
                $comentario, $comentario_interno, $estado, $importe, $factura, $visa, $efectivo, $id
            ]);
        }
    }

    function procesarImporte($importeTexto) {
        // Elimina símbolos y palabras no deseadas
        $limpio = str_replace(['€', ','], ['', '.'], $importeTexto);
        $limpio = str_replace(['Pagada T.Crédito', 'Pagada Establecimiento'], '', $limpio);
        $limpio = trim($limpio);
    
        // Intentamos convertirlo en número
        $monto = is_numeric($limpio) ? floatval($limpio) : null;
    
        // Detectamos el método de pago
        if (strpos($importeTexto, 'Pagada T.Crédito') !== false) {
            return ['visa' => $monto, 'efectivo' => null];
        } elseif (strpos($importeTexto, 'Pagada Establecimiento') !== false) {
            return ['visa' => null, 'efectivo' => $monto];
        } else {
            return ['visa' => null, 'efectivo' => null];
        }
    }
    

    private static function convertToDate($excelDate)
    {
        if (!$excelDate) return null;

        // Si es un valor numérico (fecha de Excel), lo convertimos
        if (is_numeric($excelDate)) {
            $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($excelDate);
            return date('Y-m-d H:i:s', $timestamp);
        }

        // Si ya es un string tipo fecha, intentamos formatearlo
        $date = date_create($excelDate);
        return $date ? $date->format('Y-m-d H:i:s') : null;
    }
    public function deleteList()
    {
        $query = 'DELETE FROM reservas';
        $this->getConn()->query($query);
    }

    public function init()
    {
        try {
            $this->backupCierre();
            $this->deleteList();
            $this->import();
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function getClientes()
    {
        $conn = $this->getConn();
        $stmt = $conn->query("SELECT * FROM clientes ORDER BY id_cliente");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservas()
    {
        $conn = $this->getConn();
        $stmt = $conn->query("SELECT * FROM reservas ORDER BY id_reserva");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showCierre($camposSeleccionados = [])
    {
        $clientes = $this->getClientes();
        $reservas = $this->getReservas();
    
        // Definir todos los posibles campos
        $todosCampos = [
            'id_reserva' => 'ID Reserva',
            'fecha_creacion' => 'Fecha Creación',
            'fecha_entrada' => 'Fecha Entrada',
            'fecha_actualizada' => 'Fecha Actualizada',
            'origen' => 'Origen',
            'usuario' => 'Usuario',
            'anulada_por' => 'Anulada Por',
            'producto' => 'Producto',
            'hora' => 'Hora',
            'ocupacion' => 'Ocupación',
            'nombre' => 'Nombre',
            'apellido1' => 'Apellido 1',
            'apellido2' => 'Apellido 2',
            'email' => 'Email',
            'telefono' => 'Teléfono',
            'comentario' => 'Comentario',
            'comentario_interno' => 'Comentario Interno',
            'estado' => 'Estado',
            'importe' => 'Importe',
            'factura' => 'Factura',
            'visa' => 'Visa',
            'efectivo' => 'Efectivo'
        ];
    
        echo '<table class="greenTable">';
        echo '<thead><tr>';
        foreach ($todosCampos as $campo => $etiqueta) {
            if (in_array($campo, $camposSeleccionados)) {
                echo "<th>$etiqueta</th>";
            }
        }
        echo '<th colspan="2">Acciones</th></thead>';
        echo '<tbody>';
    
        foreach ($reservas as $reserva) {
            $cliente = null;
            foreach ($clientes as $cl) {
                if ($cl['id_cliente'] == $reserva['id_cliente']) {
                    $cliente = $cl;
                    break;
                }
            }
    
            echo '<tr>';
            foreach ($todosCampos as $campo => $etiqueta) {
                if (in_array($campo, $camposSeleccionados)) {
                    // Buscar el valor del campo ya sea en reserva o cliente
                    $valor = $reserva[$campo] ?? ($cliente[$campo] ?? '');
                    echo '<td>' . htmlspecialchars($valor) . '</td>';
                }
            }
    
            echo '<td style="text-align: center;">
                    <form action="modificar.php" method="POST">
                    <input type="hidden" name="id_reserva" value="' . $reserva['id_reserva'] . '">
                    <input type="submit" class="bononcheck" name="Modificar" value="Modificar">
                    </form>
                  </td>';
                  echo '<td style="text-align: center;">
                    <form action="eliminar.php" method="POST" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar esta reserva?\');">
                      <input type="hidden" name="id_reserva" value="' . $reserva['id_reserva'] . '">
                      <input type="submit" class="bononcheck" name="Eliminar" value="Eliminar" style="background-color: #ff4d4d;">
                    </form>
                    </td>';
            echo '</tr>';
        }
    
        echo '</tbody></table>';
    }

    public function showTotales()
    {
        $reservas = $this->getReservas();
        $totalVisa = 0;
        $totalEfectivo = 0;
    
        foreach ($reservas as $reserva) {
            $totalVisa += floatval($reserva['visa']);
            $totalEfectivo += floatval($reserva['efectivo']);
        }
    
        echo '
        <div id="totalesBox" class="totales-box">
            <h3>Totales de pago</h3>
            <p><strong>Total Visa:</strong> ' . number_format($totalVisa, 2, ',', '.') . ' €</p>
            <p><strong>Total Efectivo:</strong> ' . number_format($totalEfectivo, 2, ',', '.') . ' €</p>
        </div>
        ';
    }
    
    
    public function backupCierre() {
        $tablas = [
            'clientes' => $this->getClientes(),
            'reservas' => $this->getReservas()
        ];
    
        if (!is_dir('backups')) {
            mkdir('backups', 0777, true);
        }
    
        foreach ($tablas as $nombreTabla => $datos) {
            $sql = "";
            foreach ($datos as $fila) {
                $columnas = array_keys($fila);
                $valores = array_map(function ($valor) {
                    return is_null($valor) ? 'NULL' : "'" . addslashes($valor) . "'";
                }, array_values($fila));
    
                $sql .= "INSERT INTO $nombreTabla (" . implode(", ", $columnas) . ") VALUES (" . implode(", ", $valores) . ");\n";
            }
    
            $nombreArchivo = "backups/backup{$nombreTabla}.sql";
            file_put_contents($nombreArchivo, $sql);
        }
    }
    
    public function restoreBackup() {
        // Orden correcto: primero reservas (hija), luego clientes (padre)
        $tablas = ['reservas', 'clientes'];
    
        // Eliminar datos actuales
        foreach ($tablas as $tabla) {
            $this->getConn()->exec("DELETE FROM $tabla;");
        }
    
        // Restaurar backups en orden inverso: primero clientes, luego reservas
        $tablasRestaurar = ['clientes', 'reservas'];
        foreach ($tablasRestaurar as $tabla) {
            $nombreArchivo = "backups/backup{$tabla}.sql";
            if (!file_exists($nombreArchivo)) {
                throw new Exception("No se encontró el archivo de backup: $nombreArchivo");
            }
    
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
                throw new Exception("Error al leer el archivo de backup: $nombreArchivo");
            }
        }
    }
    
    

    public function getReservaPorId($id)
    {
    $stmt = $this->getConn()->prepare("SELECT * FROM reservas WHERE id_reserva = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
    }

    public function getClientePorId($id)
    {
        $stmt = $this->getConn()->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function actualizarReserva($id, $importe, $visa, $efectivo)
    {
    $sql = "UPDATE reservas SET importe = ?, visa = ?, efectivo = ? WHERE id_reserva = ?";
    $stmt = $this->getConn()->prepare($sql);
    return $stmt->execute([$importe, $visa, $efectivo, $id]);
        }

    public function actualizarCliente($id, $nombre, $apellido1, $apellido2, $telefono, $email)
    {
        $sql = "UPDATE clientes SET nombre = ?, apellido1 = ?, apellido2 = ?, telefono = ?, email = ? WHERE id_cliente = ?";
        $stmt = $this->getConn()->prepare($sql);
        return $stmt->execute([$nombre, $apellido1, $apellido2, $telefono, $email, $id]);
    }


    public function eliminarReserva($id) {
        $stmt = $this->getConn()->prepare("DELETE FROM reservas WHERE id_reserva = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function eliminarCliente($id) {
        $stmt = $this->getConn()->prepare("DELETE FROM clientes WHERE id_cliente = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();}
}