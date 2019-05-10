<div id="dialog-form2" title="Inicio Sesion" style="display: none;">
    <p class="validateTips"></p>
    <section id="section_wrap">
        <form class="form-actions" style="margin: 0 auto !important; width: 220px;">
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" value="prueba@correo.com">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="pass">Contraseña</label>
                <div class="controls">
                    <input type="password" id="pass" name="pass" placeholder="********" value="prueba">
                    <input type="hidden" name="op" id="op" value="usrlogin"/>
                    <input type="hidden" name="ti" id="ti"/>
                    <input type="hidden" name="ke" id="ke"/>
                    <input type="hidden" name="fuente" id="fuente" value="franquicias_web"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="color: red !important;">
                    <?php echo $mensaje ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-info">Ingresar</button>
                    <a href="#" id="registro" class="btn btn-info botoncrear">Registro</a>
                </div>
            </div>
        </form>
    </section>
</div>