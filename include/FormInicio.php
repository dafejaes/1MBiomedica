<div id="Inicio_Sesion" title="Inicio Sesion" style="display: none;">
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
                </div>
            </div>
        </form>
    </section>
</div>

<div id="Actualizar_informacion" title="Actualizar Información" style="display: none">
    <p class="validateTips"></p>
    <form class="form-horizontal" id="formactualizar">
        <div class="control-group">
            <label class="control-label">Nombres*</label>
            <div class="controls"><input type="text" name="nombre5" id="nombre5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Apellidos*</label>
            <div class="controls"><input type="text" name="apellido5" id="apellido5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Cedula</label>
            <div class="controls"><input type="text" name="cedula5" id="cedula5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Email*</label>
            <div class="controls"><input type="email" name="email5" id="email5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Contraseña Actual*</label>
            <div class="controls"><input type="password" name="password5" id="password5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Contraseña Nueva*</label>
            <div class="controls"><input type="password" name="password6" id="password6" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Repita Contraseña*</label>
            <div class="controls"><input type="password" name="password7" id="password7" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Fecha Nacimiento</label>
            <div class="controls"><input type="text" name="fechanacimiento5" id="fechanacimiento5" readonly="true" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Ciudad*</label>
            <div class="controls"><input type="text" name="ciudad5" id="ciudad5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Departamento*</label>
            <div class="controls"><input type="text" name="departamento5" id="departamento5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">Dirección*</label>
            <div class="controls"><input type="text" name="direccion5" id="direccion5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">¿El usuario es ingeniero?</label>
            <div class="controls"><input type="checkbox" name="ing5" id="ing5" value = "ing5" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">¿Desea inscribirse a nuestra linea de correos?</label>
            <div class="controls"><input type="checkbox" name="lineacorreo5" id="lineacorreo5" value = "lineaco" class="text ui-widget-content ui-corner-all" /></div>
        </div>
        <div class="control-group">
            <label class="control-label">¿Desea recibir correos especiales?</label>
            <div class="controls"><input type="checkbox" name="especialco5" id="especialco5" value = "especialco" class="text ui-widget-content ui-corner-all" /></div>
        </div>
    </form>
</div>