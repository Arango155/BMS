<template>

    <footer class="bg-gray-50 text-black p-6 mt-6 flex flex-wrap justify-between text-sm">
        <div class="flex flex-col items-start">
            <div class="flex items-center gap-2">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="BMS Logo" class="h-8">
                <span class="text-lg font-semibold">BMS</span>
            </div>
            <ul class="mt-2">
                <li><a href="#" class="hover:text-gray-600"> Home</a></li>
                <li><a href="#" class="hover:text-gray-600"> Services</a></li>
                <li><a href="#" class="hover:text-gray-600"> About Us</a></li>
                <li><a href="#" class="hover:text-gray-600"> Open Source</a></li>
            </ul>
            <div class="flex gap-4 mt-2">
                <a href="#" class="hover:text-gray-600">📘</a>
                <a href="#" class="hover:text-gray-600">🐦</a>
                <a href="#" class="hover:text-gray-600">🔗</a>
                <a href="#" class="hover:text-gray-600">📸</a>
            </div>
        </div>

        <div class="flex flex-wrap gap-8 mt-4">
            <div>
                <h3 class="text-lg font-semibold">🏢 Company</h3>
                <ul>
                    <li><a href="#" class="hover:text-gray-600"> About us</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Careers</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Security</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Status</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Terms & privacy</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold">📚 Resources</h3>
                <ul>
                    <li><a href="#" class="hover:text-gray-600"> Help center</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Pricing</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Blog</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Community</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Integrations</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Templates</a></li>
                    <li><a href="#" class="hover:text-gray-600"> Affiliates</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-4 text-right">
            <p class="text-sm"> Do Not Sell or Share My Info | <a href="#" class="hover:text-gray-600"> Cookie settings</a></p>
            <a href="#" class="hover:text-gray-600 text-lg font-semibold">🌎 Explore more →</a>
        </div>
    </footer>
</template>

<script>
export default {
    data() {
        return {
            year: new Date().getFullYear(),
        };
    },
};
</script>

<style scoped>
footer {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    font-family: "Inter", sans-serif;
}
footer:hover {
    cursor: pointer;
}
footer a {
    text-decoration: none;
    color: inherit;
}
footer .hover\:text-gray-600:hover {
    color: #4b5563;
}
hr {
    border-top: 1px solid #d1d5db;
}
</style>
