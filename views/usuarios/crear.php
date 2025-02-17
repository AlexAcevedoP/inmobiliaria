<h1>Crear Usuario</h1>

<?php foreach ($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
<?php endforeach; ?>

<form method="POST" class="formulario">
    <fieldset>
        <legend>Información del Usuario</legend>

        <label for="email">Email:</label>
        <input type="email" id="email" name="usuario[email]" placeholder="Tu Email" value="<?php echo s($usuario->email); ?>">

        <label for="password">Password:</label>
        <input type="password" id="password" name="usuario[password]" placeholder="Tu Password">
    </fieldset>

    <input type="submit" value="Crear Usuario" class="boton boton-verde">
</form>