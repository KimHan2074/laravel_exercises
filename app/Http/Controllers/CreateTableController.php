<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateTableController extends Controller
{
    public function create_Table()
    {
        if(!Schema::hasTable('addresses')){
            Schema::create('addresses', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT

                $table->string('street', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('country', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->integer('icon_id')->nullable();
                $table->integer('monster_id') -> nullable(false);
                $table->unique('monster_id', 'addresses_monster_id_unique');
            });
        }

        if(!Schema::hasTable('articles')){
            Schema::create('articles', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT

                $table->unsignedInteger('category_id')->nullable(false); 
                $table->string('title', 255)->collation('utf8_unicode_ci')->nullable(false); 
                $table->string('slug', 255)->collation('utf8_unicode_ci')->default(''); 
                $table->text('content')->collation('utf8_unicode_ci')->nullable(false);  
                $table->string('image', 255)->collation('utf8_unicode_ci')->nullable(); 
                $table->enum('status', ['PUBLISHED', 'DRAFT'])->collation('utf8_unicode_ci')->default('PUBLISHED');
                $table->date('date')->nullable(false); 
                $table->boolean('featured')->default(0); /*Laravel mặc định là not null nếu k có nullable*/
                $table->timestamp('created_at')->nullable(); 
                $table->timestamp('updated_at')->nullable(); 
                $table->timestamp('deleted_at')->nullable(); 
            });

            // Thiết lập giá trị AUTO_INCREMENT cho id = 1032
            DB::statement('ALTER TABLE articles AUTO_INCREMENT = 1032');
        }

        if(!Schema::hasTable('article_tag')){
            Schema::create('article_tag', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT

                $table->unsignedInteger('article_id')->nullable(false); 
                $table->unsignedInteger('tag_id')->nullable(false); 
                $table->timestamp('created_at')->nullable(); 
                $table->timestamp('updated_at')->nullable(); 
                $table->timestamp('deleted_at')->nullable(); 
            });
        }

        if(!Schema::hasTable('b_s')){
            Schema::create('b_s', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT

                $table->string('data', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            });
        }

        if(!Schema::hasTable('a_s')){
            Schema::create('a_s', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT 

                $table->unsignedInteger('b_s_id')->nullable(false); 

                // Thêm khóa ngoại
                $table->foreign('b_s_id', 'a_s_b_s_id_foreign')
                      ->references('id')->on('b_s')
                      ->onDelete('CASCADE')
                      ->onUpdate('CASCADE');
            });
        }

        if(!Schema::hasTable('bills')){
            Schema::create('bills', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT

                $table->integer('id_customer')->nullable(); 
                $table->date('date_order')->nullable();
                $table->float('total')->nullable()->comment('tổng tiền');
                $table->string('payment', 200)->charset('utf8')->collation('utf8_unicode_ci')->nullable()->comment('hình thức thanh toán');
                $table->string('note', 500)->charset('utf8')->collation('utf8_unicode_ci')->nullable();
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

                // Thêm Index (KEY) cho id_customer
                $table->index('id_customer', 'bills_ibfk_1');
            });

            // Thiết lập giá trị AUTO_INCREMENT cho id = 60
            DB::statement('ALTER TABLE bills AUTO_INCREMENT = 60');
        }

        if(!Schema::hasTable('bill_detail')){
            Schema::create('bill_detail', function($table){

                $table->increments('id'); // PRIMARY KEY + AUTO_INCREMENT

                $table->integer('id_bill')->nullable(false);
                $table->integer('id_product')->nullable(false);
                $table->integer('quantity')->nullable(false)->comment('số lượng');
                $table->double('unit_price')->nullable(false);
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                // Thêm Index (KEY) cho id_product
                $table->index('id_product', 'bill_detail_ibfk_2');
            });

            // Thiết lập giá trị AUTO_INCREMENT cho id = 64
            DB::statement('ALTER TABLE bill_detail AUTO_INCREMENT = 64');
        }

        if(!Schema::hasTable('categories')){
            Schema::create('categories', function($table){

                $table->increments('id');

                $table->integer('parent_id')->default(0);
                $table->unsignedInteger('lft')->nullable();
                $table->unsignedInteger('rgt')->nullable();
                $table->unsignedInteger('depth')->nullable();
                $table->string('name', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('slug', 255)->collation('utf8_unicode_ci')->nullable(false)->unique('categories_slug_unique');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if(!Schema::hasTable('comments')){
            Schema::create('comments', function($table){

               $table->increments('id');

                $table->string('username', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
                $table->text('comment')->collation('utf8mb4_unicode_ci')->nullable(false);
                $table->unsignedInteger('id_product')->nullable(false);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();

                 // Thêm khóa ngoại
                $table->foreign('id_product')
                        ->references('id')
                        ->on('products')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            });

             // Thiết lập giá trị AUTO_INCREMENT cho id = 2
             DB::statement('ALTER TABLE comments AUTO_INCREMENT = 2');
        }

        if(!Schema::hasTable('customer')){
            Schema::create('customer', function($table){

                $table->increments('id');

                $table->string('name', 100)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('gender', 10)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('email', 50)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('address', 100)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('phone_number', 20)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('note', 200)->collation('utf8_unicode_ci')->nullable(false);
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable(false);
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            });

             // Thiết lập giá trị AUTO_INCREMENT cho id = 68
             DB::statement('ALTER TABLE customer AUTO_INCREMENT = 68');
        }

        if(!Schema::hasTable('dummies')){
            Schema::create('dummies', function($table){

                $table->increments('id');

                $table->string('name', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->text('description')->collation('utf8_unicode_ci')->nullable(false);
                $table->longText('extras')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable(false);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });

            DB::statement('ALTER TABLE dummies ADD CONSTRAINT chk_extras_json CHECK (JSON_VALID(extras))');
        }

        if(!Schema::hasTable('failed_jobs')){
            Schema::create('failed_jobs', function($table){

                $table->unsignedBigInteger('id')->autoIncrement();

                $table->text('connection')->collation('utf8_unicode_ci')->nullable(false);
                $table->text('queue')->collation('utf8_unicode_ci')->nullable(false);
                $table->longText('payload')->collation('utf8_unicode_ci')->nullable(false);
                $table->longText('exception')->collation('utf8_unicode_ci')->nullable(false);
                $table->timestamp('failed_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });
            // Thiết lập AUTO_INCREMENT cho id
            DB::statement('ALTER TABLE failed_jobs MODIFY id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
        }

        if(!Schema::hasTable('icons')){
            Schema::create('icons', function($table){

                $table->increments('id');

                $table->string('name', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('icon', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 5
            DB::statement('ALTER TABLE icons AUTO_INCREMENT = 5');
        }

        if(!Schema::hasTable('menu_items')){
            Schema::create('menu_items', function($table){

                $table->increments('id');

                $table->string('name', 100)->collation('utf8_unicode_ci')->nullable(false);
                $table->string('type', 20)->collation('utf8_unicode_ci')->nullable();
                $table->string('link', 255)->collation('utf8_unicode_ci')->nullable();
                $table->unsignedInteger('page_id')->nullable();
                $table->unsignedInteger('parent_id')->nullable();
                $table->unsignedInteger('lft')->nullable();
                $table->unsignedInteger('rgt')->nullable();
                $table->unsignedInteger('depth')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 8
            DB::statement('ALTER TABLE menu_items AUTO_INCREMENT = 8');
        }

        if(!Schema::hasTable('migrations')){
            Schema::create('migrations', function($table){

                $table->increments('id'); 

                $table->string('migration', 191)->collation('utf8mb4_unicode_ci')->nullable(false);
                $table->integer('batch')->nullable(false);
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 48
            DB::statement('ALTER TABLE migrations AUTO_INCREMENT = 48');
        }

        if(!Schema::hasTable('model_has_permissions')){
            Schema::create('model_has_permissions', function($table){
                $table->unsignedInteger('permission_id')->nullable(false);
                $table->string('model_type', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->unsignedBigInteger('model_id')->nullable(false);

                // Thêm PRIMARY KEY cho ba cột
                $table->primary(['permission_id', 'model_id', 'model_type']);

                // Thêm khóa ngoại
                $table->foreign('permission_id')
                        ->references('id')
                        ->on('permissions')
                        ->onDelete('cascade');
            });
        }

        if(!Schema::hasTable('model_has_roles')){
            Schema::create('model_has_roles', function($table){
                $table->unsignedInteger('role_id')->nullable(false);
                $table->string('model_type', 255)->collation('utf8_unicode_ci')->nullable(false);
                $table->unsignedBigInteger('model_id')->nullable(false);

                // Thêm PRIMARY KEY cho ba cột
                $table->primary(['role_id', 'model_id', 'model_type']);

                // Thêm khóa ngoại
                $table->foreign('role_id')
                        ->references('id')
                        ->on('roles')
                        ->onDelete('cascade');
            });
        }

        if(!Schema::hasTable('monsters')){
            Schema::create('monsters', function($table){

                $table->increments('id');

                $table->string('address', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('browse', 255)->collation('utf8_unicode_ci')->nullable();
                $table->tinyInteger('checkbox')->nullable();
                $table->text('wysiwyg')->collation('utf8_unicode_ci')->nullable();
                $table->string('color', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('color_picker', 255)->collation('utf8_unicode_ci')->nullable();
                $table->date('date')->nullable();
                $table->date('date_picker')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->dateTime('datetime')->nullable();
                $table->dateTime('datetime_picker')->nullable();
                $table->string('email', 255)->collation('utf8_unicode_ci')->nullable();
                $table->integer('hidden')->nullable();
                $table->string('icon_picker', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('image', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('month', 255)->collation('utf8_unicode_ci')->nullable();
                $table->integer('number')->nullable();
                $table->double('float', 8, 2)->nullable();
                $table->string('password', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('radio', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('range', 255)->collation('utf8_unicode_ci')->nullable();
                $table->integer('select')->nullable();
                $table->string('select_from_array', 255)->collation('utf8_unicode_ci')->nullable();
                $table->integer('select2')->nullable();
                $table->string('select2_from_ajax', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('select2_from_array', 255)->collation('utf8_unicode_ci')->nullable();
                $table->text('simplemde')->collation('utf8_unicode_ci')->nullable();
                $table->text('summernote')->collation('utf8_unicode_ci')->nullable();
                $table->text('table')->collation('utf8_unicode_ci')->nullable();
                $table->text('textarea')->collation('utf8_unicode_ci')->nullable();
                $table->string('text', 255)->collation('utf8_unicode_ci');
                $table->text('tinymce')->collation('utf8_unicode_ci')->nullable();
                $table->string('upload', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('upload_multiple', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('url', 255)->collation('utf8_unicode_ci')->nullable();
                $table->text('video')->collation('utf8_unicode_ci')->nullable();
                $table->string('week', 255)->collation('utf8_unicode_ci')->nullable();
                $table->text('extras')->collation('utf8_unicode_ci')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->longText('base64_image')->nullable(); // Lưu chuỗi Base64
            });
        }

        if(!Schema::hasTable('monster_article')){
            Schema::create('monster_article', function($table){

                $table->increments('id');

                $table->unsignedInteger('monster_id');
                $table->unsignedInteger('article_id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if(!Schema::hasTable('monster_category')){
            Schema::create('monster_category', function($table){

                $table->increments('id');

                $table->unsignedInteger('monster_id');
                $table->unsignedInteger('category_id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if(!Schema::hasTable('monster_tag')){
            Schema::create('monster_tag', function($table){

                $table->increments('id');

                $table->unsignedInteger('monster_id');
                $table->unsignedInteger('tag_id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if(!Schema::hasTable('news')){
            Schema::create('news', function($table){

                $table->increments('id');

                $table->string('title', 200)->charset('utf8')->collation('utf8_unicode_ci')->comment('tiêu đề');
                $table->text('content')->charset('utf8')->collation('utf8_unicode_ci')->comment('nội dung');
                $table->string('image', 100)->charset('utf8')->collation('utf8_unicode_ci')->comment('hình');
                $table->timestamp('create_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }

        if(!Schema::hasTable('pages')){
            Schema::create('pages', function($table){

                $table->increments('id');

                $table->string('template', 255)->collation('utf8_unicode_ci');
                $table->string('name', 255)->collation('utf8_unicode_ci');
                $table->string('title', 255)->collation('utf8_unicode_ci');
                $table->string('slug', 255)->collation('utf8_unicode_ci');
                $table->text('content')->collation('utf8_unicode_ci')->nullable();
                $table->text('extras')->collation('utf8_unicode_ci')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 17
            DB::statement('ALTER TABLE pages AUTO_INCREMENT = 17');
        }

        if(!Schema::hasTable('password_resets')){
            Schema::create('password_resets', function($table){
                $table->string('email', 255)->collation('utf8_unicode_ci')->notNull();
                $table->string('token', 255)->collation('utf8_unicode_ci')->notNull();
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                // Thêm INDEX cho email và token
                $table->index('email', 'password_resets_email_index');
                $table->index('token', 'password_resets_token_index');
            });
        }

        if(!Schema::hasTable('permissions')){
            Schema::create('permissions', function($table){

                $table->increments('id');

                $table->string('name', 255)->collation('utf8_unicode_ci');
                $table->string('guard_name', 255)->collation('utf8_unicode_ci');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });

            // Thiết lập giá trị AUTO_INCREMENT cho id = 10
            DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 10');
            
        }

        if(!Schema::hasTable('postalboxes')){
            Schema::create('postalboxes', function($table){

                $table->increments('id');

                $table->string('postal_name', 255)->collation('utf8_unicode_ci')->nullable();
                $table->integer('monster_id')->collation('utf8_unicode_ci');
            });
        }

        if(!Schema::hasTable('products')){
            Schema::create('products', function($table){

                $table->increments('id');

                $table->string('name', 100)->collation('utf8_unicode_ci')->nullable();
                $table->integer('id_type')->unsigned()->nullable();
                $table->text('description')->collation('utf8_unicode_ci')->nullable();
                $table->float('unit_price')->nullable();
                $table->float('promotion_price')->nullable();
                $table->string('image', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('unit', 255)->collation('utf8_unicode_ci')->nullable();
                $table->tinyInteger('new')->default(0);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();

                // Thêm khóa ngoại
                $table->foreign('id_type')
                    ->references('id')
                    ->on('type_products')
                    ->onDelete('cascade');
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 87
            DB::statement('ALTER TABLE products AUTO_INCREMENT = 87');
        }

        if(!Schema::hasTable('revisions')){
            Schema::create('revisions', function($table){

                $table->increments('id');

                $table->string('revisionable_type', 255)->collation('utf8_unicode_ci');
                $table->integer('revisionable_id');
                $table->integer('user_id')->nullable();
                $table->string('key', 255)->collation('utf8_unicode_ci');
                $table->text('old_value')->collation('utf8_unicode_ci')->nullable();
                $table->text('new_value')->collation('utf8_unicode_ci')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();

                // Thêm INDEX cho revisionable_id và revisionable_type
                $table->index(['revisionable_id', 'revisionable_type'], 'revisions_revisionable_id_revisionable_type_index');
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 10
            DB::statement('ALTER TABLE revisions AUTO_INCREMENT = 10');
        }

        if(!Schema::hasTable('roles')){
            Schema::create('roles', function($table){

                $table->increments('id');

                $table->string('name', 255)->collation('utf8_unicode_ci');
                $table->string('guard_name', 255)->collation('utf8_unicode_ci');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 4
            DB::statement('ALTER TABLE roles AUTO_INCREMENT = 4');
        }

        if(!Schema::hasTable('role_has_permissions')){
            Schema::create('role_has_permissions', function($table){
                $table->unsignedInteger('role_id');
                $table->unsignedInteger('permission_id');


                // Thêm PRIMARY KEY
                $table->primary(['permission_id', 'role_id']);

                // Thêm khóa ngoại
                $table->foreign('permission_id')
                        ->references('id')
                        ->on('permissions')
                        ->onDelete('cascade');

                $table->foreign('role_id')
                        ->references('id')
                        ->on('roles')
                        ->onDelete('cascade');
            });
        }

        if(!Schema::hasTable('settings')){
            Schema::create('settings', function($table){

                $table->increments('id');

                $table->string('key', 255)->collation('utf8_unicode_ci');
                $table->string('name', 255)->collation('utf8_unicode_ci');
                $table->string('description', 255)->collation('utf8_unicode_ci')->nullable();
                $table->string('value', 255)->collation('utf8_unicode_ci')->nullable();
                $table->text('field')->collation('utf8_unicode_ci');
                $table->tinyInteger('active');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 5
            DB::statement('ALTER TABLE settings AUTO_INCREMENT = 5');
        }

        if(!Schema::hasTable('slide')){
            Schema::create('slide', function($table){

                $table->increments('id');

                $table->string('link', 100);
                $table->string('image', 100);
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 5
            DB::statement('ALTER TABLE slide AUTO_INCREMENT = 5');
        }

        if(!Schema::hasTable('tags')){
            Schema::create('tags', function($table){

                $table->increments('id');

                $table->string('name', 255)->collation('utf8_unicode_ci');
                $table->string('slug', 255)->collation('utf8_unicode_ci');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();

                 // Thêm UNIQUE KEY cho slug
                 $table->unique('slug', 'tags_slug_unique');
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 22
            DB::statement('ALTER TABLE tags AUTO_INCREMENT = 22');
        }

        if(!Schema::hasTable('type_products')){
            Schema::create('type_products', function($table){

                $table->increments('id');

                $table->string('name', 100)->collation('utf8_unicode_ci')->notNull();
                $table->text('description')->collation('utf8_unicode_ci')->notNull();
                $table->string('image', 255)->collation('utf8_unicode_ci')->notNull();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 8
            DB::statement('ALTER TABLE type_products AUTO_INCREMENT = 8');
        }

        if(!Schema::hasTable('users')){
            Schema::create('users', function($table){

                $table->increments('id');

                $table->string('name', 255)->collation('utf8_unicode_ci')->notNull();
                $table->string('email', 255)->collation('utf8_unicode_ci')->notNull();
                $table->string('password', 255)->collation('utf8_unicode_ci')->notNull();
                $table->string('remember_token', 100)->collation('utf8_unicode_ci')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();

                // Thêm UNIQUE KEY cho email
                $table->unique('email', 'users_email_unique');
            });
            // Thiết lập giá trị AUTO_INCREMENT cho id = 135
            DB::statement('ALTER TABLE users AUTO_INCREMENT = 135');
        }

        if(!Schema::hasTable('wishlists')){
            Schema::create('wishlists', function($table){

                $table->increments('id');
                $table->unsignedBigInteger('id_user');
                $table->unsignedBigInteger('id_product');
                $table->integer('quantity')->default(1);
                $table->timestamps();

                // Thêm index
                $table->index('id_user');
                $table->index('id_product');

                // Thêm khóa ngoại
                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            });
             // Thiết lập giá trị AUTO_INCREMENT cho id = 9
             DB::statement('ALTER TABLE wishlists AUTO_INCREMENT = 9');
        }
        return "Đã tạo tất cả các bảng!";
    }
}