<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvCategoryController;
use App\Http\Controllers\InvSubCategoryController;
use App\Http\Controllers\ItemManufactureController;
use App\Http\Controllers\InvItemController;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrgUnitController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderInvItemController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\GoodReceiveNoteController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PurchasingItemController;

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
Route::get('/', function () {
    return view('pages.login');
});

Route::get('/home', function () {
    return view('pages.home');
});

//load dashboard for Surveyor
Route::get('/dashboard_surveyor', function () {
    return view('pages.dashboard_surveyor');
});

//load dashboard for Organization Unit
Route::get('/dashboard_org_unit', function () {
    return view('pages.dashboard_organization_unit');
});

//load dashboard for Stores Branch
Route::get('/dashboard_stores_branch', function () {
    return view('pages.dashboard_stores_branch');
});


//load user registration form
Route::resource('user_registration', UserController::class)->only('index');
//get Office Name List in User Registration form
Route::get('get-office-name/{office_type}', [OrgUnitController::class,'getOfficeName']) -> name('UserReg.getOfficeName');
//Save Registered User Details into the database
Route::post('/user_save', [UserController::class, 'store'])->name('UserReg.store');

//
////load Registered user List Form
//Route::get('user_table', [UserController::class,'index'])->name('UserTable.index');

Route::get('/user_registration_certify', function () {
    return view('pages.user_registration_certify');
});


Route::get('/registration',[CustomAuthController::class,'registration']);
Route::post('/register-user',[CustomAuthController::class,'registerUser'])->name('User.registerUser');
Route::post('/login-user',[CustomAuthController::class,'loginUser'])->name('loginUser');
Route::get('/dashboard',[CustomAuthController::class,'dashboard'])->middleware('mustBeLoggedIn');
//Route::post('/logout-user',[CustomAuthController::class,'logout'])->name('logout');
Route::post('/logout',[CustomAuthController::class,"logout"])->middleware('mustBeLoggedIn');


//Save Category data into the database
Route::post('/save_category', [InvItemController::class, 'categoryStore'])->name('CategoryData.categoryStore');
//load category form
Route::resource('form_add_category', InvCategoryController::class)->only('index');
//delete category data
Route::get('/category/{id}/delete', [InvItemController::class, 'delete'])->name('Category.delete');
//edit category dat a
Route::get('/category/{id}/edit', [InvItemController::class, 'edit'])->name('Category.edit');
//update category data
Route::post('/categories/update', [InvItemController::class, 'update'])->name('Category.update');
//category code Auto generate
Route::get('/category-code',[InvItemController::class,'generateCatCode'])->name('Category.generateCatCode');




//save Sub Category data into the database
Route::post('/subcategory_save',[InvItemController::class,'subCategoryStore'])->name('SubCategory.subCategoryStore');
////edit Sub Category data in the database
//Route::get('/subcategory/{id}/edit',[InvItemController::class,'editSubCategory'])->name('SubCategory.edit');
//Fetch data for the selected subCategory for edit
Route::get('/sub_category/{id}/edit',[InvItemController::class,'editSubCategory'])->name('SubCategory.edit');
////Fetch data for the selected subCategory for update
//Route::post('/subcategories/{subcategory_id}',[InvItemController::class,'updateSubCategory'])->name('SubCategory.update');
//Fetch data for the selected subCategory for update
Route::post('/subcategories/update',[InvItemController::class,'updateSubCat'])->name('SubCategory.updateSubCat');
//delete Sub Category data in the database
Route::get('/subcategory/{id}/delete',[InvItemController::class,'delete'])->name('SubCategory.delete');
//view Sub Category data
Route::get('form_add_sub_category',[InvSubCategoryController::class,'index'])->name('SubCategory.index');
//get category code in subcategory form
Route::get('category-code/{category_id}', [InvItemController::class,'getCatCode']) -> name('get-category-code');

//save purchasing items
//Route::post('/saveItems',[PurchasingItemController::class,saveItemDetails]);




