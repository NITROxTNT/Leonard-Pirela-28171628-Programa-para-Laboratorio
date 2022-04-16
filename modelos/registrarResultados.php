<?php 

require('../fpdf/fpdf.php');
require('./enviarPDF.php');


$datosUsuario = array();
$datosExamen = array();

foreach ($_POST as $nombreValor => $valor) {

    if (empty($valor)) {
        echo "Uno o más de los campos se encuentran vacíos, rellene todos los campos"; die();
    }

    if ($nombreValor == 'usuarioCedula' || $nombreValor == 'usuarioNombre' || $nombreValor == 'usuarioMail' || $nombreValor == 'usuarioEdad') {
        $datosUsuario[$nombreValor] = $valor;
    } 
    else {
        $datosExamen[$nombreValor] = $valor;
    }
}

$pdf = new FPDF();
$tituloPdf = "Resultados de examen de " . $datosExamen['examenSeleccionado'] . " del paciente " . $datosUsuario['usuarioNombre'] . " " . $datosUsuario['usuarioCedula'];
$pdf->AddPage();
$pdf->SetTitle($tituloPdf);

$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 10, 'Laboratorios Pirela' , 0, 1); $pdf->Ln();

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 10, 'Resultados de Examen de ' . $datosExamen['examenSeleccionado'] , 0, 1); $pdf->Ln();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(80, 5 , 'Fecha del examen: '); $pdf->Cell(0, 5 , $datosExamen['resultFecha']);  $pdf->Ln();
$pdf->Cell(80, 5 , 'Nombre del paciente: '); $pdf->Cell(0, 5 , $datosUsuario['usuarioNombre']);  $pdf->Ln();
$pdf->Cell(80, 5 , 'Cedula del paciente: '); $pdf->Cell(0, 5 , $datosUsuario['usuarioCedula']);  $pdf->Ln();
$pdf->Cell(80, 5 , 'Edad del paciente: '); $pdf->Cell(0, 5 , $datosUsuario['usuarioEdad']);  $pdf->Ln();
$pdf->Cell(80, 5 , 'Correo del paciente: '); $pdf->Cell(0, 5 , $datosUsuario['usuarioMail']);  $pdf->Ln();

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 12);
foreach ($datosExamen as $nombreValor => $valor) {
if ($nombreValor == 'resultFecha' || $nombreValor == 'examenSeleccionado') {
    continue;
}
    $pdf->Cell(50, 5 , $nombreValor , 1);
    $pdf->Cell(50, 5 , $valor , 1);
    $pdf->Ln();

}

$nombrePdf = $datosUsuario['usuarioCedula'] . $datosExamen['examenSeleccionado'] . $datosExamen['resultFecha'] . '.pdf';
$pdf->Output('F', '../resultados/' . $nombrePdf);

guardarRegistros($datosUsuario, $datosExamen, $nombrePdf);

echo enviarPDF($nombrePdf, $datosUsuario, $datosExamen);


function guardarRegistros ($datosUsuario, $datosExamen, $nombrePdf) {

    require_once("conexionbdd.php");
    
    $consultaRegistro = $conexion->prepare("INSERT IGNORE INTO pacientes (paciente_nombre, paciente_cedula, paciente_email, paciente_edad) VALUES (?,?,?,?);");
    $consultaRegistro->bind_param("sisi", $datosUsuario['usuarioNombre'], $datosUsuario['usuarioCedula'], $datosUsuario['usuarioMail'], $datosUsuario['usuarioEdad'] );
    $consultaRegistro -> execute();
    
        if ($datosExamen['examenSeleccionado'] == 'orina') {
        $resultadosOrina = $conexion->prepare("INSERT INTO examen_orina (paciente_cedula, valor_ph, valor_glucosa, valor_densidad, valor_nitritos, valor_proteinas, valor_urobinilogeno, examen_fecha, ruta_pdf) VALUES (?,?,?,?,?,?,?,?,?);");
        $resultadosOrina->bind_param("iddddddss", $datosUsuario['usuarioCedula'], $datosExamen['PH'], $datosExamen['Glucosa'], $datosExamen['Densidad'], $datosExamen['Nitritos'], $datosExamen['Proteinas'], $datosExamen['Urobinilogeno'], $datosExamen['resultExamen'], $nombrePdf);
        $resultadosOrina -> execute(); return;
        }
    
        if ($datosExamen['examenSeleccionado'] == 'sangre') {
        $resultadosSangre  = $conexion->prepare("INSERT INTO examen_sangre (paciente_cedula, valor_colesterol, valor_trigliceridos, valor_leucocitos, valor_plaquetas, valor_hemoglobina, valor_glucosa, examen_fecha, ruta_pdf) VALUES (?,?,?,?,?,?,?,?,?);");
        $resultadosSangre ->bind_param("iddddddss", $datosUsuario['usuarioCedula'], $datosExamen['Colesterol'], $datosExamen['Trigliceridos'], $datosExamen['Leucocitos'], $datosExamen['Plaquetas'], $datosExamen['Hemoglobina'], $datosExamen['Glucosa'], $datosExamen['resultExamen'], $nombrePdf);
        $resultadosSangre  -> execute(); return;
        }

        if ($datosExamen['examenSeleccionado'] == 'sangre') {
        $resultadosHeces = $conexion->prepare("INSERT INTO examen_heces (paciente_cedula, valor_proteinas, valor_grasa, valor_minerales, valor_bacterias, valor_fibras, examen_fecha, ruta_pdf) VALUES (?,?,?,?,?,?,?,?,?);");
        $resultadosHeces->bind_param("idddddss", $datosUsuario['usuarioCedula'], $datosExamen['Proteinas'], $datosExamen['Grasa'], $datosExamen['Minerales'], $datosExamen['Bacterias'], $datosExamen['Fibras'], $datosExamen['resultExamen'], $nombrePdf);
        $resultadosHeces -> execute(); return;
        }
    
    
}



?>