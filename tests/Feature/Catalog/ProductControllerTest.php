<?php

namespace Tests\Feature\Catalog;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products(): void
    {
        Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '100.00',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->getJson('/api/products');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
            ])
            ->assertJsonFragment([
                'name' => 'Test Product',
            ]);
    }

    public function test_can_show_product(): void
    {
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '100.00',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->getJson(
            "/api/products/{$product->id}"
        );

        $response
            ->assertOk()
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.name', 'Test Product')
            ->assertJsonPath('data.slug', 'test-product');
    }

    public function test_returns_404_when_product_does_not_exist(): void
    {
        $response = $this->getJson('/api/products/999999');

        $response
            ->assertNotFound()
            ->assertJson([
                'message' => 'Product not found.',
            ]);
    }

    public function test_can_create_product(): void
    {
        $payload = [
            'name' => 'New Product',
            'slug' => 'new-product',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '150.00',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ];

        $response = $this->postJson(
            '/api/products',
            $payload
        );

        $response
            ->assertCreated()
            ->assertJsonPath(
                'message',
                'Product created successfully.'
            )
            ->assertJsonPath(
                'data.name',
                'New Product'
            )
            ->assertJsonPath(
                'data.slug',
                'new-product'
            );

        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'slug' => 'new-product',
        ]);
    }

    public function test_can_update_product(): void
    {
        $product = Product::create([
            'name' => 'Old Product',
            'slug' => 'old-product',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '100.00',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        $payload = [
            'name' => 'Updated Product',
            'slug' => 'updated-product',
            'product_type' => 'simple',
            'status' => 'published',
            'price' => '200.00',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ];

        $response = $this->putJson(
            "/api/products/{$product->id}",
            $payload
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'message',
                'Product updated successfully.'
            )
            ->assertJsonPath(
                'data.name',
                'Updated Product'
            )
            ->assertJsonPath(
                'data.slug',
                'updated-product'
            );

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'slug' => 'updated-product',
        ]);
    }

    public function test_returns_404_when_updating_non_existing_product(): void
    {
        $payload = [
            'name' => 'Updated Product',
            'slug' => 'updated-product',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '200.00',
        ];

        $response = $this->putJson(
            '/api/products/999999',
            $payload
        );

        $response->assertNotFound();
    }

    public function test_can_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Product To Delete',
            'slug' => 'product-to-delete',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '100.00',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->deleteJson(
            "/api/products/{$product->id}"
        );

        $response
            ->assertOk()
            ->assertJson([
                'message' => 'Product deleted successfully.',
            ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_returns_404_when_deleting_non_existing_product(): void
    {
        $response = $this->deleteJson(
            '/api/products/999999'
        );

        $response->assertNotFound();
    }

    public function test_can_create_product_variant(): void
    {
        $attribute = Attribute::create([
            'name' => 'Color',
            'slug' => 'color',
            'type' => 'select',
            'is_variant' => true,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $attributeValue = AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => 'Red',
            'slug' => 'red',
            'display_value' => 'Red',
            'color_hex' => '#FF0000',
            'sort_order' => 0,
        ]);

        $product = Product::create([
            'name' => 'Variable Product',
            'slug' => 'variable-product',
            'product_type' => 'variable',
            'status' => 'draft',
            'price' => null,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->postJson(
            "/api/products/{$product->id}/variants",
            [
                'name' => 'Red Variant',
                'price' => '120.00',
                'sku' => 'VAR-001',
                'is_active' => true,
                'sort_order' => 0,
                'attribute_value_ids' => [
                    $attributeValue->id,
                ],
            ]
        );

        $response
            ->assertCreated()
            ->assertJsonPath(
                'message',
                'Product variant created successfully.'
            )
            ->assertJsonPath(
                'data.product_id',
                $product->id
            )
            ->assertJsonPath(
                'data.sku',
                'VAR-001'
            );

        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'sku' => 'VAR-001',
        ]);

        $variantId = $response->json('data.id');

        $this->assertDatabaseHas(
            'product_variant_attribute_value',
            [
                'product_variant_id' => $variantId,
                'attribute_value_id' => $attributeValue->id,
            ]
        );
    }

    public function test_cannot_create_variant_for_simple_product(): void
    {
        $attribute = Attribute::create([
            'name' => 'Color',
            'slug' => 'color',
            'type' => 'select',
            'is_variant' => true,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $attributeValue = AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => 'Red',
            'slug' => 'red',
            'display_value' => 'Red',
            'sort_order' => 0,
        ]);

        $product = Product::create([
            'name' => 'Simple Product',
            'slug' => 'simple-product',
            'product_type' => 'simple',
            'status' => 'draft',
            'price' => '100.00',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->postJson(
            "/api/products/{$product->id}/variants",
            [
                'name' => 'Variant',
                'price' => '120.00',
                'sku' => 'VAR-002',
                'attribute_value_ids' => [
                    $attributeValue->id,
                ],
            ]
        );

        $response->assertStatus(422);
    }
}
