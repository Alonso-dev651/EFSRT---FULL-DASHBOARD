<?php
include ("php/db_conexion.php");

// Usar el valor fijo 74
$codLoginFijo = 74;

// Consultar los datos del registro para el codLogin fijo
$sql = "SELECT * FROM personal WHERE codLogin = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $codLoginFijo);  
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $personal = $result->fetch_assoc();

    $apellidoPaterno = $personal['apPaterno'];
    $apellidoMaterno = $personal['apMaterno'];
    $nombresPersonal = $personal['nombres'];
} else {
    echo "No se encontraron datos para el codLogin proporcionado.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="stylesF.css">
    <link href="Icons_Dash/Logo.ico" rel="icon">
    <script defer src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script defer src="main.js"></script>

    <!-- añadiendo fontawesome para icono editar -->
    <script src="https://kit.fontawesome.com/a683fc1d22.js" crossorigin="anonymous"></script>

    <title>EFSRT Dashboard</title>
</head>

<body>
    <nav class="main-menu">
        <div>
            <div class="logo">
                <img src="Icons_Dash/Logo.ico" alt="logo" />
            </div>

            <div class="user-info">
                <img src="https://cdn-icons-png.flaticon.com/512/7816/7816916.png" alt="user" />
                <p>Soporte</p>
                <!-- <p><?php //echo isset($nombresPersonal) ? $nombresPersonal . ' ' . $apellidoPaterno . ' ' . $apellidoMaterno : ''; ?></p> -->
            </div>
            <ul>
                <!-- <li class="nav-item">
                    <a href="Pages_Dash/user.php">
                        <i class="fa fa-user nav-icon"></i>
                        <span class="nav-text">Cuenta</span>
                    </a>
                </li> -->

                <li class="nav-item active">
                    <a href="index.php">
                        <i class="fa-solid fa-table nav-icon"></i>
                        <span class="nav-text">Tablero</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#">
                        <i class="fa fa-arrow-trend-up nav-icon"></i>
                        <span class="nav-text">Tramite</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#">
                        <i class="fa-solid fa-chart-simple nav-icon"></i>
                        <span class="nav-text">Estado</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#">
                        <i class="fa fa-circle-info nav-icon"></i>
                        <span class="nav-text">Ayuda</span>
                    </a>
                </li>
            </ul>
        </div>

        <ul>
            <li class="nav-item">
                <a href="https://proyecto.live-ra.com">
                    <i class="fa fa-right-from-bracket nav-icon"></i>
                    <span class="nav-text">Salir</span>
                </a>
            </li>
        </ul>
    </nav>

    <section class="content">
        <div class="left-content">
            <!-- Inicio de la vista de los registros -->
            <div style="display: flex; justify-content: center; align-items: center;">
                <h1>ACTUALIZAR DATOS DEL PERSONAL</h1>
            </div>
            <hr>

            <?php
            include 'php/db_conexion.php';

            // Verificar si se va a editar un registro
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consultar los datos del registro para el ID dado
                $sql = "SELECT * FROM personal WHERE codLogin = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $personal = $result->fetch_assoc();

                    $apellidoPaterno = $personal['apPaterno'];
                    $apellidoMaterno = $personal['apMaterno'];
                    $nombresPersonal = $personal['nombres'];
                    $tipoDocumento = $personal['tipoDocu'];
                    $nroDocumento = $personal['nroDocu'];
                    $telefono = $personal['telf'];
                    $celular = $personal['celular'];
                    $correoJP = $personal['correoJP'];
                    $correoPersonal = $personal['correoPersonal'];
                    $direccion = $personal['direccion'];
                    $estable = $personal['estable'];
                    $anioNombramiento = $personal['anioNombramiento'];
                    $anioCese = $personal['anioCese'];
                    $codigoPlaza = $personal['codigoPlaza'];
                    $anioIngresoContratado = $personal['anioIngresoContratado'];
                    $fechaIniContrato = $personal['fechaIniContrato'];
                    $fechaTerContrato = $personal['fechaTerContrato'];
                    $estadoPersonal = $personal['estado'];
                    $tipoPersonal = $personal['tipoPer'];

                    $codDis = $personal['codDis']; // Código de ubigeo guardado
                    $codEsp = $personal['codEsp']; // Código de especialidad guardado

                    // Obtener los datos del ubigeo (departamento, provincia, distrito)
                    $sqlUbigeo = "SELECT nomDptoUbi, nomProvUbi, nomDisUbi FROM ubigeo WHERE codUbi = ?";
                    $stmtUbigeo = $conexion->prepare($sqlUbigeo);
                    $stmtUbigeo->bind_param("i", $codDis);
                    $stmtUbigeo->execute();
                    $resultUbigeo = $stmtUbigeo->get_result();

                    if ($resultUbigeo->num_rows > 0) {
                        $ubigeo = $resultUbigeo->fetch_assoc();
                        $nomDptoUbi = $ubigeo['nomDptoUbi'];
                        $nomProvUbi = $ubigeo['nomProvUbi'];
                        $nomDisUbi = $ubigeo['nomDisUbi'];
                    }

                    // Obtener el nombre de la especialidad
                    $sqlEsp = "SELECT nomEsp FROM especialidad WHERE codEsp = ?";
                    $stmtEsp = $conexion->prepare($sqlEsp);
                    $stmtEsp->bind_param("i", $codEsp);
                    $stmtEsp->execute();
                    $resultEsp = $stmtEsp->get_result();
                    if ($resultEsp->num_rows > 0) {
                        $especialidad = $resultEsp->fetch_assoc();
                        $nomEsp = $especialidad['nomEsp'];
                    }
                }
            }
            ?>

            <form action="php/modificar_personal.php" method="POST">
                <input type="hidden" name="codLogin" value="<?= isset($id) ? $id : '' ?>">
                <label for="tipoPersonal">Tipo de Personal</label>
                <select name="tipoPersonal" id="tipoPersonal" required>
                    <option value="DOCENTE" <?= isset($tipoPersonal) && $tipoPersonal == 'DOCENTE' ? 'selected' : '' ?>>Docente</option>
                    <option value="COORDINADOR" <?= isset($tipoPersonal) && $tipoPersonal == 'COORDINADOR' ? 'selected' : '' ?>>Coordinador</option>
                    <option value="DIRECTIVO" <?= isset($tipoPersonal) && $tipoPersonal == 'DIRECTIVO' ? 'selected' : '' ?>>Directivo</option>
                </select>

                <br><br>

                <label for="apellidoPaterno">Apellido Paterno</label>
                <input type="text" name="apellidoPaterno" id="apellidoPaterno" value="<?= isset($apellidoPaterno) ? $apellidoPaterno : '' ?>" required maxlength="30" oninput="soloLetras(event)">

                <br><br>

                <label for="apellidoMaterno">Apellido Materno</label>
                <input type="text" name="apellidoMaterno" id="apellidoMaterno" value="<?= isset($apellidoMaterno) ? $apellidoMaterno : '' ?>" required maxlength="30" oninput="soloLetras(event)">

                <br><br>

                <label for="nombresPersonal">Nombres</label>
                <input type="text" name="nombresPersonal" id="nombresPersonal" value="<?= isset($nombresPersonal) ? $nombresPersonal : '' ?>" required maxlength="40" oninput="soloLetras(event)">

                <br><br>

                <label for="tipoDocumento">Tipo de Documento</label>
                <select name="tipoDocumento" id="tipoDocumento" required>
                    <option value="DNI" <?= isset($tipoDocumento) && $tipoDocumento == 'DNI' ? 'selected' : '' ?>>DNI</option>
                    <option value="CEX" <?= isset($tipoDocumento) && $tipoDocumento == 'CEX' ? 'selected' : '' ?>>CEX</option>
                    <option value="PAS" <?= isset($tipoDocumento) && $tipoDocumento == 'PAS' ? 'selected' : '' ?>>PAS</option>
                </select>

                <br><br>

                <label for="nroDocumento">Número de Documento</label>
                <input type="text" name="nroDocumento" id="nroDocumento" value="<?= isset($nroDocumento) ? $nroDocumento : '' ?>" required maxlength="15">

                <br><br>

                <label for="telefono">Teléfono Fijo</label>
                <input type="tel" name="telefono" id="telefono" value="<?= isset($telefono) ? $telefono : '' ?>" required maxlength="30" oninput="soloNumeros(event)">

                <br><br>

                <label for="celular">Celular de Contacto</label>
                <input type="tel" name="celular" id="celular" value="<?= isset($celular) ? $celular : '' ?>" required maxlength="9" oninput="soloNumeros(event)">

                <br><br>

                <label for="correoJosePardo">Correo Electrónico Institucional</label>
                <input type="email" name="correoJosePardo" id="correoJosePardo" value="<?= isset($correoJP) ? $correoJP : '' ?>" placeholder="UNICO" required maxlength="80">

                <br><br>

                <label for="correoPersonal">Correo Electrónico Personal</label>
                <input type="email" name="correoPersonal" id="correoPersonal" value="<?= isset($correoPersonal) ? $correoPersonal : '' ?>" required maxlength="80">

                <br><br>

                <label for="departamento">Departamento:</label>
                <select name="departamento" id="departamento" required>
                    <option value="<?= isset($nomDptoUbi) ? $nomDptoUbi : '' ?>"><?= isset($nomDptoUbi) ? $nomDptoUbi : 'Seleccione un departamento' ?></option>
                </select>

                <label for="provincia">Provincia:</label>
                <select name="provincia" id="provincia" required>
                    <option value="<?= isset($nomProvUbi) ? $nomProvUbi : '' ?>"><?= isset($nomProvUbi) ? $nomProvUbi : 'Seleccione una provincia' ?></option>
                </select>

                <label for="distrito">Distrito:</label>
                <select name="distrito" id="distrito" required>
                    <option value="<?= isset($nomDisUbi) ? $nomDisUbi : '' ?>"><?= isset($nomDisUbi) ? $nomDisUbi : 'Seleccione un distrito' ?></option>
                </select>

                <br><br>

                <label for="direccion">Escribe la dirección</label>
                <input type="text" name="direccion" id="direccion" value="<?= isset($direccion) ? $direccion : '' ?>" required maxlength="120">

                <br><br>

                <label for="codigoEspecialidad">Especialidad</label>
                <select name="codigoEspecialidad" id="codigoEspecialidad" required>
                    <option value="<?= isset($codEsp) ? $codEsp : '' ?>"><?= isset($nomEsp) ? $nomEsp : 'Seleccione una especialidad' ?></option>
                    <?php include 'php/mostrar_especialidad.php' ?>
                </select>

                <br><br>

                <label for="estable">Estable</label>
                <select name="estable" id="estable" required>
                    <option value="S" <?= isset($estable) && $estable == 'S' ? 'selected' : '' ?>>Si</option>
                    <option value="N" <?= isset($estable) && $estable == 'N' ? 'selected' : '' ?>>No</option>
                </select>

                <br><br>

                <label for="anioNombramiento">Año de Nombramiento</label>
                <input type="text" name="anioNombramiento" id="anioNombramiento" value="<?= isset($anioNombramiento) ? $anioNombramiento : '' ?>" required maxlength="4" oninput="soloNumeros(event)">

                <br><br>

                <label for="anioCese">Año de Cese</label>
                <input type="text" name="anioCese" id="anioCese" value="<?= isset($anioCese) ? $anioCese : '' ?>" required maxlength="4" oninput="soloNumeros(event)">

                <br><br>

                <label for="codigoPlaza">Código de Plaza</label>
                <input type="text" name="codigoPlaza" id="codigoPlaza" value="<?= isset($codigoPlaza) ? $codigoPlaza : '' ?>" required maxlength="30">

                <br><br>

                <label for="anioIngresoContratado">Año de Ingreso Contratado</label>
                <input type="text" name="anioIngresoContratado" id="anioIngresoContratado" value="<?= isset($anioIngresoContratado) ? $anioIngresoContratado : '' ?>" required maxlength="4" oninput="soloNumeros(event)">

                <br><br>

                <label for="fechaIniContrato">Fecha de Inicio de Contrato</label>
                <input type="date" name="fechaIniContrato" id="fechaIniContrato" value="<?= isset($fechaIniContrato) ? $fechaIniContrato : '' ?>" required>

                <br><br>

                <label for="fechaTerContrato">Fecha de Término de Contrato</label>
                <input type="date" name="fechaTerContrato" id="fechaTerContrato" value="<?= isset($fechaTerContrato) ? $fechaTerContrato : '' ?>" required>

                <br><br>

                <label for="estado">Estado del Personal</label>
                <select name="estado" id="estado" required>
                    <option value="Activo" <?= isset($estadoPersonal) && $estadoPersonal == 'Activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="Inactivo" <?= isset($estadoPersonal) && $estadoPersonal == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>

                <br><br>

                <button type="submit">Modificar Personal</button>
                <button class="cancelar" type="button" onclick="location.href='index.php'">Cancelar</button>
            </form>
            
        </div>
    </section>

    <script src="js/ubigeo.js"></script>
    <script src="js/formulario.js"></script>
</body>

</html>

<script>
    // Solo permite letras en el campo
    function soloLetras(e) {
        const key = e.keyCode || e.which;
        const tecla = String.fromCharCode(key);
        const letras = /^[A-Za-z\s]+$/;
        if (!letras.test(tecla)) {
            e.preventDefault();
        }
    }

    // Solo permite números en el campo
    function soloNumeros(e) {
        const key = e.keyCode || e.which;
        const tecla = String.fromCharCode(key);
        const numeros = /^[0-9]+$/;
        if (!numeros.test(tecla)) {
            e.preventDefault();
        }
    }
</script>