<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\CoworkerController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\InstallmentController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarrantyController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;


/////////////////////////User///////////////////////////
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/legal', [UserController::class, 'legalUsers'])->name('users.legal');
    Route::get('/bank_lists', [UserController::class, 'bankLists'])->name('users.bankLists');
    Route::get('/experts', [UserController::class, 'experts'])->name('users.experts');
    Route::get('/export', [UserController::class, 'export'])->name('users.export');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'delete'])->name('users.destroy');
    Route::get('/invoices/{user}', [UserController::class, 'invoices'])->name('users.invoices');
    Route::get('/transactions/{user}', [UserController::class, 'transactions'])->name('users.transactions');
    Route::get('/installments/{user}', [UserController::class, 'installments'])->name('users.installments');
    Route::get('/bank_accounts/{user}', [UserController::class, 'bankAccounts'])->name('users.bankAccounts');
    Route::get('/investment_report/{user}', [UserController::class, 'investmentReport'])->name('users.investmentReport');
    Route::get('/list/all/', [UserController::class, 'usersList'])->name('users.list');
});


/////////////////////////Article///////////////////////////
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::post('/store', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/{article}', [ArticleController::class, 'delete'])->name('articles.destroy');
    Route::get('article/list', [ArticleController::class, 'articleList'])->name('articles.articleList');

});


/////////////////////////Slider///////////////////////////
Route::prefix('sliders')->group(function () {
    Route::get('/', [SliderController::class, 'index'])->name('sliders.index');
    Route::post('/store', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/{slider}', [SliderController::class, 'show'])->name('sliders.show');
    Route::put('/{slider}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('/{slider}', [SliderController::class, 'delete'])->name('sliders.destroy');
});


/////////////////////////Ticket///////////////////////////
Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/answer/{ticket}', [TicketController::class, 'answer'])->name('tickets.answer');
    Route::put('/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/{ticket}', [TicketController::class, 'delete'])->name('tickets.destroy');
});


/////////////////////////Coworker///////////////////////////
Route::prefix('coworkers')->group(function () {
    Route::get('/', [CoworkerController::class, 'index'])->name('coworkers.index');
    Route::get('/{coworker}', [CoworkerController::class, 'show'])->name('coworkers.show');
    Route::post('/store', [CoworkerController::class, 'store'])->name('coworkers.store');
    Route::put('/{coworker}', [CoworkerController::class, 'update'])->name('coworkers.update');
    Route::delete('/{coworker}', [CoworkerController::class, 'delete'])->name('coworkers.destroy');
});



/////////////////////////Project///////////////////////////
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projectStatusLogs/{project}', [ProjectController::class, 'projectStatusLogs'])->name('projects.projectStatusLogs');
    Route::get('/experts/{project}', [ProjectController::class, 'experts'])->name('projects.experts.index');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/store/specifications', [ProjectController::class, 'storeSpecifications'])->name('projects.storeSpecifications');
    Route::put('/project_information/{project}', [ProjectController::class, 'updateProjectInformation'])->name('projects.projectInformation');
    Route::put('/financial_information/{project}', [ProjectController::class, 'updateFinancialInformation'])->name('projects.financialInformation');
    Route::put('/status/{project}', [ProjectController::class, 'updateStatus'])->name('projects.status');
    Route::put('/farabourseCode/{project}', [ProjectController::class, 'updateFarabourseCode'])->name('projects.farabourseCode');
    Route::delete('/{project}', [ProjectController::class, 'delete'])->name('projects.destroy');
    Route::put('/addExpert/{project}', [ProjectController::class, 'addExpert'])->name('projects.addExpert');
    Route::delete('/deleteExpert/{projectUserExpert}', [ProjectController::class, 'deleteExpert'])->name('projects.deleteExpert');
    Route::put('/getFarabourseProject/{project}', [ProjectController::class, 'getFarabourseProject'])->name('projects.getFarabourseProject');
    Route::get('/farabourse/{project}', [ProjectController::class, 'farabourse'])->name('projects.farabourse.show');
    Route::get('/files/{project}/', [ProjectController::class, 'files'])->name('projects.files');
    Route::get('/financeFiles/{project}/', [ProjectController::class, 'financeFiles'])->name('projects.financeFiles');
    Route::get('/investors/{project}', [ProjectController::class, 'projectInvestors'])->name('projects.investors');
    Route::put('/generate/participation/{project}', [ProjectController::class, 'participation'])->name('projects.participation');
    Route::get('/list/all', [ProjectController::class, 'projectsList'])->name('projects.list');

});


