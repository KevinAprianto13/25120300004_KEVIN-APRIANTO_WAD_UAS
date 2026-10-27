<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GudangKuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('GudangKu');
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@gudangku.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $dashboardResponse = $this->get('/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Total Produk');
        $dashboardResponse->assertSee('Stok Menipis');
    }

    public function test_staff_cannot_access_admin_routes(): void
    {
        $staff = User::where('role', 'staff')->first();

        // Admin exclusive routes must return 403
        $this->actingAs($staff)->get('/categories')->assertStatus(403);
        $this->actingAs($staff)->get('/categories/create')->assertStatus(403);
        $this->actingAs($staff)->get('/users')->assertStatus(403);
        $this->actingAs($staff)->get('/users/create')->assertStatus(403);
        $this->actingAs($staff)->get('/products/create')->assertStatus(403);

        $product = Product::first();
        $this->actingAs($staff)->get("/products/{$product->id}/edit")->assertStatus(403);
    }

    public function test_admin_can_access_all_forms_and_views_without_404(): void
    {
        $admin = User::where('role', 'admin')->first();
        $product = Product::first();
        $category = Category::first();

        // Verify products routes (create, index, show, edit)
        $this->actingAs($admin)->get('/products')->assertStatus(200);
        $this->actingAs($admin)->get('/products/create')->assertStatus(200);
        $this->actingAs($admin)->get("/products/{$product->id}")->assertStatus(200);
        $this->actingAs($admin)->get("/products/{$product->id}/edit")->assertStatus(200);

        // Verify categories routes (index, create, edit, show redirect)
        $this->actingAs($admin)->get('/categories')->assertStatus(200);
        $this->actingAs($admin)->get('/categories/create')->assertStatus(200);
        $this->actingAs($admin)->get("/categories/{$category->id}/edit")->assertStatus(200);

        // Verify transactions routes
        $this->actingAs($admin)->get('/transactions')->assertStatus(200);
        $this->actingAs($admin)->get('/transactions/create')->assertStatus(200);

        // Verify users routes
        $this->actingAs($admin)->get('/users')->assertStatus(200);
        $this->actingAs($admin)->get('/users/create')->assertStatus(200);
        $this->actingAs($admin)->get("/users/{$admin->id}/edit")->assertStatus(200);
    }

    public function test_staff_can_view_catalogue_and_record_transactions(): void
    {
        $staff = User::where('role', 'staff')->first();
        $product = Product::first();

        // Staff can view catalog and detail
        $this->actingAs($staff)->get('/products')->assertStatus(200);
        $this->actingAs($staff)->get("/products/{$product->id}")->assertStatus(200);

        // Staff can access transaction recording and history
        $this->actingAs($staff)->get('/transactions')->assertStatus(200);
        $this->actingAs($staff)->get('/transactions/create')->assertStatus(200);
    }

    public function test_stock_out_is_rejected_when_quantity_exceeds_available_stock(): void
    {
        $staff = User::where('role', 'staff')->first();
        $product = Product::where('stock', '>', 0)->first();

        $excessiveQuantity = $product->stock + 100;

        $response = $this->actingAs($staff)->post('/transactions', [
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => $excessiveQuantity,
            'transaction_date' => now()->toDateString(),
            'note' => 'Permintaan stok berlebih',
        ]);

        $response->assertSessionHasErrors('quantity');

        // Verify product stock did not change
        $product->refresh();
        $this->assertNotEquals($product->stock, $product->stock - $excessiveQuantity);
    }

    public function test_stock_in_increases_product_stock(): void
    {
        $staff = User::where('role', 'staff')->first();
        $product = Product::first();
        $initialStock = $product->stock;
        $addQuantity = 15;

        $response = $this->actingAs($staff)->post('/transactions', [
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $addQuantity,
            'transaction_date' => now()->toDateString(),
            'note' => 'Restock barang',
        ]);

        $response->assertRedirect('/transactions');
        $product->refresh();
        $this->assertEquals($initialStock + $addQuantity, $product->stock);
    }

    public function test_cannot_delete_category_with_existing_products(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categoryWithProducts = Category::has('products')->first();

        $response = $this->actingAs($admin)->delete("/categories/{$categoryWithProducts->id}");
        $response->assertRedirect('/categories');
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $categoryWithProducts->id]);
    }
}
