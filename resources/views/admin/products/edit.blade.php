@extends('admin.layouts.admin')

@section('admin-content')

<div class="space-y-6" x-data="productForm()">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Edit: {{ $product->name }}</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        @if($errors->any())
        <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
            <ul class="text-sm text-red-400 space-y-1">
                @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Basic Info</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Short Description</label>
                            <textarea name="short_description" class="input-premium" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Description</label>
                            <textarea name="description" class="input-premium" rows="8">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Specifications</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Material</label>
                            <input type="text" name="material" value="{{ old('material', $product->material) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Steel Type</label>
                            <input type="text" name="steel_type" value="{{ old('steel_type', $product->steel_type) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Construction</label>
                            <input type="text" name="construction" value="{{ old('construction', $product->construction) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Hardness (HRC)</label>
                            <input type="number" name="hardness_hrc" value="{{ old('hardness_hrc', $product->hardness_hrc) }}" class="input-premium" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Overall Length (cm)</label>
                            <input type="number" name="overall_length" value="{{ old('overall_length', $product->overall_length) }}" class="input-premium" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Blade Length (cm)</label>
                            <input type="number" name="blade_length" value="{{ old('blade_length', $product->blade_length) }}" class="input-premium" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Blade Width (cm)</label>
                            <input type="number" name="blade_width" value="{{ old('blade_width', $product->blade_width) }}" class="input-premium" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Blade Thickness (cm)</label>
                            <input type="number" name="blade_thickness" value="{{ old('blade_thickness', $product->blade_thickness) }}" class="input-premium" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Handle Material</label>
                            <input type="text" name="handle_material" value="{{ old('handle_material', $product->handle_material) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Scabbard Material</label>
                            <input type="text" name="scabbard_material" value="{{ old('scabbard_material', $product->scabbard_material) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Weight (g)</label>
                            <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" class="input-premium">
                        </div>
                    </div>
                </div>
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">SEO</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="input-premium" maxlength="255">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Meta Description</label>
                            <textarea name="meta_description" class="input-premium" rows="2" maxlength="500">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Tags (comma separated)</label>
                            <input type="text" name="tags" value="{{ old('tags', $product->tags->pluck('tag')->implode(', ')) }}" class="input-premium">
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Pricing & Stock</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Price (USD) *</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="input-premium" step="0.01" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Compare at Price</label>
                            <input type="number" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}" class="input-premium" step="0.01">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="input-premium" required>
                        </div>
                    </div>
                </div>
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Organization</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Category *</label>
                            <select name="category_id" class="input-premium" required>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Brand</label>
                            <select name="brand_id" class="input-premium">
                                <option value="">None</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red">
                                <span class="text-sm text-yamagata-mist">Featured</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} class="w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red">
                                <span class="text-sm text-yamagata-mist">Bestseller</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }} class="w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red">
                                <span class="text-sm text-yamagata-mist">New Arrival</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red">
                                <span class="text-sm text-yamagata-mist">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Current Images</h2>
                    @if($product->images->count())
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->images as $img)
                        <div class="relative group aspect-square rounded-lg overflow-hidden bg-yamagata-charcoal">
                            <img src="{{ $img->url }}" class="w-full h-full object-cover" alt="">
                            @if($img->is_primary)
                            <span class="absolute top-1 left-1 px-1.5 py-0.5 bg-yamagata-red text-white text-xs rounded font-medium">Primary</span>
                            @endif
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1">
                                @unless($img->is_primary)
                                <button type="button" onclick="setPrimary({{ $img->id }})" class="p-1.5 bg-yamagata-red/80 rounded-full hover:bg-yamagata-red transition-colors" title="Set as primary">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </button>
                                @endunless
                                <button type="button" onclick="deleteImage({{ $img->id }})" class="p-1.5 bg-red-500/80 rounded-full hover:bg-red-500 transition-colors" title="Delete image">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-yamagata-steel text-center py-4">No images uploaded yet.</p>
                    @endif
                </div>

                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Add More Images</h2>
                    <div class="space-y-3">
                        <div
                            class="relative border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200 cursor-pointer"
                            :class="dragOver ? 'border-yamagata-red bg-yamagata-red/5' : 'border-yamagata-graphite hover:border-yamagata-steel'"
                            @dragover.prevent="dragOver = true"
                            @dragleave.prevent="dragOver = false"
                            @drop.prevent="dragOver = false; handleDrop($event)"
                            @click="$refs.fileInput.click()"
                        >
                            <input
                                type="file"
                                name="images[]"
                                multiple
                                accept="image/*"
                                class="hidden"
                                x-ref="fileInput"
                                @change="handleFiles($event.target.files)"
                            >
                            <div class="space-y-2">
                                <svg class="w-8 h-8 mx-auto text-yamagata-steel" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-yamagata-mist">
                                    <span class="text-yamagata-red font-medium">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-yamagata-steel">JPEG, PNG, WebP - Max 5MB each</p>
                            </div>
                        </div>

                        <template x-if="previews.length > 0">
                            <div class="grid grid-cols-3 gap-2">
                                <template x-for="(preview, index) in previews" :key="index">
                                    <div class="relative group aspect-square rounded-lg overflow-hidden bg-yamagata-charcoal">
                                        <img :src="preview.url" class="w-full h-full object-cover" alt="">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button
                                                type="button"
                                                @click.prevent="removePreview(index)"
                                                class="p-1.5 bg-red-500/80 rounded-full hover:bg-red-500 transition-colors"
                                            >
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="absolute bottom-0 left-0 right-0 px-2 py-1 bg-gradient-to-t from-black/80 to-transparent">
                                            <p class="text-xs text-white truncate" x-text="preview.name"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <p class="text-xs text-yamagata-steel" x-show="previews.length > 0" x-text="previews.length + ' new image(s) selected.'"></p>
                    </div>
                </div>

                <div class="admin-card">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="auto_fill" value="1" class="mt-1 w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red">
                        <div>
                            <span class="text-sm font-medium text-yamagata-mist">Auto-Fill Missing Data</span>
                            <p class="text-xs text-yamagata-steel mt-1">Generates SEO content, specifications, and tags from product name. Leaves existing fields unchanged.</p>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full text-center py-3.5">Update Product</button>
            </div>
        </div>
    </form>
</div>

<script>
function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value;
}
function setPrimary(imageId) {
    fetch('{{ route('admin.products.image.primary', '_ID_') }}'.replace('_ID_', imageId), {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json' },
    }).then(() => location.reload());
}
function deleteImage(imageId) {
    if (!confirm('Delete this image?')) return;
    fetch('{{ route('admin.products.image.destroy', '_ID_') }}'.replace('_ID_', imageId), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    }).then(() => location.reload());
}
function productForm() {
    return {
        previews: [],
        dragOver: false,

        handleFiles(files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    this.previews.push({ url, name: file.name });
                }
            }
        },

        handleDrop(event) {
            const files = event.dataTransfer.files;
            this.handleFiles(files);
        },

        removePreview(index) {
            URL.revokeObjectURL(this.previews[index].url);
            this.previews.splice(index, 1);
        }
    }
}
</script>

@endsection
