<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('auth/login', 'auth\Auth::logueo');
$routes->post('auth/register', 'auth\Auth::register');
$routes->get('auth/ini','auth\Auth::x');


$routes->get('users', 'Users::index');


// CATEGORIAS
$routes->get('categorias', 'Categoria::index');
$routes->post('categorias', 'Categoria::store');

// PRODUCTOS
$routes->get('productos', 'Producto::index');
$routes->post('productos', 'Producto::create');
$routes->get('productos/(:num)', 'Producto::ProductosPorId/$1');
$routes->get('productos-categoria/(:num)', 'Producto::getProductosPorCategoria/$1');



// METODO PAGO EMPRESA
$routes->get('metodo-pago-emp', 'MetodoPagoEmpresa::index');
$routes->post('metodo-pago-emp', 'MetodoPagoEmpresa::store');

// METODO ENVIO EMPRESA
$routes->get('metodo-envio-emp', 'MetodoEnvioEmpresa::index');
$routes->post('metodo-envio-emp', 'MetodoEnvioEmpresa::store');

// PEDIDO
$routes->get('pedidos', 'Pedido::index');
$routes->post('pedidos', 'Pedido::store');

// DETALLE PEDIDO
$routes->get('detalle-pedidos', 'DetallePedido::index');
$routes->post('detalle-pedidos', 'DetallePedido::store');

// PERSONA
$routes->get('personas', 'Persona::index');
$routes->get('clientes_persona', 'Persona::clientesPersona');
$routes->get('personas/(:num)', 'Persona::show/$1');
$routes->post('personas', 'Persona::store');


