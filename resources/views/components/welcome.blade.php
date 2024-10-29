<div class="grid grid-cols-2 p-6 lg:p-8 bg-white border-b border-gray-200">
    @if(auth()->user()->estado_id == '1')
        @if(auth()->user()->rol_id == '2')
            <!-- Contenido para profesores -->
            <x-card tittle="Ver clases" description="Visualiza las clases que tienes asignadas como profesor de baile" ruta="lsn.r"/>
        @endif
        @if(auth()->user()->rol_id == '1')
            <!-- Contenido para estudiantes -->
            <x-card tittle="Inscripcion de clase" description="Mira las clases disponibles para incribirte a alguna de las clases" ruta="ncp.r"/>
        @endif
        @if(auth()->user()->rol_id == '3')
            <!-- Contenido para administradores -->
            <x-card tittle="Registrar usuario" description="Realizar el registro de nuevos usuarios" ruta="usr.r"/>
            <x-card tittle="Registrar profesor" description="Realizar el registro, edicion y ver el listado de los profesores" ruta="tch.r"/>
            <x-card tittle="Registrar estudiantes" description="Realizar el registro, edicion y ver el listado de los alumnos" ruta="std.r"/>
            <x-card tittle="Registrar pagos" description="Realizar registro de pagos" ruta="pym.r"/>
            <x-card tittle="Registrar clases" description="Realizar registro de las clases programadas por los profesores" ruta="lsn.r"/>
            <x-card tittle="Registrar Inscripciones" description="Realizar la inscripcion a las clases registradas" ruta="ncp.r"/>    
        @endif
    @else
    <div>Usted se encuentra en estado PRE-REGISTRO, por favor comuniquese con su administrador</div>
    @endif

</div>
