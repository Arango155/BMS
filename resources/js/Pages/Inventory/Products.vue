<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const view = ref('list');
const products = ref([]);
const form = ref({
    id: null,
    code: '',
    sku: '',
    name: '',
    stock: '',
    min_stock: '',
    presentation: '',
    purchase_price: '',
    sale_price: '',
    wholesale_price: '',
    discount: '',
    brand: '',
    model: '',
    expires: 'No',
    expiration_date: '',
    factory_warranty: 'No',
    warranty_unit: '',
    warranty_time: '',
});

// ✅ Load Products
const loadProducts = async () => {
    try {
        const response = await axios.get('/products/list');
        products.value = response.data;
    } catch (error) {
        toast.error('❌ Error loading products.');
    }
};



// ✅ Reset Form
const resetForm = () => {
    form.value = {
        id: null,
        code: '',
        sku: '',
        name: '',
        stock: '',
        min_stock: '',
        presentation: '',
        purchase_price: '',
        sale_price: '',
        wholesale_price: '',
        discount: '',
        brand: '',
        model: '',
        expires: 'No',
        expiration_date: '',
        factory_warranty: 'No',
        warranty_unit: '',
        warranty_time: '',
    };
};
const saveProduct = async () => {
    if (!form.value.code || !form.value.name || !form.value.stock || !form.value.min_stock || !form.value.sale_price) {
        toast.error('❌ Code, name, stock, min stock, and sale price are required.');
        return;
    }

    try {
        const productData = {
            code: form.value.code,
            name: form.value.name,
            stock: parseInt(form.value.stock),
            min_stock: parseInt(form.value.min_stock),
            sale_price: parseFloat(form.value.sale_price),
        };

        console.log("Sending Product Data:", productData); // 🔍 Verifica en la consola

        await axios.post('/inventory-products/store', productData, {
            headers: { 'Content-Type': 'application/json' }
        });

        toast.success('✅ Product added successfully.');
        loadProducts();
        view.value = 'list';
        resetForm();
    } catch (error) {
        console.error("❌ Error saving product:", error.response?.data);
        toast.error('❌ Error saving product.');
    }
};


onMounted(loadProducts);


