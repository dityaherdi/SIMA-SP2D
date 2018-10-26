<template>
    <div>
        <h1>ini dashboard</h1>
        <div v-if="this.isAdmin()">
            <p>Admin</p>
        </div>
        <div v-if="this.isMaster()">
            <p>Master</p>
        </div>
        <div v-if="this.isPimpinan()">
            <p>Pimpinan</p>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

