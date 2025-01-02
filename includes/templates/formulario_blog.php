<fieldset>
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="blog[titulo]" placeholder="Título del Blog" value="<?php echo s($entrada->titulo); ?>">

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="blog[autor]" placeholder="Autor del Blog" value="<?php echo s($entrada->autor); ?>">

    <label for="contenido">Contenido:</label>
    <textarea id="contenido" name="blog[contenido]"><?php echo s($entrada->contenido); ?></textarea>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="blog[imagen]">

</fieldset>