</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-white">📦 Product Management</h2>

        <!-- 🟢 NAVIGATION BUTTONS -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="view = 'list'" class="px-5 py-3 rounded-lg shadow-md" :class="view === 'list' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                📋 Product List
            </button>
            <button @click="view = 'new'" class="px-5 py-3 rounded-lg shadow-md" :class="view === 'new' ? 'bg-green-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                ➕ New Product
            </button>
            <button @click="view = 'warehouse'" class="px-5 py-3 rounded-lg shadow-md">🏢 In Warehouse</button>
            <button @click="view = 'bestsellers'" class="px-5 py-3 rounded-lg shadow-md">🔥 Best Sellers</button>
            <button @click="view = 'by_category'" class="px-5 py-3 rounded-lg shadow-md">📂 By Category</button>

        </div>


        <!-- 🏢 IN WAREHOUSE (PRODUCTS IN STOCK) -->
        <div v-if="view === 'warehouse'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">🏢 Products In Warehouse</h3>

            <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5">📌 Code</th>
                    <th class="py-3 px-5">🔢 SKU</th>
                    <th class="py-3 px-5">📦 Name</th>
                    <th class="py-3 px-5">📊 Stock</th>
                    <th class="py-3 px-5">⚠️ Min Stock</th>
                    <th class="py-3 px-5">📍 Status</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in warehouseProducts" :key="product.id">
                    <td class="py-3 px-5">{{ product.code }}</td>
                    <td class="py-3 px-5">{{ product.sku }}</td>
                    <td class="py-3 px-5">{{ product.name }}</td>
                    <td class="py-3 px-5">{{ product.stock }}</td>
                    <td class="py-3 px-5">{{ product.min_stock }}</td>
                    <td class="py-3 px-5">
                    <span :class="product.status === 'Enabled' ? 'bg-green-500' : 'bg-red-500'" class="text-white px-3 py-1 rounded-lg text-sm">
                        {{ product.status }}
                    </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- 🟢 NEW PRODUCT FORM -->
        <div v-if="view === 'new'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">➕ New Product</h3>

            <form @submit.prevent="saveProduct" class="space-y-4">
                <!-- 📌 Basic Information -->
                <h4 class="font-semibold text-gray-800 dark:text-white">📌 Product Information</h4>
                <input v-model="form.name" type="text" placeholder="📦 Product Name" class="w-full p-3 border rounded-md">
                <input v-model="form.stock" type="number" placeholder="📦 Stock" class="w-full p-3 border rounded-md">
                <input v-model="form.min_stock" type="number" placeholder="⚠️ Minimum Stock" class="w-full p-3 border rounded-md">

                <!-- Presentation -->
                <select v-model="form.presentation" class="w-full p-3 border rounded-md">
                    <option value="">📏 Product Presentation</option>
                    <option value="Unit">Unit</option>
                    <option value="Gram">Gram</option>
                    <option value="Kilogram">Kilogram</option>
                    <option value="Pound">Pound</option>
                </select>

                <!-- Prices -->
                <input v-model="form.purchase_price" type="number" placeholder="💰 Purchase Price (Tax Included)" class="w-full p-3 border rounded-md">
                <input v-model="form.sale_price" type="number" placeholder="💲 Sale Price (Tax Included)" class="w-full p-3 border rounded-md">
                <input v-model="form.wholesale_price" type="number" placeholder="💲 Wholesale Price (Tax Included)" class="w-full p-3 border rounded-md">

                <!-- Discount -->
                <input v-model="form.discount" type="number" placeholder="🔻 Discount (%)" class="w-full p-3 border rounded-md">

                <!-- Brand and Model -->
                <input v-model="form.brand" type="text" placeholder="🏢 Brand" class="w-full p-3 border rounded-md">
                <input v-model="form.model" type="text" placeholder="📌 Model" class="w-full p-3 border rounded-md">

                <!-- 📌 Expiration -->
                <h4 class="font-semibold text-gray-800 dark:text-white">⏳ Product Expiration</h4>
                <select v-model="form.expires" class="w-full p-3 border rounded-md">
                    <option value="No">🚫 No Expiration</option>
                    <option value="Yes">✅ Yes, It Expires</option>
                </select>
                <input v-if="form.expires === 'Yes'" v-model="form.expiration_date" type="date" class="w-full p-3 border rounded-md">

                <!-- 📌 Factory Warranty -->
                <h4 class="font-semibold text-gray-800 dark:text-white">🛠️ Factory Warranty</h4>
                <select v-model="form.factory_warranty" class="w-full p-3 border rounded-md">
                    <option value="No">🚫 No Warranty</option>
                    <option value="Yes">✅ Has Warranty</option>
                </select>
                <div v-if="form.factory_warranty === 'Yes'">
                    <select v-model="form.warranty_unit" class="w-full p-3 border rounded-md">
                        <option value="">🕒 Select Time Unit</option>
                        <option value="Days">Days</option>
                        <option value="Months">Months</option>
                        <option value="Years">Years</option>
                    </select>
                    <input v-model="form.warranty_time" type="number" placeholder="⌛ Warranty Time" class="w-full p-3 border rounded-md">
                </div>

                <!-- 🟢 ACTION BUTTONS -->
                <div class="flex justify-between">
                    <button type="button" @click="resetForm" class="bg-gray-400 text-white px-4 py-2 rounded-md">🔄 Clear</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">💾 Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- 🟢 BEST SELLERS TABLE -->
    <div v-if="view === 'bestsellers'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">🔥 Best Sellers</h3>

        <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <thead>
            <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white">
                <th class="py-3 px-5">📦 Name</th>
                <th class="py-3 px-5">💲 Sale Price</th>
                <th class="py-3 px-5">🔥 Sold Quantity</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in bestSellers" :key="product.id">
                <td class="py-3 px-5">{{ product.name }}</td>
                <td class="py-3 px-5">${{ product.sale_price }}</td>
                <td class="py-3 px-5">{{ product.sold_quantity }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- 🟢 PRODUCTS BY CATEGORY -->
    <div v-if="view === 'by_category'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📂 Products by Category</h3>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="category in ['Video Games', 'Men’s Clothing', 'Gift Cards', 'Laptops', 'TVs', 'Blenders', 'Cameras', 'Cell Phones', 'Watches', 'Graphics Cards', 'Home', 'Motors', 'Bread']"
                 :key="category"
                 class="bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white p-4 rounded-lg text-center font-semibold shadow-md cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                {{ category }}
            </div>
        </div>
    </div>

    <!-- 🟢 PRODUCT LIST TABLE - GENERAL INFO -->
    <div v-if="view === 'list'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Product List</h3>

        <!-- 📌 TABLE 1 - General Information -->
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">🔹 General Information</h4>
        <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
            <thead>
            <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white">
                <th class="py-3 px-5">📌 Code</th>
                <th class="py-3 px-5">🔢 SKU</th>
                <th class="py-3 px-5">📦 Name</th>
                <th class="py-3 px-5">📊 Stock</th>
                <th class="py-3 px-5">⚠️ Min Stock</th>
                <th class="py-3 px-5">📍 Status</th>
                <th class="py-3 px-5">⚙️ Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td class="py-3 px-5">{{ product.code }}</td>
                <td class="py-3 px-5">{{ product.sku }}</td>
                <td class="py-3 px-5">{{ product.name }}</td>
                <td class="py-3 px-5">{{ product.stock }}</td>
                <td class="py-3 px-5">{{ product.min_stock }}</td>
                <td class="py-3 px-5">
                    <span :class="product.status === 'Enabled' ? 'bg-green-500' : 'bg-red-500'" class="text-white px-3 py-1 rounded-lg text-sm">
                        {{ product.status }}
                    </span>
                </td>
                <td class="py-3 px-5">
                    <button @click="editProduct(product)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                        ✏️ Edit
                    </button>
                    <button @click="deleteProduct(product.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                        🗑️ Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- 📌 TABLE 2 - Pricing & Extra Info -->
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">💰 Pricing & Extra Info</h4>
        <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <thead>
            <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white">
                <th class="py-3 px-5">💰 Purchase Price</th>
                <th class="py-3 px-5">💲 Sale Price</th>
                <th class="py-3 px-5">💲 Wholesale Price</th>
                <th class="py-3 px-5">🔻 Discount</th>
                <th class="py-3 px-5">🏢 Brand</th>
                <th class="py-3 px-5">📌 Model</th>
                <th class="py-3 px-5">⏳ Expiration</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td class="py-3 px-5">${{ product.purchase_price }}</td>
                <td class="py-3 px-5">${{ product.sale_price }}</td>
                <td class="py-3 px-5">${{ product.wholesale_price }}</td>
                <td class="py-3 px-5">{{ product.discount }}%</td>
                <td class="py-3 px-5">{{ product.brand }}</td>
                <td class="py-3 px-5">{{ product.model }}</td>
                <td class="py-3 px-5">
                    <span v-if="product.expires === 'Yes'">✅ {{ product.expiration_date }}</span>
                    <span v-else>🚫 No Expiration</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>
