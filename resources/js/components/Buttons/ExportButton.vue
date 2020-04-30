<template>
    <v-menu offset-y>
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" block>
                <span class="mr-2">Export</span>
                <v-icon>mdi-chevron-down</v-icon>
            </v-btn>
        </template>
        <v-list>
            <v-list-item
                v-for="(item, index) in [
                    { title: 'Click Me' },
                    { title: 'Click Me' },
                    { title: 'Click Me' }
                ]"
                :key="index"
                @click="() => {}"
            >
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>
export default {
    name: "ExportButton"
};
</script>
