<template>
    <div class="content">
        <b-card>
            <ul>
                <li><router-link to="/admin/create-human">Create Human Tool</router-link></li>
                <li><router-link to="/admin/edit-human">Edit Human Tool</router-link></li>
                <li><router-link to="/admin/user-human-linker">User-Human Linker Tool</router-link></li>
                <li><router-link to="/admin/mass-upload-runs">Mass Run Uploader</router-link></li>
                <li><router-link to="/admin/mass-upload-humans">Mass Human Uploader</router-link></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </b-card>
    </div>
</template>
<script>

export default {
    
}

</script>
