<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsignarTicketController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListaBitacoraController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\OficinaPeronsalController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ResumenGeneralController;
use App\Http\Controllers\RLaboralController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\AuthAdministrador;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});*/

Route::get('/', HomeController::class);
Route::post('home/listOficinas', [HomeController::class, 'actListaOficinas'])->name('HomeSelect.listaOficinas');
Route::post('home/listarIncidencia', [HomeController::class, 'actListaIncidencias'])->name('incSelect.listarIncidencia');
Route::get('home/buscarPerosnal', [HomeController::class, 'actBuscarPersonal'])->name('buscar.personal');
Route::post('home/registar', [HomeController::class, 'actRegistrar'])->name('registrar.tickets');
//Route::post('home/mostrar', [HomeController::class, 'actMostrarTabla'])->name('mostrar.tabla');
Route::post('home/consultar-tickets', [HomeController::class, 'consultarTickets'])->name('mostrarConsul.tabla');

/*  Login  */

Route::get('login', [loginController::class, 'actionLogin'])->name('login');
Route::post('login/sigin', [LoginController::class, 'sigin']);
Route::get('login/logout', [loginController::class, 'logout'])->name('logout');



// Rutas protegidas por autenticación
Route::middleware([AuthAdministrador::class])->group(function () {

    Route::get('homeAdmin',[HomeAdminController::class, 'index']);
    Route::get('homeAdmin/CantidadDatos', [HomeAdminController::class, 'actCatDatos'])->name('cantidadDatos');
    Route::get('homeAdmin/tickets-por-soporte', [HomeAdminController::class, 'getTicketsPorSoporte'])->name('cantTicketSoporte');
    Route::get('homeAdmin/tickets-por-usuario', [HomeAdminController::class, 'ticketsResueltosPorUsuario'])->name('cantticketsResueltosUsu');
    Route::get('homeAdmin/tickets-por-dia', [HomeAdminController::class, 'ticketsCreadosPorDiaDelMesActual'])->name('ticketsCreadosPorDiaDelMesActual');
    Route::get('homeAdmin/top5Oficinas', [HomeAdminController::class, 'top5OficinasConMasSolicitudes'])->name('top5OficinasConMasSolicitudes');
    Route::get('homeAdmin/top5Problemas', [HomeAdminController::class, 'top5ProblemasMasComunes'])->name('top5ProblemasMasComunes');

    Route::post('homeAdmin/dashboard/listarAsiganacion', [HomeAdminController::class, 'actListar'])->name('dashListaraAsig');
    Route::post('homeAdmin/listarPersonal', [HomeAdminController::class, 'actListaPersonal'])->name('dashListaPersonal');
    Route::post('homeAdmin/listarUsuario', [HomeAdminController::class, 'actListaUsuario'])->name('dashListaUsuario');
    Route::post('homeAdmin/listarIncidencia', [HomeAdminController::class, 'actListaIncidencia'])->name('dashListaIncidencia');
    Route::post('homeAdmin/listarOficinas', [HomeAdminController::class, 'actListaOficinas'])->name('dashListaOficinas');

    Route::post('homeAdmin/filtrar-asignaciones', [HomeAdminController::class, 'filtrarAsignaciones'])->name('dashFiltrar');

    Route::get('homeAdmin/dash-palabra-clave', [HomeAdminController::class, 'actBuscarPClave'])->name('dashBuscar.pCalve');


    Route::get('rlaboral', [RLaboralController::class, 'index'])->name('rlaboral.index');
    Route::post('rlaboral/listar', [RLaboralController::class, 'actListar'])->name('rlaboral.listar');
    Route::post('rlaboral/registrar', [RLaboralController::class, 'actRegistrar'])->name('rlaboral.registrar');
    Route::post('rlaboral/editar', [RLaboralController::class, 'actEditar'])->name('rlaboral.editar');
    Route::post('rlaboral/eliminar', [RLaboralController::class, 'actEliminar'])->name('rlaboral.eliminar');


    Route::get('incidencia', [SoporteController::class, 'index'])->name('incidencia.index');
    Route::post('incidencia/listar', [SoporteController::class, 'actListar'])->name('incidencia.listar');
    Route::post('incidencia/registrar', [SoporteController::class, 'actRegistrar'])->name('incidencia.registrar');
    Route::post('incidencia/editar', [SoporteController::class, 'actEditar'])->name('incidencia.editar');
    Route::post('incidencia/eliminar', [SoporteController::class, 'actEliminar'])->name('incidencia.eliminar');


    Route::get('usuario', [UsuarioController::class, 'index'])->name('index.usuario');
    Route::post('usuarios/listar', [UsuarioController::class, 'actListar'])->name('listar.usuario');
    Route::post('usuarios/registar', [UsuarioController::class, 'actRegistrar'])->name('registrar.usuario');
    Route::post('usuarios/editar', [UsuarioController::class, 'actEditar'])->name('editar.usuario');
    Route::post('usuarios/eliminar', [UsuarioController::class, 'actEliminar'])->name('eliminar.usuario');
    Route::get('usuarios/{id_usuario}', [UsuarioController::class, 'actVer'])->name('ver.usuario');
    Route::post('usuarios/verPerfil', [UsuarioController::class, 'actPerfil'])->name('verPerfil.usuario');
    // Route::get('usuario/perfil', function () {return view('admin.usuarios_Informatica.perfil');})->name('perfil.usuario');
    Route::get('usuario/perfil', [UsuarioController::class, 'verPerfil'])->name('perfil.usuario');
    Route::post('usuario/GuardarContraseña',[UsuarioController::class, 'actGuardarContraseña'])->name('contra.usuario');

    Route::get('oficina', [OficinaController::class, 'index'])->name('index.oficina');
    Route::post('oficina/listar', [OficinaController::class, 'actListar'])->name('listar.oficina');
    Route::post('oficina/listOficinas', [OficinaController::class, 'actListaOficinas'])->name('select.listaOficinas');
    Route::post('oficina/registar', [OficinaController::class, 'actRegistrar'])->name('registrar.oficina');
    Route::post('oficina/editar', [OficinaController::class, 'actEditar'])->name('editar.oficina');
    Route::post('oficina/eliminar', [OficinaController::class, 'actEliminar'])->name('eliminar.oficina');
    Route::post('oficina/duplicar-oficinas', [OficinaController::class, 'duplicarOficinas'])->name('duplicar.oficinas');

    Route::get('personal', [PersonalController::class, 'index'])->name('index.personal');
    Route::post('personal/listar', [PersonalController::class, 'actListar'])->name('listar.personal');
    Route::post('personal/listarRlaboral', [PersonalController::class, 'actListaRlaboral'])->name('selectPer.listaRlaboral');
    Route::post('personal/listOficinas', [PersonalController::class, 'actListaOficinas'])->name('selectPer.listaOficinas');
    Route::post('personal/registar', [PersonalController::class, 'actRegistrar'])->name('registrar.personal');
    Route::post('personal/editar', [PersonalController::class, 'actEditar'])->name('editar.personal');
    Route::post('personal/eliminar', [PersonalController::class, 'actEliminar'])->name('eliminar.personal');
    Route::get('personal/ver', [PersonalController::class, 'actVer'])->name('ver.personal');
    Route::post('personal/listarAsiganacion', [PersonalController::class, 'actListarAsignacion'])->name('listar.PersonalAsig');

    Route::get('Oficina_personal', [OficinaPeronsalController::class, 'index'])->name('index.ofiPersonal');
    Route::post('Oficina_personal/listar', [OficinaPeronsalController::class, 'actListar'])->name('listar.ofiPersonal');
    Route::post('Oficina_personal/listarPersonal', [OficinaPeronsalController::class, 'actListaPersonal'])->name('selectPer.listaPersonal');
    Route::post('Oficina_personal/asignar', [OficinaPeronsalController::class, 'actAsignar'])->name('asignar.ofiPersonal');
    //Route::post('Oficina_personal/editar', [OficinaPeronsalController::class, 'actEditar'])->name('editar.ofiPersonal');

    Route::get('tickets', [TicketsController::class, 'index'])->name('index.tickets');
    Route::post('tickets/listar', [TicketsController::class, 'actListar'])->name('listar.tickets');
    Route::get('tickets/ver', [TicketsController::class, 'actVer'])->name('ver.tickets');
    

    Route::post('ticketsAsig/listar', [AsignarTicketController::class, 'actListar'])->name('listar.ticketsAsig');
    Route::post('ticketsAsig/registrar', [AsignarTicketController::class, 'actRegistrar'])->name('registrar.ticketsAsig');
    Route::get('ticketsAsig/ver', [AsignarTicketController::class, 'actVer'])->name('ver.ticketsAsig');
    Route::post('ticketsAsig/editar', [AsignarTicketController::class, 'actEditar'])->name('editar.ticketsAsig');
    Route::post('ticketsAsig/final', [AsignarTicketController::class, 'actFinalizacion'])->name('final.ticketsAsig');
    Route::post('ticketsAsig/noResuelto', [AsignarTicketController::class, 'actNoResuelto'])->name('no_resuelto.ticketsAsig');
    Route::post('ticketsAsig/cancelar', [AsignarTicketController::class, 'actCancelar'])->name('cancelar.ticketsAsig');
    Route::get('ticketsAsig/ModalAsignar', [AsignarTicketController::class, 'actVerModal'])->name('modalAsignar.tickets');
    Route::post('ticketsAsig/asignar', [AsignarTicketController::class, 'actAsignar'])->name('asignar.ticketsAsig');

    Route::post('Asignacion/editar2', [AsignarTicketController::class, 'actEditar2'])->name('editar2.ticketsAsig2');
    Route::post('Asignacion/final2', [AsignarTicketController::class, 'actFinalizacion2'])->name('final2.ticketsAsig2');

    Route::get('ticketsAsig', [AsignarTicketController::class, 'index'])->name('index.ticketsAsig');
    Route::post('ticketsAsig/listarGeneral', [AsignarTicketController::class, 'actListarGeneral'])->name('listar.ticketsAsigGeneral');
    Route::get('ticketsAsig/verGeneral', [AsignarTicketController::class, 'actVerGeneral'])->name('ver.ticketsAsigGeneral');

    Route::get('actividades', [BitacoraController::class, 'index'])->name('index.actividades');
    Route::post('actividades/listar', [BitacoraController::class, 'actListar'])->name('listar.actividad');
    Route::post('actividades/registrar', [BitacoraController::class, 'actRegistrar'])->name('registrar.actividad');
    Route::post('actividades/editar', [BitacoraController::class, 'actEditar'])->name('editar.actividad');
    Route::get('actividades/ver', [BitacoraController::class, 'actVer'])->name('ver.actividad');
    Route::post('actividades/eliminar', [BitacoraController::class, 'actEliminar'])->name('eliminar.actividad');
    Route::post('actividades/atender', [BitacoraController::class, 'actAtender'])->name('atender.actividad');
    Route::post('actividades/finalizar', [BitacoraController::class, 'actFinalizar'])->name('finalizar.actividad');

    Route::get('Lista-actividades', [ListaBitacoraController::class, 'index'])->name('index.listActividades');
    Route::post('Lista-actividades/lista', [ListaBitacoraController::class, 'actListar'])->name('listar.listActividades');
    Route::get('Lista-actividades/ver', [ListaBitacoraController::class, 'actVer'])->name('ver.listActividades');
    Route::post('Lista-actividades/filtrar', [ListaBitacoraController::class, 'actFiltrar'])->name('filtrar.listActividades');
    Route::post('Lista-actividades/actividades-usuarios', [ListaBitacoraController::class, 'getActividadesUsuarios'])->name('actividades.usuarios');

    Route::get('actividad', [ActividadController::class, 'index'])->name('actividad.index');
    Route::post('actividad/listar', [ActividadController::class, 'actListar'])->name('actividad.listar');
    Route::post('actividad/registrar', [ActividadController::class, 'actRegistrar'])->name('act.registrar');
    Route::post('actividad/editar', [ActividadController::class, 'actEditar'])->name('act.editar');
    Route::post('actividad/eliminar', [ActividadController::class, 'actEliminar'])->name('act.eliminar');
    Route::post('actividad/listarActividad', [ActividadController::class, 'actListaActividad'])->name('select.listaActividad');

    Route::get('resumen', [ResumenGeneralController::class, 'index'])->name('resumen.index');
    Route::post('resumen/listar', [ResumenGeneralController::class, 'actListar'])->name('listar.resumen');
    Route::post('resumen/filtrar', [ResumenGeneralController::class, 'actFiltrar'])->name('filtrar.resumen');
});



