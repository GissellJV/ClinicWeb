@extends('layouts.plantillaDoctor')
@section('contenido')
    <?php
        $host = "localhost";
        $user = "root";
        $pass = "DoctorWho1412";
        $db = "clinicweb";

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn ->connect_errno) {
            die("Error de conexion: " . $conn->connect_error)
        }

        $sql = "SELECT nombre, especialidad, horario, foto FROM doctores";
        $result = $conn->query($sql);
    ?>

    <div class="row">
        <?php
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { ?>
        <div class="col-md-6 mb-4">
            <div class="card mb-3 shadow-sm" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="images/<?php echo $row['foto'] ?: 'default.jpg'; ?>"
                             class="img-fluid rounded-start"
                             alt="<?php echo $row['nombre']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                            <p class="card-text"><strong>Especialidad:</strong> <?php echo $row['especialidad']; ?></p>
                            <p class="card-text"><strong>Horario:</strong> <?php echo $row['horario']; ?></p>
                            <p class="card-text">
                                <small class="text-body-secondary">Disponible ahora</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <?php
        }
        } else {
            echo "<p class='text-center'>No hay doctores disponibles.</p>";
        }
        ?>
    </div>
@endsection