//save manufacture
Route::post('/item_manufacture', [ItemManufactureController::class, 'store'])->name('Manufacture.store');
//show manufacture
Route::get('item_manufacture',[ItemManufactureController::class, 'index'])->name('Manufacture.index');
//edit manufacture
Route::get('/item_manufacture/{id}/edit',[ItemManufactureController::class, 'edit'])->name('Manufacture.edit');
//delete manufacture
Route::get('/item_manufacture/{id}/delete',[ItemManufactureController::class, 'delete'])->name('Manufacture.delete');
//update manufacture
Route::post('/item_manufacture/update',[ItemManufactureController::class, 'update'])->name('Manufacture.update');



//show item form
Route::get('form_add_item',[InvItemController::class, 'create'])->name('Item.create');
//save item
Route::post('/item_save', [InvItemController::class, 'itemStore'])->name('Item.itemStore');
//load category and subcategory dynamic dropdown
Route::get('/subcategories/{categoryId}', [InvItemController::class, 'getSubcategories']);
//show item form
Route::get('form_add_item',[InvItemController::class, 'index'])->name('Item.index');
//edit item data
Route::get('/item/{id}/edit', [InvItemController::class, 'itemEdit'])->name('Item.edit');
//update item data
Route::post('/item/update', [InvItemController::class, 'itemUpdate'])->name('Item.update');
//get subCategory list in item form
Route::get('get-category-code/{category_id}', [InvItemController::class,'getCategoryCode']) -> name('Item.getCategoryCode');
//get itemCode list in Purchase Order Item Form
Route::get('/get-subCat-code/{sub_category_id}', [InvItemController::class,'getSubCatCode']) -> name('Item.getSubCatCode');
//get itemCode list in Item form
Route::get('/get-subcategory-code/{sub_category_id}', [InvItemController::class,'getSubCategoryCode']) -> name('Item.getSubCategoryCode');
//delete Item data
Route::get('/form_item/{id}/delete', [InvItemController::class, 'itemDelete'])->name('Item.itemDelete');



//load Registered user form
Route::get('user_table', [UserViewController::class,'index'])->middleware('mustBeLoggedIn');
//load registered user for certify
Route::get('user_registration_certify', [UserController::class,'getUserForCertify'])->middleware('mustBeLoggedIn');
//edit registered user for certify
Route::get('user_registration_certify/{id}', [UserController::class,'edit'])->name('RegUserCertify.edit');
//confirm or reject user
Route::post('user_registration_certify', [UserController::class, 'addRole'])->name('RegUserCertify.addRole');



//show unit form
Route::get('org_unit',[OrgUnitController::class, 'index'])->name('OrgUnit.index');
//save unit
Route::post('/org_unit_save', [OrgUnitController::class, 'store'])->name('OrgUnit.store');
//edit unit data
Route::get('/org_unit/{id}/edit',[OrgUnitController::class,'editOrgUnit'])->name('OrgUnit.edit');
//update Unit data
Route::post('/org_unit/update',[OrgUnitController::class,'updateOrgUnit'])->name('OrgUnit.update');


//view Province
Route::get('org_unit',[OrgUnitController::class,'index'])->name('Province.index');
//get Districts List in Org_Unit form
Route::get('get-province-code/{province_id}', [OrgUnitController::class,'getProvince']) -> name('OrgUnit.getProvince');


//show supplier form
Route::get('form_add_supplier',[SupplierController::class, 'index'])->name('Supplier.index');
//save supplier details
Route::post('/form_add_supplier', [SupplierController::class, 'store']);
//edit supplier details
Route::get('/form_add_supplier/{id}/edit', [SupplierController::class, 'edit'])->name('Supplier.edit');
//update supplier details
Route::post('/form_add_supplier/update', [SupplierController::class, 'update'])->name('Supplier.update');
//delete supplier
Route::get('/form_add_supplier/{id}/delete',[SupplierController::class, 'delete'])->name('Supplier.delete');



