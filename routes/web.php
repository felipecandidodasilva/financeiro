<?php
use Illuminate\Support\Facades\Mail;
use App\Model\Centrodecusto;
use App\Mail\EnviaAvisoDev;
use App\Mail\SendMailUser;
use App\Model\Conta;
use App\Model\Config;
use App\Http\Controllers\DateController;



Auth::routes();

DateController::getDate();

Route::get('/', function () {
    
    
    return redirect('/login');
    //return view('welcome');
});


Route::any('/home', 'HomeController@index')->name('home');
Route::post('/home/filtros', 'HomeController@index')->name('home.filtros');

Route::resource('/centrodecusto', 'CentrodecustoController');

Route::group(['prefix' => 'conta'], function () {
    Route::get('transacao', 'ContaController@transacao')->name('conta.transacao');
    Route::any('transacao/store', 'ContaController@transacaoStore')->name('conta.transacaoStore');
});

Route::resource('/conta', 'ContaController');

//  ENTRADA
Route::resource('/entrada', 'EntradaController');
Route::post('/entrada/periodo', 'EntradaController@periodo')->name('entrada.periodo');
Route::get('/entrada/pagar/{id}', 'EntradaController@pagar')->name('entrada.pagar'); 
Route::get('/entrada/estornar/{id}', 'EntradaController@estornar')->name('entrada.estornar'); 
Route::get('/entrada/rapida', 'EntradaController@rapida')->name('entrada.rapida'); 

//SAIDA 

Route::post('/saida/filtros', 'SaidaController@index')->name('saida.filtros');
Route::post('/saida/periodo', 'SaidaController@periodo')->name('saida.periodo');
Route::get('/saida/rapida', 'SaidaController@rapida')->name('saida.rapida'); 
Route::post('/saida/rapida', 'SaidaController@rapidaStore')->name('saida.rapida.store'); 
Route::get('/saida/pagar/{id}', 'SaidaController@pagar')->name('saida.pagar'); 
Route::get('/saida/estornar/{id}', 'SaidaController@estornar')->name('saida.estornar'); 

Route::resource('/saida', 'SaidaController', ['names' => [
    'index' => 'saida.index',
    'destroy' => 'saida.destroy'
]]);

//TRANSFERENCIA

Route::get('/transferencia', 'TransferenciaController@index')->name('transferencia.index');
Route::post('/transferencia', 'TransferenciaController@store')->name('transferencia.store');

//USUARIOS
Route::resource('user', 'UserController');
Route::get('user/detalhes', 'UserController@detalhes')->name('user.detalhes');
Route::get('user/email/parabens', 'UserController@parabens')->name('user.mail.parabens');
//Route::post('user/delete', 'UserController@destroy')->name('user.deletar');

//CATEGORIAS

Route::resource('categoria', 'CategoriaController');

// RELATÓRIOS

Route::group(['prefix' => 'relatorios'], function () {
    Route::post('/periodo', 'RelatoriosController@trataDatas')->name('relatorios.periodo');
    Route::get('saidas/contas', 'RelatoriosController@saidasPorContas')->name('relatorios.saidas.contas');
    Route::get('saidas/fornecedores', 'RelatoriosController@saidasPorFornecedores')->name('relatorios.saidas.fornecedores');
    Route::get('saidas/categorias', 'RelatoriosController@saidasPorCategorias')->name('relatorios.saidas.categorias');
});

//DEFININDDO A DATA

Route::post('/periodo', 'DateController@setDate')->name('periodo');

Route::get('/mail', function () {
    
    Mail::to('felipe.candido8@gmail.com')->send(new EnviaAvisoDev('Testando o passe de variável'));
    
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
