<template>
    <footer class="bg-gray-800 text-white text-center p-6 mt-6">
        <p class="text-sm">&copy; {{ year }} - Mi Proyecto. Todos los derechos reservados.</p>
        <p class="mt-2 text-lg">
            Creado por
            <a href="https://arangoportfolio.netlify.app/" target="_blank" class="text-blue-400 hover:text-blue-600 hover:underline transition duration-300">Josue Arango</a>
        </p>

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
    position: relative;
    width: 100%;
}

footer:hover{
    cursor: pointer;
}
footer a {
    text-decoration: none;
    color: inherit;
}
footer .hover\:text-blue-600:hover {
    color: #2563eb;
}
</style>