//view Purchase form
Route::get('form_add_purchase_order',[PurchaseOrderController::class,'index'])->name('PurchaseOrder.index');
//add Item into Purchase Order Item form
Route::post('/form_add_purchase_order_item/save',[PurchaseOrderInvItemController::class,'addItem'])->name('PurchaseOrderItem.addItem');
//get Purchase Order Item data from the database
Route::get('/form_add_purchase_order/{id}/order-items', [PurchaseOrderController::class, 'getOrderItems'])->name('PurchaseOrder.getOrderItems');
////add Item into Purchase Order form
//Route::post('/form_add_purchase_order',[PurchaseOrderInvItemController::class,'saveTemp'])->name('PurchaseOrderItem.saveTemp');
//// fetching the purchase order
//Route::get('/add-item-to-purchase-order', [PurchaseOrderInvItemController::class,'addItem'])->name('PurchaseOrderItem.addItem');
//save data into Purchase Order Item form and Purchase Order Form
Route::post('/form_add_purchase_order/save',[PurchaseOrderController::class,'store'])->name('PurchaseOrder.store');




//view GRN form
Route::get('form_grn',[GoodReceiveNoteController::class,'index'])-> name('GRN.index');

Route::post('get-purchase-order-items',[GoodReceiveNoteController::class,'addItems'])->name('GRN.addItems');


//view Ledger
Route::get('ledger',[LedgerController::class,'index'])-> name('Ledger.index');


//view Supervisor Assign Form
Route::get('form_assign_supervisor',[RoleController::class,'index'])-> name('Supervisor.index');
//get Unit Name List in Supervisor Assign form
Route::get('get-unit-name/{org_unit_type_id}', [RoleController::class,'getOrgUnit']) -> name('Supervisor.getOrgUnit');



//view Ledger Owner Assign Form
Route::get('form_assign_ledger_owner',[UserController::class,'loadLedgerOwner'])-> name('LedgerOwner.loadLedgerOwner');
//view Ledger Operator Assign Form
Route::get('form_assign_operator',[UserController::class,'loadOperator'])-> name('Operator.loadOperator');


//view Surveyor Confirmation view in Supervisor
Route::get('form_confirm_surveyor',[UserController::class,'loadSurveyors'])-> name('Surveyor.loadSurveyors');

//view Purchasing Item Form
Route::get('form_purchasing_item',[PurchasingItemController::class,'index'])-> name('PurchasingItem.index');
//get Item list in Purchasing item form
Route::get('get-item-code/{subcat_id}', [PurchasingItemController::class,'getItem']) -> name('Item.getItem');
//get Unit list in Purchasing item form
Route::get('get-unit/{pur_unit_type}', [PurchasingItemController::class,'getUnit']) -> name('PurchasingItem.getUnit');
////save data Purchasing Items and redirect to the next page
Route::post('/form_purchasing_item/save',[PurchasingItemController::class,'store'])->name('PurchasingItem.store');


// view add Item Details Form
Route::get('form_add_item_details', [PurchasingItemController::class, 'viewItemDetailsForm'])->name('PurchasingItem.viewItemDetailsForm');
// Purchasing Item Form view
Route::get('form_purchase',[PurchasingItemController::class,'viewPurchaseForm'])->name('PurchasingForm.viewPurchaseForm');
//Change next Button
Route::post('/get-next-button',[PurchasingItemController::class ,'getNextButton'])->name('PurchasingForm.getNextButton');
//Save Purchasing Items
Route::post('/form_add_purchase_order',[PurchasingItemController::class,'store'])->name('PurchasingItem.store');
// save item details model and serial no
Route::post('/saveItemDetails', [PurchasingItemController::class, 'saveItemDetails'])->name('PurchasingItem.saveItemDetails');

//Dropdown controllers
Route::get('/roles', [RoleController::class, 'getRoles']);