/////////////////////////Contract///////////////////////////
Route::prefix('contracts')->group(function () {
    Route::get('/', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    Route::post('/store', [ContractController::class, 'store'])->name('contracts.store');
    Route::put('/{contract}', [ContractController::class, 'update'])->name('contracts.update');
    Route::delete('/{contract}', [ContractController::class, 'delete'])->name('contracts.destroy');
    Route::get('list/types', [ContractController::class, 'contractsTypes'])->name('contracts.contractsTypes');
    Route::get('list/document-types', [ContractController::class, 'contractsDocumentTypes'])->name('contracts.contractsDocumentTypes');
});



/////////////////////////Comment///////////////////////////
Route::prefix('comments')->group(function () {
    Route::get('/projectComments', [CommentController::class, 'projectComments'])->name('comments.projects');
    Route::get('/articleComments', [CommentController::class, 'articleComments'])->name('comments.articles');
    Route::get('/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::put('/answerComment/{comment}', [CommentController::class, 'answerComment'])->name('comments.answerComment');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/{comment}', [CommentController::class, 'delete'])->name('comments.destroy');
});



/////////////////////////Invoice///////////////////////////
Route::prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/export', [InvoiceController::class, 'exportInvoice'])->name('invoices.export');
    Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/participationReport/{invoice}', [InvoiceController::class, 'getParticipationReport'])->name('invoices.participationReport');
    Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/{invoice}', [InvoiceController::class, 'delete'])->name('invoices.destroy');
});


/////////////////////////Transaction///////////////////////////
Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});


/////////////////////////Installments///////////////////////////
Route::prefix('installments')->group(function () {
    Route::get('/', [InstallmentController::class, 'index'])->name('installments.index');
    Route::get('/{installment}', [InstallmentController::class, 'show'])->name('installments.show');
    Route::put('/submitInstallments/{project}', [InstallmentController::class, 'submitInstallments'])->name('installments.submitInstallments');
    Route::put('/payInstallment/{project}', [InstallmentController::class, 'payInstallments'])->name('installments.payInstallments');
    Route::get('/projectDueDates/{project}', [InstallmentController::class, 'projectDueDates'])->name('installments.projectDueDates');

});


/////////////////////////Files///////////////////////////
Route::prefix('files')->group(function () {
    Route::post('/store', [FileController::class, 'store'])->name('files.store');
    Route::post('/replace', [FileController::class, 'replace'])->name('files.replace');
    Route::delete('/delete/{media}', [FileController::class, 'delete'])->name('files.delete');
    Route::get('/download/{media}', [FileController::class, 'downloadFile'])->name('files.downloadFile');
});


/////////////////////////Status///////////////////////////
Route::prefix('statuses')->group(function () {
    Route::get('/user', [StatusController::class, 'userStatuses'])->name('statuses.user');
    Route::get('/ticket', [StatusController::class, 'ticketStatuses'])->name('statuses.ticket');
    Route::get('/project', [StatusController::class, 'projectStatuses'])->name('statuses.project');
    Route::get('/transaction', [StatusController::class, 'transactionStatuses'])->name('statuses.transaction');
    Route::get('/installment', [StatusController::class, 'installmentStatuses'])->name('statuses.installment');
});


/////////////////////////State///////////////////////////
Route::prefix('states')->group(function () {
    Route::get('/', [StateController::class, 'index'])->name('states.index')->name('states.index');
});

/////////////////////////City///////////////////////////
Route::prefix('cities')->group(function () {
    Route::get('/state/{state}',[CityController::class,'getCitiesByState'])->name('cities.states');
});

/////////////////////////Warranty///////////////////////////
Route::prefix('warranties')->group(function () {
    Route::get('/', [WarrantyController::class, 'index'])->name('warranties.index');
});



/////////////////////////Team///////////////////////////
Route::prefix('teams')->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::post('/store', [TeamController::class, 'store'])->name('teams.store');
    Route::put('/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/{team}', [TeamController::class, 'delete'])->name('teams.destroy');
});
